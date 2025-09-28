@extends('admin.layouts.clan.main')

@section('title', 'Админка - Пользователь')

@section('content')
<div class="clan-overview">
    <div class="welcome-section">
        <div class="welcome-content">
            <a href="{{ route('admin.users.index') }}" class="text-white/70 hover:text-white block mb-4">← Назад к списку</a>
            <h1 class="welcome-title mb-6">{{ $user->nickname ?? $user->name }}</h1>

            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="max-w-2xl text-left">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <div class="block mb-2 text-white">Имя</div>
                        <div class="w-full p-3 rounded-lg bg-white/5 border border-white/10 text-white">{{ $user->name }}</div>
                    </div>
                    <div>
                        <div class="block mb-2 text-white">Email</div>
                        <div class="w-full p-3 rounded-lg bg-white/5 border border-white/10 text-white">{{ $user->email }}</div>
                    </div>
                    <div>
                        <div class="block mb-2 text-white">Ник</div>
                        <div class="w-full p-3 rounded-lg bg-white/5 border border-white/10 text-white">{{ $user->nickname ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="block mb-2 text-white">Класс персонажа</div>
                        <div class="w-full p-3 rounded-lg bg-white/5 border border-white/10 text-white">{{ $user->character_class ?? '—' }}</div>
                    </div>
                    <div class="md:col-span-2">
                        <label for="role" class="block mb-2 text-white">Роль</label>
                        @php($current = auth()->user())
                        <select id="role" name="role" @if($current && $current->isModerator() && $user->isAdmin()) disabled @endif class="w-full p-3 rounded-lg bg-transparent border border-white/20 text-white appearance-none" style="background-color: transparent !important; color: #fff;">
                            <option value="authorized" @selected(old('role', $user->role) === 'authorized') style="background-color: rgba(0,0,0,0.8); color:#fff;">Авторизованный</option>
                            <option value="member" @selected(old('role', $user->role) === 'member') style="background-color: rgba(0,0,0,0.8); color:#fff;">Соклан</option>
                            <option value="moderator" @selected(old('role', $user->role) === 'moderator') style="background-color: rgba(0,0,0,0.8); color:#fff;">Модератор</option>
                            @if($current && $current->isAdmin())
                                <option value="admin" @selected(old('role', $user->role) === 'admin') style="background-color: rgba(0,0,0,0.8); color:#fff;">Админ</option>
                            @endif
                        </select>
                        @if($current && $current->isModerator() && $user->isAdmin())
                            <div class="mt-2 text-white/70 text-sm">Модератор не может изменять роль администратора.</div>
                        @endif
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    @if(!($current && $current->isModerator() && $user->isAdmin()))
                        <button type="submit" class="welcome-title text-white hover:text-white/80 hover:underline cursor-pointer transition-colors" style="font-size: 1rem; line-height: 1.5;">Сохранить</button>
                    @endif
                    <a href="{{ route('admin.users.index') }}" class="welcome-title text-white hover:text-white/80 transition-colors" style="font-size: 1rem; line-height: 1.5;">Отмена</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


