@extends('layouts.guide.main')

@section('title', 'Гайды - Восток')

@section('content')
<div class="clan-overview grid grid-cols-1 md:grid-cols-[240px_minmax(0,1fr)] gap-6">
    <div>@include('components.guide-sidebar')</div>
    <div class="welcome-section">
        <div class="welcome-content">
            <div class="flex items-center justify-between mb-6">
                <h1 class="welcome-title">Восток</h1>
                <a href="{{ route('guide.east.create') }}" class="inline-block welcome-title text-white hover:text-white/80 transition-colors" style="font-size: 1rem; line-height: 1.5;">Добавить</a>
            </div>

            @if($guides->isEmpty())
                <div class="text-white/80">Пока нет гайдов.</div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($guides as $g)
                        <a href="{{ route('guide.east.show', $g) }}" class="block group bg-white/5 rounded-lg overflow-hidden hover:bg-white/10 transition-colors">
                            <div class="aspect-video bg-black/30 overflow-hidden">
                                @if($g->image_path)
                                    <img src="{{ route('media', ['path' => $g->image_path]) }}" alt="{{ $g->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform" />
                                @endif
                            </div>
                            <div class="p-3 text-white">
                                <div class="text-white/90 font-medium">{{ $g->title }}</div>
                                @if($g->excerpt)
                                    <div class="mt-1 text-white/90" style="display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; text-overflow:ellipsis;">{{ $g->excerpt }}</div>
                                @endif
                                <div class="mt-2 text-white/70 text-sm flex items-center gap-3">
                                    <span>❤ {{ $g->likes_count }}</span>
                                    <span>💬 {{ $g->comments_count }}</span>
                                </div>
                                <div class="mt-1 text-sm text-white/70">Автор: {{ optional($g->user)->name ?? '—' }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-6">{{ $guides->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection


