<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Property;
use App\Models\Inspection;
use App\Models\Payment;
use App\Models\Investment;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // -------------------------
        // Create Super Admin
        // -------------------------
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@bfamilyhomes.com',
            'phone' => '+2348012345678',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // -------------------------
        // Create Regular Users
        // -------------------------
        $users = [];
        for ($i = 1; $i <= 10; $i++) {
            $users[] = User::create([
                'name' => "User {$i}",
                'email' => "user{$i}@bfamilyhomes.com",
                'phone' => '+2348012345' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
        }

        // -------------------------
        // Create Approved Agents
        // -------------------------
        $agents = [];
        for ($i = 1; $i <= 5; $i++) {
            $agents[] = User::create([
                'name' => "Agent {$i}",
                'email' => "agent{$i}@bfamilyhomes.com",
                'phone' => '+2348022345' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'password' => Hash::make('password'),
                'role' => 'agent',
                'status' => 'active',
                'email_verified_at' => now(),
                'agent_requested_at' => now()->subDays(10),
                'agent_approved_at' => now()->subDays(5),
            ]);
        }

        // -------------------------
        // Create Pending Agents
        // -------------------------
        for ($i = 1; $i <= 2; $i++) {
            User::create([
                'name' => "Pending Agent {$i}",
                'email' => "pendingagent{$i}@bfamilyhomes.com",
                'phone' => '+2348032345' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'password' => Hash::make('password'),
                'role' => 'agent',
                'status' => 'pending',
                'agent_requested_at' => now()->subDays(2),
                'agent_approved_at' => null,
            ]);
        }

        // -------------------------
        // Create Approved Investors
        // -------------------------
        $investors = [];
        for ($i = 1; $i <= 5; $i++) {
            $investors[] = User::create([
                'name' => "Investor {$i}",
                'email' => "investor{$i}@bfamilyhomes.com",
                'phone' => '+2348042345' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'password' => Hash::make('password'),
                'role' => 'investor',
                'status' => 'active',
                'email_verified_at' => now(),
                'investor_requested_at' => now()->subDays(10),
                'investor_approved_at' => now()->subDays(5),
            ]);
        }

        // -------------------------
        // Create Pending Investors
        // -------------------------
        for ($i = 1; $i <= 2; $i++) {
            User::create([
                'name' => "Pending Investor {$i}",
                'email' => "pendinginvestor{$i}@bfamilyhomes.com",
                'phone' => '+2348052345' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'password' => Hash::make('password'),
                'role' => 'investor',
                'status' => 'pending',
                'investor_requested_at' => now()->subDays(2),
                'investor_approved_at' => null,
            ]);
        }

        // -------------------------
        // Create Blocked User
        // -------------------------
        User::create([
            'name' => 'Blocked User',
            'email' => 'blocked@bfamilyhomes.com',
            'phone' => '+2348062345000',
            'password' => Hash::make('password'),
            'role' => 'user',
            'status' => 'blocked',
        ]);

        // -------------------------
        // Create Properties
        // -------------------------
        $propertyTypes = ['Rent', 'Sale', 'Investment'];
        $categories = ['Apartment', 'House', 'Villa', 'Commercial', 'Land'];
        $locations = ['Lagos', 'Abuja', 'Port Harcourt', 'Kano', 'Ibadan'];

        foreach ($agents as $agent) {
            for ($i = 1; $i <= 3; $i++) {
                $type = $propertyTypes[array_rand($propertyTypes)];
                $category = $categories[array_rand($categories)];
                $location = $locations[array_rand($locations)];

                Property::create([
                    'agent_id' => $agent->id,
                    'title' => "Beautiful {$category} in {$location}",
                    'description' => "This is a stunning {$category} located in the heart of {$location}. Perfect for {$type}.",
                    'type' => $type,
                    'category' => $category,
                    'location' => $location,
                    'address' => "{$location} Street, {$location}",
                    'price' => rand(500000, 50000000),
                    'bedrooms' => rand(1, 5),
                    'bathrooms' => rand(1, 4),
                    'size' => rand(500, 5000),
                    'parking' => rand(0, 3),
                    'features' => ['Air Conditioning', 'Swimming Pool', 'Gym', 'Security'],
                    'images' => [],
                    'approval_status' => $i === 1 ? 'pending' : 'approved',
                    'is_featured' => $i === 3,
                    'views' => rand(10, 500),
                ]);
            }
        }

        // -------------------------
        // Create Inspections
        // -------------------------
        $inspectionTimes = ['09:00', '14:00', '16:00'];
        $inspectionStatuses = ['pending', 'confirmed', 'completed'];

        foreach ($users as $user) {
            $property = Property::where('approval_status', 'approved')->inRandomOrder()->first();
            if ($property) {
                Inspection::create([
                    'user_id' => $user->id,
                    'property_id' => $property->id,
                    'preferred_date' => now()->addDays(rand(1, 30)),
                    'preferred_time' => $inspectionTimes[array_rand($inspectionTimes)],
                    'status' => $inspectionStatuses[array_rand($inspectionStatuses)],
                    'message' => 'Interested in viewing this property',
                ]);
            }
        }

        // -------------------------
        // Create Payments
        // -------------------------
        $paymentStatuses = ['pending', 'approved', 'rejected'];
        $paymentTypes = ['purchase', 'rent', 'investment', 'installment'];

        foreach ($users as $user) {
            $property = Property::where('approval_status', 'approved')->inRandomOrder()->first();
            if ($property) {
                // Determine payment type based on property type
                $paymentType = match($property->type) {
                    'Sale' => 'purchase',
                    'Rent' => 'rent',
                    'Investment' => 'investment',
                    default => $paymentTypes[array_rand($paymentTypes)]
                };

                Payment::create([
                    'user_id' => $user->id,
                    'property_id' => $property->id,
                    'reference' => Payment::generateReference(),
                    'amount' => $property->price * 0.1, // 10% down payment
                    'type' => $paymentType,
                    'status' => $paymentStatuses[array_rand($paymentStatuses)],
                ]);
            }
        }

        // -------------------------
        // Create Investments
        // -------------------------
        $investmentStatuses = ['active', 'completed'];

        foreach ($investors as $investor) {
            $property = Property::where('type', 'Investment')->where('approval_status', 'approved')->inRandomOrder()->first();
            if ($property) {
                Investment::create([
                    'investor_id' => $investor->id,
                    'property_id' => $property->id,
                    'reference' => Investment::generateReference(),
                    'amount' => rand(1000000, 10000000),
                    'roi_percentage' => rand(10, 25),
                    'total_return' => 0,
                    'start_date' => now()->subMonths(rand(1, 6)),
                    'maturity_date' => now()->addMonths(rand(12, 36)),
                    'status' => $investmentStatuses[array_rand($investmentStatuses)],
                    'terms' => 'Standard investment terms apply',
                ]);
            }
        }

        // -------------------------
        // Create Testimonials
        // -------------------------
        foreach ($users as $index => $user) {
            if ($index < 6) {
                Testimonial::create([
                    'user_id' => $user->id,
                    'content' => "B-Family Homes made my property search so easy! The team was professional and helped me find my dream home. Highly recommended!",
                    'rating' => rand(4, 5),
                    'is_published' => true,
                ]);
            }
        }

        // -------------------------
        // Output Info
        // -------------------------
        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin: admin@bfamilyhomes.com / password');
        $this->command->info('Agent: agent1@bfamilyhomes.com / password');
        $this->command->info('Investor: investor1@bfamilyhomes.com / password');
        $this->command->info('User: user1@bfamilyhomes.com / password');
    }
}
