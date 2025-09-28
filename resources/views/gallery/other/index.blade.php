@extends('layouts.gallery.main')

@section('title', 'Галерея - Другое')

@section('content')
<div class="clan-overview">
    <div class="welcome-section">
        <div class="welcome-content">
            <div class="flex items-center justify-between mb-6">
                <h1 class="welcome-title">Другое</h1>
                <a href="{{ route('gallery.other.create') }}" class="inline-block welcome-title text-white hover:text-white/80 transition-colors" style="font-size: 1rem; line-height: 1.5;">Добавить</a>
            </div>

            @if($photos->isEmpty())
                <div class="text-white/80">Пока нет записей.</div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($photos as $photo)
                        <a href="{{ route('gallery.other.show', $photo) }}" class="block group bg-white/5 rounded-lg overflow-hidden hover:bg-white/10 transition-colors">
                            <div class="aspect-video bg-black/30 overflow-hidden">
                                <img src="{{ route('media', ['path' => $photo->image_path]) }}" alt="{{ $photo->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform" />
                            </div>
                            <div class="p-3 text-white">
                                <div class="text-white/90 font-medium">{{ $photo->title }}</div>
                                @if($photo->description)
                                    <div class="mt-1 text-white/90" style="display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; text-overflow:ellipsis;">{{ $photo->description }}</div>
                                @endif
                                <div class="mt-2 text-white/70 text-sm flex items-center gap-3">
                                    <span>❤ {{ $photo->likes_count ?? $photo->likes()->count() }}</span>
                                    <span>💬 {{ $photo->comments_count ?? $photo->comments()->count() }}</span>
                                </div>
                                <div class="mt-1 text-sm text-white/70">Автор: {{ optional($photo->user)->name ?? '—' }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-6">{{ $photos->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection


