@extends('layouts.home.app')

@section('title', 'Регистрация')

@section('content')
<div class="welcome-section text-center">
    <div class="welcome-content">
        <h1 class="welcome-title mb-8">Регистрация</h1>
        <form action="{{ route('register.post') }}" method="POST" class="max-w-md mx-auto text-left">
            @csrf
            <div class="mb-4">
                <label for="name" class="block mb-2 text-white">Имя</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-orange-500" required />
                @error('name')
                    <p class="mt-2 text-red-400 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block mb-2 text-white">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-orange-500" required />
                @error('email')
                    <p class="mt-2 text-red-400 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block mb-2 text-white">Пароль</label>
                <input id="password" name="password" type="password" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-orange-500" required />
                @error('password')
                    <p class="mt-2 text-red-400 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="password_confirmation" class="block mb-2 text-white">Подтверждение пароля</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-orange-500" required />
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-medium px-5 py-2 rounded-lg transition-colors">Зарегистрироваться</button>
                <a href="{{ route('login') }}" class="bg-white/20 hover:bg-white/30 text-white font-medium px-5 py-2 rounded-lg border border-white/30 transition-colors">У меня уже есть аккаунт</a>
            </div>
        </form>
    </div>
  </div>
@endsection


