@extends('admin.layouts.clan.main')

@section('title', 'Админка - Связь')

@section('content')
<div class="clan-overview">
    <div class="welcome-section">
        <div class="welcome-content">
            <h1 class="welcome-title mb-6">Связь</h1>

            <form action="{{ route('admin.link.store') }}" method="POST" class="max-w-2xl text-left">
                @csrf
                <div class="mb-4">
                    <label for="telegram" class="block mb-2 text-white">Telegram</label>
                    <input id="telegram" name="telegram" type="text" value="{{ old('telegram', optional($contact)->telegram) }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white" />
                </div>
                <div class="mb-4">
                    <label for="teamspeak" class="block mb-2 text-white">Teamspeak</label>
                    <input id="teamspeak" name="teamspeak" type="text" value="{{ old('teamspeak', optional($contact)->teamspeak) }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white" />
                </div>
                <div class="mb-6">
                    <label for="officers" class="block mb-2 text-white">Офицеры</label>
                    <textarea id="officers" name="officers" rows="5" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white">{{ old('officers', optional($contact)->officers) }}</textarea>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="welcome-title text-white hover:text-white/80 hover:underline cursor-pointer transition-colors" style="font-size: 1rem; line-height: 1.5;">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


