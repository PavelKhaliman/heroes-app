@extends('layouts.home.app')

@section('title', 'Вход')

@section('content')
<div class="welcome-section text-center">
    <div class="welcome-content">
        <h1 class="welcome-title mb-8">Вход</h1>
        <form action="{{ route('login.post') }}" method="POST" class="max-w-md mx-auto text-left">
            @csrf
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
            </div>
            <div class="mb-6 flex items-center gap-2">
                <input id="remember" name="remember" type="checkbox" class="rounded bg-white/10 border-white/20" />
                <label for="remember" class="text-white">Запомнить меня</label>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-medium px-5 py-2 rounded-lg transition-colors">Войти</button>
                <a href="{{ route('register') }}" class="bg-white/20 hover:bg-white/30 text-white font-medium px-5 py-2 rounded-lg border border-white/30 transition-colors">Регистрация</a>
            </div>
        </form>
    </div>
  </div>
@endsection


