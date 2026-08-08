@extends('layouts.agent')

@section('title', 'Property Inquiries')

@section('content')
<div class="mb-8">
    <div class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 rounded-2xl p-6 md:p-8 shadow-lg overflow-hidden">
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-36 h-36 bg-white/5 rounded-full"></div>
        <div class="absolute top-1/2 right-1/3 w-20 h-20 bg-white/5 rounded-full"></div>

        <div class="relative flex flex-col md:flex-row md:items-center gap-4">
            <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-sm flex-shrink-0 border border-white/10">
                <i class="bi bi-chat-dots text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-white">Property Inquiries</h1>
                <p class="text-blue-100/80 text-sm mt-0.5">View inquiries about your properties</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
    @if($inquiries->count() > 0)
        <div class="overflow-x-auto -mx-6 px-6 w-[95%] mx-auto" style="-webkit-overflow-scrolling: touch;">
            <table class="w-full" style="min-width: 900px;">
                <thead class="border-b border-gray-200">
                    <tr>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold whitespace-nowrap text-sm">Property</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold whitespace-nowrap text-sm">Client</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold whitespace-nowrap text-sm">Message</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold whitespace-nowrap text-sm">Date</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold whitespace-nowrap text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inquiries as $inquiry)
                    <tr class="border-b border-gray-100 last:border-0 hover:bg-orange-50/50">
                        <td class="py-4 px-4 whitespace-nowrap">
                            <h4 class="font-semibold text-gray-900 text-sm">{{ Str::limit($inquiry->property->title, 30) }}</h4>
                            <p class="text-sm text-gray-500">{{ $inquiry->property->location }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-semibold text-gray-900 text-sm">{{ $inquiry->name }}</p>
                            <p class="text-sm text-gray-500">{{ $inquiry->email }}</p>
                            <p class="text-xs text-gray-400">{{ $inquiry->phone }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="text-sm text-gray-900">{{ Str::limit($inquiry->message, 100) }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="text-sm text-gray-500">{{ $inquiry->created_at->format('M d, Y') }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="flex gap-2">
                                <a href="tel:{{ $inquiry->phone }}" 
                                   class="w-9 h-9 bg-orange-500/10 text-orange-600 rounded-lg flex items-center justify-center hover:bg-orange-500/20 transition-colors text-sm">
                                    <i class="bi bi-telephone"></i>
                                </a>
                                <button onclick="window.sendToWhatsApp('{{ $inquiry->phone }}', 'Hi {{ $inquiry->name }}, regarding your inquiry about {{ $inquiry->property->title }}')" 
                                        class="w-9 h-9 bg-green-50 text-green-600 rounded-lg flex items-center justify-center hover:bg-green-100 transition-colors text-sm">
                                    <i class="bi bi-whatsapp"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $inquiries->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i class="bi bi-chat-dots text-6xl text-gray-200 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No Inquiries Yet</h3>
            <p class="text-gray-500 text-sm">Inquiries about your properties will appear here</p>
        </div>
    @endif
</div>
@endsection
