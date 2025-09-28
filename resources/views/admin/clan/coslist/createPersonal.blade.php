@extends('admin.layouts.clan.main')

@section('title', 'Клан HEROES - Добавить запись в кос лист')

@section('content')
<div class="clan-overview">
    <div class="welcome-section text-center">
        <div class="welcome-content">
			<h1 class="welcome-title mb-8 text-white">Добавить игрока</h1>
            <form action="{{ route('admin.clan.coslist.store.personal') }}" method="POST" class="max-w-2xl mx-auto text-left">
                @csrf
				<div class="mb-4">
					<label for="nicname" class="block text-left mb-2 text-white">Ник</label>
                    <input id="nicname" name="nicname" type="text" value="{{ old('nicname') }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Введите ник">
                    @error('nicname')
                        <p class="mt-2 text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

				<div class="mb-4">
					<label for="guild" class="block text-left mb-2 text-white">Клан</label>
                    <input id="guild" name="guild" type="text" value="{{ old('guild') }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Введите название клана">
                    @error('guild')
                        <p class="mt-2 text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                

				<div class="mb-4">
					<label for="reason" class="block text-left mb-2 text-white">Причина</label>
                    <input id="reason" name="reason" type="text" value="{{ old('reason') }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Причина занесения в лист">
                    @error('reason')
                        <p class="mt-2 text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

				<div class="mb-6">
					<label for="repayment" class="block text-left mb-2 text-white">Возмещение</label>
                    <input id="repayment" name="repayment" type="text" value="{{ old('repayment') }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Сумма/условия возмещения">
                    @error('repayment')
                        <p class="mt-2 text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-medium px-5 py-2 rounded-lg transition-colors">Сохранить</button>
                    <a href="{{ route('admin.clan.coslist.index') }}" class="bg-white/20 hover:bg-white/30 text-white font-medium px-5 py-2 rounded-lg border border-white/30 transition-colors">Отмена</a>
                </div>
            </form>
        </div>
    </div>
   
</div>
@endsection
