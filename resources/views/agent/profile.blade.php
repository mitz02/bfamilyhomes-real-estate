@extends('layouts.agent')

@section('title', 'My Profile')

@section('content')
<div class="mb-8">
    <div class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 rounded-2xl p-6 md:p-8 shadow-lg overflow-hidden">
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-36 h-36 bg-white/5 rounded-full"></div>
        <div class="absolute top-1/2 right-1/3 w-20 h-20 bg-white/5 rounded-full"></div>

        <div class="relative flex flex-col md:flex-row md:items-center gap-4">
            <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-sm flex-shrink-0 border border-white/10">
                <i class="bi bi-person text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-white">My Profile</h1>
                <p class="text-blue-100/80 text-sm mt-0.5">Manage your account information and preferences</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Profile Form -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Personal Information</h2>
            
            <form id="profileForm" class="space-y-6">
                @csrf
                
                <!-- Avatar Upload -->
                <div class="flex items-center gap-6 mb-6">
                    <div class="relative">
                        <div class="w-24 h-24 bg-gradient-to-r from-orange-500 to-yellow-500 rounded-full flex items-center justify-center text-white text-3xl font-bold overflow-hidden">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                                     alt="{{ auth()->user()->name }}"
                                     class="w-24 h-24 rounded-full object-cover"
                                     id="avatarPreview">
                            @else
                                <span id="avatarInitial">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            @endif
                        </div>
                        <label for="avatar" class="absolute bottom-0 right-0 w-8 h-8 bg-orange-600 rounded-full flex items-center justify-center cursor-pointer hover:bg-orange-700 transition-colors shadow-lg">
                            <i class="bi bi-camera text-white text-sm"></i>
                        </label>
                        <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(this)">
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">{{ auth()->user()->name }}</h3>
                        <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                        <p class="text-xs text-gray-400 mt-1">Real Estate Agent</p>
                        <p class="text-xs text-gray-400 mt-1">Member since {{ auth()->user()->created_at->format('F Y') }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
                        <input type="text" id="name" name="name" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                               value="{{ auth()->user()->name }}" required>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">Phone Number</label>
                        <input type="tel" id="phone" name="phone" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                               value="{{ auth()->user()->phone }}" required>
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                    <input type="email" id="email" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                           value="{{ auth()->user()->email }}" disabled>
                    <p class="text-xs text-gray-400 mt-1">Email cannot be changed</p>
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1.5">Address</label>
                    <textarea id="address" name="address" rows="3" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                              placeholder="Enter your address">{{ auth()->user()->address }}</textarea>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-xl hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all duration-200 shadow-sm hover:shadow-md text-sm">
                        <i class="bi bi-check-circle"></i>
                        Save Changes
                    </button>
                    <a href="{{ route('agent.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-semibold transition-all text-sm">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Change Password -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mt-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Change Password</h2>
            
            <form id="passwordForm" class="space-y-6">
                @csrf
                
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1.5">Current Password</label>
                    <input type="password" id="current_password" name="current_password" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
                </div>

                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1.5">New Password</label>
                    <input type="password" id="new_password" name="new_password" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required minlength="8">
                </div>

                <div>
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Confirm New Password</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
                </div>

                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-xl hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all duration-200 shadow-sm hover:shadow-md text-sm">
                    <i class="bi bi-key"></i>
                    Update Password
                </button>
            </form>
        </div>
    </div>

    <!-- Account Info Sidebar -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Account Information</h3>
            
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Account Type</p>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-orange-100 text-orange-700">
                        Agent
                    </span>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">Account Status</p>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ 
                        auth()->user()->status === 'active' ? 'bg-green-100 text-green-700' : 
                        (auth()->user()->status === 'blocked' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700')
                    }}">
                        {{ ucfirst(auth()->user()->status) }}
                    </span>
                </div>

                @if(auth()->user()->isAgent())
                <div>
                    <p class="text-sm text-gray-500 mb-1">Agent Since</p>
                    <p class="font-semibold text-gray-900 text-sm">
                        {{ auth()->user()->agent_approved_at ? auth()->user()->agent_approved_at->format('M d, Y') : 'Pending Approval' }}
                    </p>
                </div>
                @endif

                <div>
                    <p class="text-sm text-gray-500 mb-1">Email Verified</p>
                    <p class="font-semibold text-sm {{ auth()->user()->email_verified_at ? 'text-green-600' : 'text-yellow-600' }}">
                        {{ auth()->user()->email_verified_at ? 'Verified' : 'Not Verified' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Properties</p>
                    <p class="font-semibold text-gray-900 text-sm">
                        {{ auth()->user()->properties()->count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const avatarDiv = input.closest('.relative').querySelector('.w-24');
                const initial = avatarDiv.querySelector('#avatarInitial');
                if (initial) initial.style.display = 'none';
                
                let img = avatarDiv.querySelector('#avatarPreview');
                if (!img) {
                    img = document.createElement('img');
                    img.id = 'avatarPreview';
                    img.className = 'w-24 h-24 rounded-full object-cover';
                    avatarDiv.appendChild(img);
                }
                img.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Profile Update
    document.getElementById('profileForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const formData = new FormData(form);
        
        showLoader(submitBtn);
        
        try {
            const data = await window.ajax('{{ route("agent.profile") }}', 'POST', formData);
            window.toast(data.message, 'success');
            setTimeout(() => window.location.reload(), 1500);
        } catch (error) {
            hideLoader(submitBtn);
            window.toast(error.message || 'Failed to update profile', 'error');
        }
    });

    // Password Change
    document.getElementById('passwordForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const formData = new FormData(form);
        
        if (formData.get('new_password') !== formData.get('new_password_confirmation')) {
            window.toast('New passwords do not match', 'error');
            return;
        }
        
        showLoader(submitBtn);
        
        try {
            const data = await window.ajax('{{ route("dashboard.change-password") }}', 'POST', {
                current_password: formData.get('current_password'),
                new_password: formData.get('new_password'),
                new_password_confirmation: formData.get('new_password_confirmation'),
            });
            window.toast(data.message, 'success');
            form.reset();
        } catch (error) {
            hideLoader(submitBtn);
            window.toast(error.message || 'Failed to change password', 'error');
        }
    });
</script>
@endpush
