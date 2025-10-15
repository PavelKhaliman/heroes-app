@extends('admin.layouts.clan.main')

@section('title', 'Клан HEROES - Редактировать запись кос-листа')

@section('content')
<div class="clan-overview">
    <div class="welcome-section">
        <div class="welcome-content">
            <a href="{{ route('admin.clan.coslist.index') }}" class="text-white/70 hover:text-white block mb-4">← Назад</a>
            <h1 class="welcome-title mb-6">Редактировать</h1>

            <form action="{{ route('admin.clan.coslist.update', $coslist) }}" method="POST" class="max-w-2xl text-left space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block mb-2 text-white">Ник</label>
                    <input name="nicname" value="{{ old('nicname', $coslist->nicname) }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white" />
                    @error('nicname')<p class="mt-2 text-red-400 text-sm">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block mb-2 text-white">Клан</label>
                    <input name="guild" value="{{ old('guild', $coslist->guild) }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white" />
                    @error('guild')<p class="mt-2 text-red-400 text-sm">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block mb-2 text-white">Мастер</label>
                    <input name="master" value="{{ old('master', $coslist->master) }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white" />
                    @error('master')<p class="mt-2 text-red-400 text-sm">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block mb-2 text-white">Причина</label>
                    <textarea name="reason" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white" rows="4">{{ old('reason', $coslist->reason) }}</textarea>
                    @error('reason')<p class="mt-2 text-red-400 text-sm">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block mb-2 text-white">Выкуп</label>
                    <input name="repayment" value="{{ old('repayment', $coslist->repayment) }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white" />
                    @error('repayment')<p class="mt-2 text-red-400 text-sm">{{ $message }}</p>@enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="bg-orange-600 hover:bg-orange-500 text-white font-medium px-5 py-2 rounded">Сохранить</button>
                    <a href="{{ route('admin.clan.coslist.index') }}" class="ml-3 text-white/80 hover:text-white">Отмена</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
