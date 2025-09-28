@extends('layouts.gallery.main')

@section('title', 'Галерея - Другое')

@section('content')
<div class="clan-overview">
    <div class="welcome-section">
        <div class="welcome-content">
            <a href="{{ route('gallery.other.index') }}" class="text-white/70 hover:text-white block mb-4">← Назад к списку</a>
            <h1 class="text-white text-2xl md:text-3xl mb-4">{{ $photo->title }}</h1>

            <div class="bg-white/5 rounded-lg overflow-hidden">
                <div class="bg-black/30">
                    <img src="{{ route('media', ['path' => $photo->image_path]) }}" alt="{{ $photo->title }}" class="w-full object-contain" />
                </div>
                <div class="p-4 text-white">
                    <div class="flex items-center gap-4 text-white/70 text-sm mb-2">
                        <form action="{{ route('likes.toggle') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="photo" />
                            <input type="hidden" name="id" value="{{ $photo->id }}" />
                            <input type="hidden" name="redirect" value="{{ url()->current() }}" />
                            <button type="submit" class="hover:text-white">❤ {{ $photo->likes_count ?? $photo->likes()->count() }}</button>
                        </form>
                        <span>💬 {{ $photo->comments_count ?? $photo->comments()->count() }}</span>
                    </div>
                    <div class="text-sm text-white/70">Автор: {{ optional($photo->user)->name ?? '—' }}</div>
                    @if($photo->description)
                        <div class="mt-2 whitespace-pre-wrap break-words">{{ $photo->description }}</div>
                    @endif
                    @auth
                        @if(auth()->id() === $photo->user_id || auth()->user()->role === 'admin')
                            <div class="mt-4 flex gap-3">
                                <a href="{{ route('gallery.other.edit', $photo) }}" class="welcome-title text-white hover:text-white/80 hover:underline cursor-pointer transition-colors" style="font-size: 1rem; line-height: 1.5;">Редактировать</a>
                                <form action="{{ route('gallery.other.destroy', $photo) }}" method="POST" onsubmit="return confirm('Удалить запись #{{ $photo->id }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="welcome-title text-white hover:text-white/80 hover:underline cursor-pointer transition-colors" style="font-size: 1rem; line-height: 1.5;">Удалить</button>
                                </form>
                            </div>
                        @endif
                    @endauth
                    <div class="mt-6">
                        <div class="space-y-4">
                            @foreach($photo->comments as $comment)
                                <div class="flex gap-3" id="comment-{{ $comment->id }}">
                                    <div class="w-10 h-10 rounded-full overflow-hidden bg-white/10 flex-shrink-0">
                                        @php($avatar = optional($comment->user)->avatar_path)
                                        @if($avatar)
                                            <img src="{{ route('media', ['path' => $avatar]) }}" alt="avatar" class="w-full h-full object-cover" />
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-white/80 text-sm mb-1">{{ $comment->user?->name }} ({{ $comment->user?->nickname ?? '—' }})</div>
                                        @php($canEdit = auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->role === 'admin'))
                                        <div id="c-body-{{ $comment->id }}" class="whitespace-pre-wrap">{{ $comment->body }}</div>
                                        @if($canEdit)
                                            <div id="c-edit-{{ $comment->id }}" class="hidden mt-2">
                                                <form action="{{ route('comments.update', $comment) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="redirect" value="{{ url()->current() }}" />
                                                    <textarea name="body" rows="3" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white">{{ $comment->body }}</textarea>
                                                    <div class="mt-2 flex gap-3 items-center">
                                                        <button type="submit" class="text-white hover:text-white/80">Сохранить</button>
                                                        <button type="button" class="text-white/70 hover:text-white" onclick="document.getElementById('c-edit-{{ $comment->id }}').classList.add('hidden');document.getElementById('c-body-{{ $comment->id }}').classList.remove('hidden');">Отмена</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="mt-2 flex gap-3">
                                                <button type="button" class="text-white/70 hover:text-white" onclick="document.getElementById('c-edit-{{ $comment->id }}').classList.remove('hidden');document.getElementById('c-body-{{ $comment->id }}').classList.add('hidden');">Редактировать</button>
                                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Удалить комментарий?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="redirect" value="{{ url()->current() }}" />
                                                    <button type="submit" class="text-red-400 hover:text-red-300">Удалить</button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @auth
                        <form action="{{ route('comments.store') }}" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="type" value="photo" />
                            <input type="hidden" name="id" value="{{ $photo->id }}" />
                            <input type="hidden" name="redirect" value="{{ url()->current() }}" />
                            <textarea name="body" rows="3" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white" placeholder="Напишите комментарий..."></textarea>
                            <div class="mt-2">
                                <button type="submit" class="welcome-title text-white hover:text-white/80 hover:underline cursor-pointer transition-colors" style="font-size: 1rem; line-height: 1.5;">Отправить</button>
                            </div>
                        </form>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


