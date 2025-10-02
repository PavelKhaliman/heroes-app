@extends('layouts.home.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 text-white">
    <a href="{{ route('forum.index') }}" class="text-sm text-gray-300 hover:text-white">← К разделам</a>
    <h1 class="welcome-title mt-2">{{ $section->title }}</h1>
    @if($subsection->description)
        <p class="mt-2 text-gray-300">{{ $subsection->description }}</p>
    @endif

    <div class="mt-6 space-y-4">
        @forelse($subsection->replies as $reply)
            <div class="bg-black/60 rounded p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-lg font-semibold flex items-center gap-2">
                            @if($reply->pinned)
                                <span title="Закреплено" class="text-yellow-400">📌</span>
                            @endif
                            {{ $reply->title }}
                        </div>
                        <div class="text-xs text-gray-400">Автор: {{ $reply->user->nickname ?? $reply->user->name }} · {{ $reply->created_at->diffForHumans() }}</div>
                    </div>
                    @auth
                        @php $role = auth()->user()->role; @endphp
                        @if(auth()->id() === $reply->user_id || in_array($role, ['admin','moderator']))
                            <div class="flex gap-2">
                                @if(in_array($role, ['admin','moderator']))
                                    <form method="POST" action="{{ route('forum.replies.pin', [$section->slug, $subsection->slug, $reply]) }}">
                                        @csrf
                                        <button class="px-3 py-1 bg-yellow-600 hover:bg-yellow-500 rounded">{{ $reply->pinned ? 'Открепить' : 'Закрепить' }}</button>
                                    </form>
                                @endif
                                <button type="button" class="px-3 py-1 bg-blue-600 hover:bg-blue-500 rounded" onclick="const el=document.getElementById('edit-reply-{{ $reply->id }}'); el.style.display = el.style.display === 'none' ? 'block' : 'none';">Редактировать</button>
                                <form method="POST" action="{{ route('forum.replies.delete', [$section->slug, $subsection->slug, $reply]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 bg-red-600 hover:bg-red-500 rounded" onclick="return confirm('Удалить ответ?')">Удалить</button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
                <div class="mt-3 whitespace-pre-wrap">{{ $reply->body }}</div>
                @if($reply->attachments->count())
                    <div class="mt-3 grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($reply->attachments as $att)
                            <a href="{{ route('media', ['path' => $att->path]) }}" target="_blank">
                                <img src="{{ route('media', ['path' => $att->path]) }}" class="w-full h-40 object-cover rounded" />
                            </a>
                        @endforeach
                    </div>
                @endif

                @auth
                    @if(auth()->id() === $reply->user_id || auth()->user()->role === 'admin')
                        <div id="edit-reply-{{ $reply->id }}" class="mt-4 bg-black/40 rounded p-3" style="display:none">
                            <h3 class="text-lg font-semibold mb-2">Редактировать ответ</h3>
                            <form method="POST" action="{{ route('forum.replies.update', [$section->slug, $subsection->slug, $reply]) }}" enctype="multipart/form-data" class="space-y-3">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label class="block text-sm mb-1">Заголовок</label>
                                    <input name="title" value="{{ old('title', $reply->title) }}" class="w-full bg-black/60 rounded p-2" />
                                </div>
                                <div>
                                    <label class="block text-sm mb-1">Описание</label>
                                    <textarea name="body" rows="4" class="w-full bg-black/60 rounded p-2">{{ old('body', $reply->body) }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm mb-1">Добавить изображения</label>
                                    <input type="file" name="images[]" multiple accept="image/*" class="w-full bg-black/60 rounded p-2 border border-white/10 hover:bg-black/70 hover:ring-2 hover:ring-orange-500 cursor-pointer transition file:mr-3 file:px-3 file:py-1.5 file:rounded file:border-0 file:bg-orange-600 file:text-white hover:file:bg-orange-500" />
                                </div>
                                <div class="flex gap-2">
                                    <button class="px-4 py-2 bg-orange-600 hover:bg-orange-500 rounded">Сохранить</button>
                                    <button type="button" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded" onclick="document.getElementById('edit-reply-{{ $reply->id }}').style.display='none'">Отмена</button>
                                </div>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        @empty
            <div class="text-gray-400">Пока нет ответов.</div>
        @endforelse
    </div>

    @auth
    <div class="mt-8 bg-black/60 rounded p-4">
        <h2 class="text-xl font-semibold mb-3">Новый ответ</h2>
        <form method="POST" action="{{ route('forum.replies.store', [$section->slug, $subsection->slug]) }}" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <div>
                <label class="block text-sm mb-1">Заголовок</label>
                <input name="title" value="{{ old('title') }}" class="w-full bg-black/60 rounded p-2" />
                @error('title')<div class="text-red-400 text-sm">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm mb-1">Описание</label>
                <textarea name="body" rows="4" class="w-full bg-black/60 rounded p-2">{{ old('body') }}</textarea>
                @error('body')<div class="text-red-400 text-sm">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm mb-1">Изображения</label>
                <input type="file" name="images[]" multiple accept="image/*" class="w-full bg-black/60 rounded p-2 border border-white/10 hover:bg-black/70 hover:ring-2 hover:ring-orange-500 cursor-pointer transition file:mr-3 file:px-3 file:py-1.5 file:rounded file:border-0 file:bg-orange-600 file:text-white hover:file:bg-orange-500" />
                @error('images.*')<div class="text-red-400 text-sm">{{ $message }}</div>@enderror
            </div>
            <button class="px-4 py-2 bg-orange-600 hover:bg-orange-500 rounded">Отправить</button>
        </form>
    </div>
    @endauth
</div>
@endsection


