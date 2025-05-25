{{-- This file contains the HTML for a single project card --}}
<div class="reference-card border p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
    @if ($entry->image_url)
        <img src="{{ asset('storage/' . $entry->image_url) }}" alt="{{ $entry->title }} preview" class="mb-4 rounded-md object-cover h-48 w-full">
    @endif
    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $entry->title }}</h3>
    @if ($entry->description)
        <p class="text-gray-700 text-sm mb-4">{{ $entry->description }}</p>
    @endif
    <div class="flex flex-wrap gap-3 mt-4">
        @if ($entry->live_demo_url)
            <a href="{{ $entry->live_demo_url }}" target="_blank" class="text-blue-600 hover:underline text-sm font-medium no-underline">Live Demo</a>
        @endif
        @if ($entry->github_url)
            <a href="{{ $entry->github_url }}" target="_blank" class="text-blue-600 hover:underline text-sm font-medium no-underline">GitHub</a>
        @endif
         @if ($entry->technologies)
            <span class="text-gray-500 text-xs mt-2 w-full block">{{ $entry->technologies }}</span>
         @endif
    </div>
</div>
