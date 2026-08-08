@extends('layouts.agent')

@section('title', 'My Properties')

@section('content')
<div class="mb-8">
    <div class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 rounded-2xl p-6 md:p-8 shadow-lg overflow-hidden">
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-36 h-36 bg-white/5 rounded-full"></div>
        <div class="absolute top-1/2 right-1/3 w-20 h-20 bg-white/5 rounded-full"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-sm flex-shrink-0 border border-white/10">
                    <i class="bi bi-house-door text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">My Properties</h1>
                    <p class="text-blue-100/80 text-sm mt-0.5">Manage and track your property listings</p>
                </div>
            </div>
            <a href="{{ route('agent.properties.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-xl hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all duration-200 shadow-sm hover:shadow-md text-sm flex-shrink-0">
                <i class="bi bi-plus-circle"></i>
                Add New Property
            </a>
        </div>
    </div>
</div>

@if($properties->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($properties as $property)
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
            <div class="relative">
                <img src="{{ $property->first_image }}" 
                     alt="{{ $property->title }}"
                     class="w-full h-48 object-cover"
                     onerror="this.src='https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=600'">
                
                <div class="absolute top-3 right-3">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ 
                        $property->approval_status === 'approved' ? 'bg-green-100 text-green-700' : 
                        ($property->approval_status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')
                    }}">
                        {{ ucfirst($property->approval_status) }}
                    </span>
                </div>
            </div>

            <div class="p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $property->title }}</h3>
                <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $property->description }}</p>
                
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xl font-bold text-orange-600">{{ $property->formatted_price }}</span>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ 
                        $property->type === 'Sale' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700'
                    }}">
                        {{ $property->type }}
                    </span>
                </div>

                <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                    <i class="bi bi-geo-alt-fill text-orange-600"></i>
                    <span>{{ $property->location }}</span>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('agent.properties.edit', $property->id) }}" 
                       class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-semibold transition-all text-sm inline-flex items-center justify-center gap-2">
                        <i class="bi bi-pencil"></i>
                        Edit
                    </a>
                    <button onclick="deleteProperty({{ $property->id }})" 
                            class="flex-1 px-4 py-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 font-semibold transition-all text-sm inline-flex items-center justify-center gap-2">
                        <i class="bi bi-trash"></i>
                        Delete
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $properties->links() }}
    </div>
@else
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-12 text-center">
        <i class="bi bi-house-door text-6xl text-gray-200 mb-4"></i>
        <h3 class="text-2xl font-bold text-gray-900 mb-2">No Properties Yet</h3>
        <p class="text-gray-600 mb-6 text-sm">Start adding properties to showcase to potential clients</p>
        <a href="{{ route('agent.properties.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-xl hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all duration-200 shadow-sm hover:shadow-md text-sm">
            <i class="bi bi-plus-circle"></i>
            Add Your First Property
        </a>
    </div>
@endif
@endsection

@push('scripts')
<script>
    async function deleteProperty(id) {
        if (!confirm('Are you sure you want to delete this property?')) return;
        
        try {
            const data = await window.ajax(`/agent/properties/${id}`, 'DELETE');
            window.toast(data.message, 'success');
            setTimeout(() => window.location.reload(), 1000);
        } catch (error) {
            window.toast(error.message || 'Failed to delete property', 'error');
        }
    }
</script>
@endpush
