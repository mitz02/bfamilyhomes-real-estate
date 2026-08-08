<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use App\Mail\VerifyEmailMail;
use App\Mail\PasswordResetMail;
use App\Mail\WelcomeMail;
use App\Support\AdminNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        try {
            // Honeypot check: reject if hidden field was filled by bot
            if (!empty($request->input('website'))) {
                return response()->json([
                    'success' => true,
                    'message' => 'Registration successful!',
                    'redirect' => route('verify.instructions'),
                ]);
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => [
                    'required', 'string', 'email', 'max:255', 'unique:users',
                    function ($attribute, $value, $fail) {
                        $domain = substr(strrchr($value, '@'), 1);
                        $disposable = [
                            'mailinator.com', 'guerrillamail.com', 'guerrillamail.net', 'guerrillamail.org',
                            'guerrillamail.biz', '10minutemail.com', '10minutemail.net', '10minutemail.org',
                            'temp-mail.org', 'tempmail.com', 'tempmail.net', 'tempmail.org',
                            'throwaway.email', 'throwawaymail.com', 'yopmail.com', 'yopmail.net',
                            'sharklasers.com', 'grr.la', 'spam4.me', 'meltmail.com',
                            'maildrop.cc', 'getairmail.com', 'getnada.com', 'mailmetrash.com',
                            'dispostable.com', 'mailexpire.com', 'mailcatch.com', 'fakeinbox.com',
                            'trashmail.com', 'trashmail.net', 'trashmail.org', 'trashmail.ws',
                            'mytrashmail.com', 'luxusmail.org', 'mailnator.com', 'mailinator.net',
                            'mailinator.org', 'mailinator.us', 'mailinator2.com', 'sogetthis.com',
                            'spambox.us', 'maileater.com', 'mailexpire.com', 'emailthe.net',
                            'spamgourmet.com', 'spamfree24.org', 'spamfree24.info', 'spamfree24.net',
                            'zippymail.info', 'mycleaninbox.com', 'mailforspam.com', 'mailline.org',
                        ];
                        if (in_array(strtolower($domain), $disposable)) {
                            $fail('Disposable email addresses are not allowed.');
                        }
                    },
                ],
                'phone' => 'required|string|max:20|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|in:user,agent,investor',
            ]);

            // Cloudflare Turnstile verification (optional — skip if not configured)
            if ($secretKey = config('services.turnstile.secret_key')) {
                $request->validate(['cf-turnstile-response' => 'required']);
                $turnstileResponse = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                    'secret' => $secretKey,
                    'response' => $request->input('cf-turnstile-response'),
                    'remoteip' => $request->ip(),
                ]);
                if (!$turnstileResponse->json('success')) {
                    throw ValidationException::withMessages([
                        'cf-turnstile-response' => 'CAPTCHA verification failed. Please try again.',
                    ]);
                }
            }

            // Determine initial status based on role
            $role = $validated['role'];
            $status = 'active';
            $investorRequestedAt = null;
            $agentRequestedAt = null;

            // If registering as investor, set request timestamp
            if ($role === 'investor') {
                $investorRequestedAt = now();
                $status = 'pending'; // Pending until admin approves
            }

            // If registering as agent, set pending status and request timestamp
            if ($role === 'agent') {
                $agentRequestedAt = now();
                $status = 'pending'; // Pending until admin approves
            }

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => $validated['password'], // The 'hashed' cast in User model will automatically hash it
                'role' => $role,
                'status' => $status,
                'verification_token' => Str::random(60),
                'investor_requested_at' => $investorRequestedAt,
                'agent_requested_at' => $agentRequestedAt,
                'agent_approved_at' => null,
            ]);

            // Send verification email
            try {
                $verificationUrl = route('verify.email', ['token' => $user->verification_token]);
                Mail::to($user->email)->send(new VerifyEmailMail($user, $verificationUrl));
                Log::info('Verification email sent', ['email' => $user->email, 'url' => $verificationUrl]);
            } catch (\Exception $e) {
                Log::error('Failed to send verification email: ' . $e->getMessage(), [
                    'email' => $user->email,
                    'user_id' => $user->id,
                ]);
                // Don't fail registration if email fails
            }

            // Notify admin of new registration
            $admin = User::where('role', 'admin')->first();
            if ($admin) {
                if ($role === 'agent') {
                    Notification::createNotification(
                        $admin->id,
                        'upgrade_request',
                        'New Agent Registration',
                        "{$user->name} ({$user->email}) has requested to become an agent.",
                        $user,
                        'bi-person-badge',
                        'warning'
                    );
                } elseif ($role === 'investor') {
                    Notification::createNotification(
                        $admin->id,
                        'upgrade_request',
                        'New Investor Registration',
                        "{$user->name} ({$user->email}) has requested to become an investor.",
                        $user,
                        'bi-graph-up-arrow',
                        'warning'
                    );
                } else {
                    Notification::createNotification(
                        $admin->id,
                        'new_user',
                        'New User Registration',
                        "{$user->name} ({$user->email}) has registered as a user.",
                        $user,
                        'bi-person-plus',
                        'info'
                    );
                }
            }

            // Email admin about the new registration
            if ($role === 'agent' || $role === 'investor') {
                AdminNotifier::notify(
                    'upgrade_request',
                    'New ' . ucfirst($role) . ' Registration',
                    "<strong>{$user->name}</strong> ({$user->email}) registered as a " . $role . " and is awaiting your approval.",
                    [
                        'Name' => $user->name,
                        'Email' => $user->email,
                        'Phone' => $user->phone,
                        'Role Requested' => ucfirst($role),
                        'Registered At' => now()->format('M d, Y h:i A'),
                    ],
                    route('admin.users'),
                    'Review Registration'
                );
            } else {
                AdminNotifier::notify(
                    'registration',
                    'New User Registration',
                    "<strong>{$user->name}</strong> ({$user->email}) has registered as a user on B-Family Homes.",
                    [
                        'Name' => $user->name,
                        'Email' => $user->email,
                        'Phone' => $user->phone,
                        'Registered At' => now()->format('M d, Y h:i A'),
                    ],
                    route('admin.users'),
                    'View Users'
                );
            }

            // Store user info in session for verification page
            session([
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_role' => $user->role,
                'requires_approval' => ($user->role === 'agent' || $user->role === 'investor'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Registration successful!',
                'user' => $user,
                'redirect' => route('verify.instructions'),
            ]);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            // Get the first error message from all validation errors
            $firstError = collect($errors)->flatten()->first();
            
            return response()->json([
                'success' => false,
                'message' => $firstError ?: 'Validation failed. Please check your input.',
                'errors' => $errors,
            ], 422);
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: 'Registration failed. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::where('email', $credentials['email'])->first();

            // Check if user exists
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'The provided credentials are incorrect.',
                    'errors' => ['email' => ['The provided credentials are incorrect.']],
                ], 422);
            }

            // Check password before checking status (to avoid revealing account status)
            if (!Hash::check($credentials['password'], $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'The provided credentials are incorrect.',
                    'errors' => ['password' => ['The provided credentials are incorrect.']],
                ], 422);
            }

            // Check if email is verified (only for regular users, agents and investors may need admin approval first)
            if (!$user->email_verified_at && $user->role === 'user') {
                return response()->json([
                    'success' => false,
                    'message' => 'Please verify your email address before logging in. Check your inbox for the verification link.',
                    'requires_verification' => true,
                ], 403);
            }

            // Now check account status after password is verified
            if ($user->isBlocked()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your account has been blocked. Please contact support for assistance.',
                ], 403);
            }

            // Check if user is pending approval (agent or investor)
            if ($user->status === 'pending') {
                if ($user->role === 'agent' && !$user->agent_approved_at) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Your agent account is pending admin approval. Please wait for approval before logging in.',
                    ], 403);
                }
                if ($user->role === 'investor' && !$user->investor_approved_at) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Your investor account is pending admin approval. Please wait for approval before logging in.',
                    ], 403);
                }
                // If pending but not agent/investor, treat as inactive
                if ($user->role === 'user') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Your account is pending activation. Please contact support.',
                    ], 403);
                }
            }
            
            // Final check: ensure account is active
            if ($user->status !== 'active') {
                return response()->json([
                    'success' => false,
                    'message' => 'Your account is not activated. Please contact support to activate your account.',
                ], 403);
            }
            
            // If investor is active but doesn't have approval timestamp, set it (backward compatibility)
            if ($user->role === 'investor' && $user->status === 'active' && !$user->investor_approved_at) {
                $user->update(['investor_approved_at' => now()]);
            }

            // All checks passed, login the user
            Auth::login($user, $request->boolean('remember'));

            // Determine redirect based on role - always prioritize role-based redirect
            // Check for redirect parameter, but only use it if user is a regular user
            $redirectParam = $request->input('redirect');
            
            // Always redirect admins to admin dashboard, regardless of redirect parameter
            if ($user->isAdmin()) {
                $redirect = route('admin.dashboard');
            } elseif ($user->isAgent()) {
                $redirect = route('agent.dashboard');
            } elseif ($user->isInvestor()) {
                $redirect = route('investor.dashboard');
            } elseif ($redirectParam && filter_var($redirectParam, FILTER_VALIDATE_URL)) {
                // Only use redirect parameter for regular users and if it's a valid URL
                $redirect = $redirectParam;
            } else {
                $redirect = route('dashboard');
            }

            return response()->json([
                'success' => true,
                'message' => 'Login successful!',
                'user' => $user,
                'redirect' => $redirect,
            ]);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            $firstError = collect($errors)->flatten()->first();
            
            return response()->json([
                'success' => false,
                'message' => $firstError ?: 'Invalid credentials. Please check your email and password.',
                'errors' => $errors,
            ], 422);
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['password'])
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Login failed. Please try again later.',
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully!',
            'redirect' => route('home'),
        ]);
    }

    public function resendVerification(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ]);

            $user = User::where('email', $request->email)->first();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email not found',
                ], 422);
            }

            // Check if already verified
            if ($user->email_verified_at) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email is already verified. You can login now.',
                ], 422);
            }

            // Generate new token if needed
            if (!$user->verification_token) {
                $user->verification_token = Str::random(60);
                $user->save();
            }

            // Send verification email
            try {
                $verificationUrl = route('verify.email', ['token' => $user->verification_token]);
                Mail::to($user->email)->send(new VerifyEmailMail($user, $verificationUrl));
                Log::info('Verification email resent', ['email' => $user->email]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Verification email sent! Please check your inbox.',
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to resend verification email: ' . $e->getMessage(), [
                    'email' => $user->email,
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send verification email. Please try again later.',
                ], 500);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Email not found',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Resend verification error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to process request',
            ], 500);
        }
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ]);

            $user = User::where('email', $request->email)->first();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email not found',
                ], 422);
            }

            // Generate token
            $token = Str::random(64);
            
            // Store or update reset token
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                [
                    'token' => Hash::make($token),
                    'created_at' => now(),
                ]
            );
            
            // Generate reset URL
            $resetUrl = route('password.reset', ['token' => $token, 'email' => $request->email]);
            
            // Send password reset email
            try {
                Mail::to($user->email)->send(new PasswordResetMail($user, $resetUrl));
                Log::info('Password reset email sent', [
                    'email' => $request->email,
                    'url' => $resetUrl,
                ]);
                
                $message = 'Password reset link sent to your email!';
                $debugInfo = config('app.debug') ? ['reset_url' => $resetUrl] : [];
            } catch (\Exception $e) {
                Log::error('Failed to send password reset email: ' . $e->getMessage(), [
                    'email' => $request->email,
                ]);
                
                // In development, still show the link if email fails
                if (config('app.debug')) {
                    $message = "Email service unavailable. Reset link: {$resetUrl}";
                    $debugInfo = ['reset_url' => $resetUrl];
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to send reset email. Please try again later.',
                    ], 500);
                }
            }
            
            return response()->json(array_merge([
                'success' => true,
                'message' => $message,
            ], $debugInfo));
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Email not found',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Forgot password error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to process password reset request',
            ], 500);
        }
    }

    public function verifyEmail($token)
    {
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return redirect()->route('home')->with('error', 'Invalid verification token.');
        }

        // Check if already verified
        if ($user->email_verified_at) {
            return redirect()->route('login')->with('info', 'Email already verified. Please login.');
        }

        $user->update([
            'email_verified_at' => now(),
            'verification_token' => null,
        ]);

        // Send welcome email
        try {
            Mail::to($user->email)->send(new WelcomeMail($user));
            Log::info('Welcome email sent', ['email' => $user->email]);
        } catch (\Exception $e) {
            Log::error('Failed to send welcome email: ' . $e->getMessage(), [
                'email' => $user->email,
                'user_id' => $user->id,
            ]);
            // Don't fail verification if welcome email fails
        }

        // Only auto-login if account is active
        if ($user->status === 'active') {
            Auth::login($user);

            // Redirect based on role
            $redirect = route('dashboard');
            if ($user->isAdmin()) {
                $redirect = route('admin.dashboard');
            } elseif ($user->isAgent()) {
                $redirect = route('agent.dashboard');
            } elseif ($user->isInvestor()) {
                $redirect = route('investor.dashboard');
            }

            return redirect($redirect)->with('success', 'Email verified successfully! Welcome to B-Family Homes!');
        } else {
            // If pending approval (agent/investor), don't login
            return redirect()->route('login')->with('success', 'Email verified successfully! Please wait for admin approval before logging in.');
        }
    }

    public function showResetPassword(Request $request, $token)
    {
        $email = $request->query('email');
        
        // Verify token is valid
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();
        
        if (!$resetRecord || !Hash::check($token, $resetRecord->token)) {
            return redirect()->route('password.request')
                ->with('error', 'Invalid or expired password reset token.');
        }
        
        // Check if token is expired (60 minutes)
        if (now()->diffInMinutes($resetRecord->created_at) > 60) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return redirect()->route('password.request')
                ->with('error', 'Password reset token has expired. Please request a new one.');
        }
        
        return view('auth.reset-password', compact('token', 'email'));
    }

    public function resetPassword(Request $request)
    {
        try {
            $validated = $request->validate([
                'token' => 'required',
                'email' => 'required|email|exists:users,email',
                'password' => 'required|min:8|confirmed',
            ]);

            // Verify token
            $resetRecord = DB::table('password_reset_tokens')
                ->where('email', $validated['email'])
                ->first();
            
            if (!$resetRecord || !Hash::check($validated['token'], $resetRecord->token)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or expired password reset token.',
                ], 422);
            }
            
            // Check if token is expired (60 minutes)
            if (now()->diffInMinutes($resetRecord->created_at) > 60) {
                DB::table('password_reset_tokens')->where('email', $validated['email'])->delete();
                return response()->json([
                    'success' => false,
                    'message' => 'Password reset token has expired. Please request a new one.',
                ], 422);
            }
            
            // Update user password
            $user = User::where('email', $validated['email'])->first();
            $user->password = $validated['password']; // The 'hashed' cast will automatically hash it
            $user->save();
            
            // Delete reset token
            DB::table('password_reset_tokens')->where('email', $validated['email'])->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Password reset successfully! You can now login with your new password.',
                'redirect' => route('login'),
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Reset password error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to reset password',
            ], 500);
        }
    }
}
