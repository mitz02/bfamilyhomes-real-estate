<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Testimonial;
use App\Models\Inquiry;
use App\Models\Notification;
use App\Models\User;
use App\Models\Payment;
use App\Models\Blog;
use App\Models\Promotion;
use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProperties = Property::approved()
            ->featured()
            ->available()
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->take(8)
            ->get();

        $latestProperties = Property::approved()
            ->available()
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->take(12)
            ->get();

        $testimonials = Testimonial::published()
            ->with('user')
            ->latest()
            ->take(6)
            ->get();

        // If no testimonials, create sample ones with Nigerian names and images
        if ($testimonials->isEmpty()) {
            $testimonials = collect([
                (object)[
                    'id' => 1,
                    'content' => 'B-Family Homes helped us find our dream home in Awkuzu! The process was smooth and the team was very professional. I highly recommend their services to anyone looking for property in Anambra State.',
                    'rating' => 5,
                    'user' => (object)['name' => 'Chinwe Okafor', 'avatar' => 'https://i.pravatar.cc/300?img=47'],
                    'created_at' => now()->subDays(5),
                ],
                (object)[
                    'id' => 2,
                    'content' => 'I purchased land through B-Family Homes and the documentation process was seamless. They provided all necessary documents including survey plan and deed of assignment. Their transparency and professionalism is commendable.',
                    'rating' => 5,
                    'user' => (object)['name' => 'Adebayo Adeyemi', 'avatar' => 'https://i.pravatar.cc/300?img=33'],
                    'created_at' => now()->subDays(10),
                ],
                (object)[
                    'id' => 3,
                    'content' => 'As someone living in the diaspora, investing with B-Family Homes has been excellent. They send regular updates on construction progress and I can inspect my property anytime. The 50/50 building plan made it easy for me to own a home in Nigeria.',
                    'rating' => 5,
                    'user' => (object)['name' => 'Ngozi Eze', 'avatar' => 'https://i.pravatar.cc/300?img=20'],
                    'created_at' => now()->subDays(15),
                ],
                (object)[
                    'id' => 4,
                    'content' => 'Working with B-Family Homes as an agent has been a great experience. The platform is user-friendly and their support team is always ready to help. I have successfully listed and sold multiple properties through them.',
                    'rating' => 4,
                    'user' => (object)['name' => 'Emeka Nwankwo', 'avatar' => 'https://i.pravatar.cc/300?img=12'],
                    'created_at' => now()->subDays(20),
                ],
                (object)[
                    'id' => 5,
                    'content' => 'I found a beautiful rental property through B-Family Homes. The agent was responsive and made the entire process hassle-free. The property was exactly as described and the location is perfect for my family.',
                    'rating' => 5,
                    'user' => (object)['name' => 'Amina Mohammed', 'avatar' => 'https://i.pravatar.cc/300?img=32'],
                    'created_at' => now()->subDays(25),
                ],
                (object)[
                    'id' => 6,
                    'content' => 'Professional, reliable, and trustworthy. B-Family Homes exceeded our expectations in every way. Their partnership with OJB Construction ensures quality buildings. Thank you for making property ownership accessible!',
                    'rating' => 5,
                    'user' => (object)['name' => 'Olumide Bello', 'avatar' => 'https://i.pravatar.cc/300?img=1'],
                    'created_at' => now()->subDays(30),
                ],
            ]);
        }
        
        // Ensure all testimonials have user objects with avatars
        $testimonials = $testimonials->map(function($testimonial) {
            if (!isset($testimonial->user) || !is_object($testimonial->user)) {
                $testimonial->user = (object)['name' => 'User', 'avatar' => 'https://i.pravatar.cc/300?img=' . rand(1, 70)];
            } elseif (!isset($testimonial->user->avatar) || empty($testimonial->user->avatar)) {
                $testimonial->user->avatar = 'https://i.pravatar.cc/300?img=' . rand(1, 70);
            }
            return $testimonial;
        });
        
        // Take first 5 testimonials for display
        $testimonials = $testimonials->take(5);

        // Statistics for the stats section
        $stats = [
            'total_agents' => User::where('role', 'agent')->where('status', 'active')->whereNotNull('agent_approved_at')->count() ?: 893,
            'total_sales' => Payment::where('status', 'approved')->count() ?: 1765,
            'total_projects' => Property::approved()->count() ?: 846,
            'happy_customers' => User::where('role', 'user')->where('status', 'active')->count() ?: 7253,
        ];

        // Category statistics
        $commercialLands = Property::approved()->where(function($q) {
            $q->where('category', 'like', '%Commercial%')
              ->orWhere('category', 'like', '%Land%');
        })->count();
        
        $showroomsShops = Property::approved()->where('category', 'like', '%Commercial%')->count();
        $officeRooms = Property::approved()->where('category', 'like', '%Office%')->count();
        
        $residential = Property::approved()->where(function($q) {
            $q->where('category', 'like', '%Apartment%')
              ->orWhere('category', 'like', '%House%')
              ->orWhere('category', 'like', '%Villa%');
        })->count();

        $categoryStats = [
            'commercial_lands' => $commercialLands > 0 ? $commercialLands : 1200,
            'showrooms_shops' => $showroomsShops > 0 ? $showroomsShops : 894,
            'office_rooms' => $officeRooms > 0 ? $officeRooms : 1089,
            'residential' => $residential > 0 ? $residential : 789,
        ];

        // Best Property Collections - get properties by different categories
        $allProperties = Property::approved()->available()->orderBy('created_at', 'desc')->orderBy('id', 'desc')->take(12)->get();
        $properties2bhk = Property::approved()->available()->where(function($q) {
            $q->where('bedrooms', 2)->orWhere('category', 'like', '%2BHK%');
        })->orderBy('created_at', 'desc')->orderBy('id', 'desc')->take(12)->get();
        $propertiesVillas = Property::approved()->available()->where('category', 'like', '%Villa%')->orderBy('created_at', 'desc')->orderBy('id', 'desc')->take(12)->get();
        $propertiesApartments = Property::approved()->available()->where('category', 'like', '%Apartment%')->orderBy('created_at', 'desc')->orderBy('id', 'desc')->take(12)->get();
        $propertiesDuplex = Property::approved()->available()->where('category', 'like', '%Duplex%')->orderBy('created_at', 'desc')->orderBy('id', 'desc')->take(12)->get();
        
        // Get categories from database with counts (limit to 4)
        $categoriesFromDb = Property::approved()
            ->available()
            ->selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->take(4)
            ->get()
            ->map(function($item) {
                // Get a sample image from a property in this category
                $sampleProperty = Property::approved()
                    ->available()
                    ->where('category', $item->category)
                    ->first();
                
                // Get image from property or use category-specific default images
                $image = $sampleProperty && $sampleProperty->first_image 
                    ? $sampleProperty->first_image 
                    : $this->getCategoryDefaultImage($item->category);
                
                // Determine color based on category
                $colors = [
                    'Apartment' => 'primary',
                    'House' => 'accent',
                    'Villa' => 'primary-600',
                    'Duplex' => 'accent-dark',
                    'Commercial' => 'primary-500',
                    'Office' => 'accent',
                    'Land' => 'primary-600',
                ];
                
                $color = 'primary';
                foreach ($colors as $key => $col) {
                    if (stripos($item->category, $key) !== false) {
                        $color = $col;
                        break;
                    }
                }
                
                return [
                    'name' => $item->category,
                    'count' => $item->count,
                    'image' => $image,
                    'color' => $color,
                ];
            });

        // Best Property Collections - get properties by tags
        // For SQLite compatibility, we'll filter in PHP after fetching
        $allProperties = Property::approved()
            ->available()
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->take(20)
            ->get()
            ->filter(function($property) {
                $tags = $property->tags ?? [];
                return $property->is_featured || in_array('best_collection', $tags);
            })
            ->take(12);
        
        $properties2bhk = Property::approved()
            ->available()
            ->where(function($q) {
                $q->where('bedrooms', 2)
                  ->orWhere('category', 'like', '%2BHK%');
            })
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->take(20)
            ->get()
            ->filter(function($property) {
                $tags = $property->tags ?? [];
                return $property->is_featured || in_array('best_collection', $tags);
            })
            ->take(12);
        
        $propertiesVillas = Property::approved()
            ->available()
            ->where('category', 'like', '%Villa%')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->take(20)
            ->get()
            ->filter(function($property) {
                $tags = $property->tags ?? [];
                return $property->is_featured || in_array('best_collection', $tags);
            })
            ->take(12);
        
        $propertiesApartments = Property::approved()
            ->available()
            ->where('category', 'like', '%Apartment%')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->take(20)
            ->get()
            ->filter(function($property) {
                $tags = $property->tags ?? [];
                return $property->is_featured || in_array('best_collection', $tags);
            })
            ->take(12);
        
        $propertiesDuplex = Property::approved()
            ->available()
            ->where('category', 'like', '%Duplex%')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->take(20)
            ->get()
            ->filter(function($property) {
                $tags = $property->tags ?? [];
                return $property->is_featured || in_array('best_collection', $tags);
            })
            ->take(12);
        
        $bestCollections = [
            'all' => $allProperties->isEmpty() ? $latestProperties : $allProperties,
            '2bhk' => $properties2bhk->isEmpty() ? $latestProperties : $properties2bhk,
            'villas' => $propertiesVillas->isEmpty() ? $latestProperties : $propertiesVillas,
            'apartments' => $propertiesApartments->isEmpty() ? $latestProperties : $propertiesApartments,
            'duplex' => $propertiesDuplex->isEmpty() ? $latestProperties : $propertiesDuplex,
        ];

        // Latest blog posts
        $latestBlogs = Blog::published()
            ->with('author')
            ->latest()
            ->take(3)
            ->get();

        // Get active promotion
        $promotion = Promotion::where('is_active', true)->first();

        return view('home', compact('featuredProperties', 'latestProperties', 'testimonials', 'stats', 'categoryStats', 'bestCollections', 'categoriesFromDb', 'latestBlogs', 'promotion'));
    }

    private function getCategoryDefaultImage($category)
    {
        // Map categories to appropriate property images from Unsplash
        $categoryImages = [
            'Apartment' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600&q=80',
            'House' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=600&q=80',
            'Villa' => 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=600&q=80',
            'Duplex' => 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=600&q=80',
            'Commercial' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=600&q=80',
            'Office' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&q=80',
            'Land' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=600&q=80',
        ];
        
        foreach ($categoryImages as $key => $image) {
            if (stripos($category, $key) !== false) {
                return $image;
            }
        }
        
        // Default property image
        return 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600&q=80';
    }

    public function about()
    {
        return view('pages.about');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function refund()
    {
        return view('pages.refund');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function submitContact(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'required|string',
                'subject' => 'nullable|string',
                'message' => 'required|string',
            ]);

            $inquiry = Inquiry::create([
                'user_id' => auth()->id(),
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'subject' => $validated['subject'] ?? 'General Inquiry',
                'message' => $validated['message'],
                'status' => 'new',
            ]);

            // Notify all admins
            $admins = \App\Models\User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::createNotification(
                    $admin->id,
                    'new_contact_message',
                    'New Contact Message',
                    "New message from {$validated['name']}: " . Str::limit($validated['message'], 50),
                    $inquiry,
                    'bi-envelope-fill',
                    'info'
                );

                // Email the admin the full contact form details
                try {
                    Mail::to($admin->email)->send(new ContactFormMail([
                        'name' => $validated['name'],
                        'email' => $validated['email'],
                        'phone' => $validated['phone'],
                        'subject' => $validated['subject'] ?? 'General Inquiry',
                        'message' => $validated['message'],
                    ]));
                } catch (\Exception $e) {
                    Log::warning('Failed to email admin contact form submission', [
                        'admin_id' => $admin->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Thank you for contacting us! We will get back to you soon.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message. Please try again.',
            ], 500);
        }
    }
}
