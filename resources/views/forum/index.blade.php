@extends('layouts.home.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 text-white">
    <h1 class="welcome-title mb-6">Форум</h1>
    <div class="space-y-6">
        @forelse($sections as $section)
            <div class="bg-black/60 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold">{{ $section->title }}</h2>
                        @if($section->description)
                            <p class="text-sm text-gray-300 mt-1">{{ $section->description }}</p>
                        @endif
                    </div>
                </div>
                @if($section->subsections->count())
                    <ul class="mt-4 grid md:grid-cols-2 gap-3">
                        @foreach($section->subsections as $sub)
                            <li>
                                <a href="{{ route('forum.subsection', [$section->slug, $sub->slug]) }}" class="block bg-black/40 rounded p-3 hover:bg-black/60 hover:ring-1 hover:ring-orange-500 hover:shadow-lg hover:shadow-orange-500/20 transition">
                                    <div class="text-base font-medium">{{ $sub->title }}</div>
                                    @if($sub->description)
                                        <div class="text-xs text-gray-400">{{ $sub->description }}</div>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @empty
            <div class="text-gray-400">Пока нет разделов.</div>
        @endforelse
    </div>
</div>
@endsection


