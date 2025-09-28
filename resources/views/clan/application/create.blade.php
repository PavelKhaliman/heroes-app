@extends('layouts.clan.main')

@section('title', 'Клан HEROES - Обзор')

@section('content')
<div class="clan-overview">
    <!-- Welcome Section -->
    <div class="welcome-section text-center">
        <div class="welcome-content">
            <h1 class="welcome-title mb-8">Заявка на вступление</h1>
            <form action="/clan/application" method="POST" class="max-w-5xl mx-auto text-left">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <div>
                        <label for="name" class="block mb-2 text-white/90">Имя</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Ваше имя">
                        @error('name')
                            <p class="mt-2 text-red-400 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="age" class="block mb-2 text-white/90">Возраст</label>
                        <input id="age" name="age" type="number" value="{{ old('age') }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Ваш возраст">
                        @error('age')
                            <p class="mt-2 text-red-400 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="nic_name" class="block mb-2 text-white/90">Никнейм</label>
                        <input id="nic_name" name="nic_name" type="text" value="{{ old('nic_name') }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Ваш никнейм в игре">
                        @error('nic_name')
                            <p class="mt-2 text-red-400 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="level" class="block mb-2 text-white/90">Уровень</label>
                        <input id="level" name="level" type="number" value="{{ old('level') }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Текущий уровень">
                        @error('level')
                            <p class="mt-2 text-red-400 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="strong" class="block mb-2 text-white/90">Боевые качества</label>
                        <input id="strong" name="strong" type="number" value="{{ old('strong') }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Боевые качества">
                        @error('strong')
                            <p class="mt-2 text-red-400 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="survival" class="block mb-2 text-white/90">Выживаемость</label>
                        <input id="survival" name="survival" type="number" value="{{ old('survival') }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Выживаемость">
                        @error('survival')
                            <p class="mt-2 text-red-400 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="kos_list" class="block mb-2 text-white/90">Наличие косов</label>
                        <input id="kos_list" name="kos_list" type="text" value="{{ old('kos_list') }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Наличие косов">
                        @error('kos_list')
                            <p class="mt-2 text-red-400 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="prime_msk" class="block mb-2 text-white/90">Прайм МСК</label>
                        <input id="prime_msk" name="prime_msk" type="text" value="{{ old('prime_msk') }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Ваш класс">
                        @error('prime_msk')
                            <p class="mt-2 text-red-400 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="charecter_class" class="block mb-2 text-white/90">Класс персонажа</label>
                        <input id="charecter_class" name="charecter_class" type="text" value="{{ old('charecter_class') }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Ваш класс">
                        @error('charecter_class')
                            <p class="mt-2 text-red-400 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                                        
                    <div class="md:col-span-3">
                        <label for="info" class="block mb-2 text-white/90">О себе</label>
                        <textarea id="info" name="info" rows="6" class="w-full p-4 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="О Себе...">{{ old('info') }}</textarea>
                        @error('info')
                            <p class="mt-2 text-red-400 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-medium px-5 py-2 rounded-lg transition-colors">Подать заявку</button>
                    <a href="/clan" class="bg-white/20 hover:bg-white/30 text-white font-medium px-5 py-2 rounded-lg border border-white/30 transition-colors">Отмена</a>
                </div>
            </form>
        </div>
    </div>
   
</div>
@endsection
