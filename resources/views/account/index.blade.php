@extends('layouts.home.app')

@section('title', 'Личный кабинет')

@section('content')
<div class="clan-overview">
    <div class="welcome-section">
        <div class="welcome-content">
            <div class="flex items-center justify-between mb-6">
                <h1 class="welcome-title">Личный кабинет</h1>
                @if(auth()->user()->isAdmin() || auth()->user()->isModerator())
                    <a href="{{ route('admin.users.index') }}" class="inline-block welcome-title text-white hover:text-white/80 transition-colors" style="font-size: 1rem; line-height: 1.5;">Админ-панель</a>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white/5 rounded-lg p-4 text-white">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-full overflow-hidden bg-white/10 flex-shrink-0">
                                @if($user->avatar_path)
                                    <img src="{{ route('media', ['path' => $user->avatar_path]) }}" alt="Аватар" class="w-full h-full object-cover" />
                                @endif
                            </div>
                            <div>
                                <div class="text-white/90 font-medium">{{ $user->name }}</div>
                                <div class="text-white/70 text-sm">{{ $user->nickname }}</div>
                            </div>
                        </div>
                        <form action="{{ route('account.avatar') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                            @csrf
                            <input id="avatar" name="avatar" type="file" class="hidden" onchange="document.getElementById('avatar-filename').innerText = this.files[0]?.name || ''">
                            <label for="avatar" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white cursor-pointer block text-center">Выберите аватар</label>
                            <span id="avatar-filename" class="mt-2 text-white/70 text-sm block"></span>
                            @error('avatar')<p class="mt-2 text-red-400 text-sm">{{ $message }}</p>@enderror
                            <div class="mt-3 flex justify-end">
                                <button type="submit" class="welcome-title text-white hover:text-white/80 hover:underline" style="font-size: 1rem; line-height: 1.5;">Сохранить</button>
                            </div>
                        </form>
                    </div>

                    <div class="bg-white/5 rounded-lg p-4 text-white">
                        <div class="text-white/90 font-medium mb-3">Профиль</div>
                        <form action="{{ route('account.profile') }}" method="POST" class="space-y-3">
                            @csrf
                            <div>
                                <label class="block mb-1 text-white/80">Имя</label>
                                <input name="name" value="{{ old('name', $user->name) }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white" />
                            </div>
                            <div>
                                <label class="block mb-1 text-white/80">Ник</label>
                                <input name="nickname" value="{{ old('nickname', $user->nickname) }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white" />
                            </div>
                            <div>
                                <label class="block mb-1 text-white/80">Telegram</label>
                                <input name="telegram" value="{{ old('telegram', $user->telegram) }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white" placeholder="@username" />
                            </div>
                            <div>
                                <label class="block mb-1 text-white/80">Класс персонажа</label>
                                <input name="character_class" value="{{ old('character_class', $user->character_class) }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white" />
                            </div>
                            <div class="mt-3 flex justify-end">
                                <button type="submit" class="welcome-title text-white hover:text-white/80 hover:underline" style="font-size: 1rem; line-height: 1.5;">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white/5 rounded-lg p-4 text-white">
                        <div class="text-white/90 font-medium mb-3">Сменить пароль</div>
                        <form action="{{ route('account.password') }}" method="POST" class="space-y-3 max-w-lg">
                            @csrf
                            <div>
                                <label class="block mb-1 text-white/80">Текущий пароль</label>
                                <input type="password" name="current_password" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white" required />
                                @error('current_password')<p class="mt-2 text-red-400 text-sm">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block mb-1 text-white/80">Новый пароль</label>
                                <input type="password" name="password" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white" required />
                                @error('password')<p class="mt-2 text-red-400 text-sm">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block mb-1 text-white/80">Подтверждение пароля</label>
                                <input type="password" name="password_confirmation" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white" required />
                            </div>
                            <div class="mt-3 flex justify-end">
                                <button type="submit" class="welcome-title text-white hover:text-white/80 hover:underline" style="font-size: 1rem; line-height: 1.5;">Обновить пароль</button>
                            </div>
                        </form>
                    </div>
                    <div class="bg-white/5 rounded-lg p-4 text-white">
                        <div class="text-white/90 font-medium mb-3">Мои фотографии</div>
                        @if($photos->isEmpty())
                            <div class="text-white/70">Пока нет фотографий.</div>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($photos as $photo)
                                    <a href="{{ route('gallery.photo.show', $photo) }}" class="block group bg-white/5 rounded-lg overflow-hidden hover:bg-white/10 transition-colors">
                                        <div class="aspect-video bg-black/30 overflow-hidden">
                                            <img src="{{ route('media', ['path' => $photo->image_path]) }}" alt="{{ $photo->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform" />
                                        </div>
                                        <div class="p-3 text-white">
                                            <div class="text-white/90 font-medium">{{ $photo->title }}</div>
                                            @if($photo->description)
                                                <div class="mt-1 text-white/90" style="display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; text-overflow:ellipsis;">{{ $photo->description }}</div>
                                            @endif
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                            <div class="mt-4">{{ $photos->links() }}</div>
                        @endif
                    </div>

                    <div class="bg-white/5 rounded-lg p-4 text-white">
                        <div class="text-white/90 font-medium mb-3">Мои комментарии</div>
                        <div class="space-y-3">
                            @forelse($comments as $comment)
                                <div class="bg-white/5 p-3 rounded-lg">
                                    <div class="text-sm text-white/70 mb-1">{{ $comment->created_at->diffForHumans() }}</div>
                                    <div class="whitespace-pre-wrap">{{ $comment->body }}</div>
                                    @php($link = $comment->commentable ? ( $comment->commentable instanceof App\Models\Guide ? route('guide.' . $comment->commentable->kind . '.show', ['guide' => $comment->commentable, 'kind' => $comment->commentable->kind]) : route('gallery.photo.show', $comment->commentable) ) : null)
                                    @if($link)
                                        <a href="{{ $link }}#comment-{{ $comment->id }}" class="text-white/80 hover:text-white">Перейти к комментарию →</a>
                                    @endif
                                </div>
                            @empty
                                <div class="text-white/70">Комментариев нет.</div>
                            @endforelse
                        </div>
                        <div class="mt-4">{{ $comments->links() }}</div>
                    </div>

                    <div class="bg-white/5 rounded-lg p-4 text-white">
                        <div class="text-white/90 font-medium mb-3">Уведомления</div>
                        <div class="space-y-3">
                            @forelse($notifications as $note)
                                <div class="bg-white/5 p-3 rounded-lg flex items-start justify-between">
                                    <div class="pr-3">
                                        <div class="text-sm text-white/70 mb-1">{{ $note->created_at->diffForHumans() }}</div>
                                        <div class="whitespace-pre-wrap">{{ $note->data['message'] ?? 'Новое уведомление' }}</div>
                                        @if(!empty($note->data['link']))
                                            <a href="{{ $note->data['link'] }}" class="text-white/80 hover:text-white">Открыть →</a>
                                        @endif
                                    </div>
                                    @if(!$note->read_at)
                                        <form action="{{ route('account.notifications.read', $note->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="welcome-title text-white hover:text-white/80" style="font-size: 1rem; line-height: 1.5;">Прочитано</button>
                                        </form>
                                    @endif
                                </div>
                            @empty
                                <div class="text-white/70">Нет уведомлений.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


