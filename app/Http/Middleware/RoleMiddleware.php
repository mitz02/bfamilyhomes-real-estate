<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated',
                ], 401);
            }
            return redirect()->route('home')->with('error', 'Please login to continue');
        }

        $user = auth()->user();

        // Check if user is blocked
        if ($user->isBlocked()) {
            auth()->logout();
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your account has been blocked',
                ], 403);
            }
            return redirect()->route('home')->with('error', 'Your account has been blocked');
        }

        // Check if user has the required role
        if ($user->role !== $role) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access',
                ], 403);
            }
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }

        // For agent role, check if approved
        if ($role === 'agent' && !$user->agent_approved_at && $user->status === 'pending') {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your agent account is pending approval',
                ], 403);
            }
            return redirect()->route('dashboard')->with('error', 'Your agent account is pending approval');
        }

        // For investor role, check if approved
        // Only block if status is pending AND not approved
        if ($role === 'investor' && $user->status === 'pending' && !$user->investor_approved_at) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your investor account is pending approval',
                ], 403);
            }
            return redirect()->route('dashboard')->with('error', 'Your investor account is pending approval');
        }
        
        // Allow active investors to access even if investor_approved_at is not set (for backward compatibility)
        if ($role === 'investor' && $user->status === 'active' && !$user->investor_approved_at) {
            // Auto-approve active investors who don't have approval timestamp
            $user->update(['investor_approved_at' => now()]);
        }

        return $next($request);
    }
}
