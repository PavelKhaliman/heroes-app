@extends('admin.layouts.clan.main')

@section('title', 'Клан HEROES - Обзор')

@section('content')
<div class="clan-overview">
    <!-- Welcome Section -->
    <div class="welcome-section text-center">
        <div class="welcome-content">
            <h1 class="welcome-title mb-8">Добавить/обновить устав</h1>
            <form action="{{ url('/admin/clan/regulation/store') }}" method="POST" class="max-w-2xl mx-auto text-left">
                @csrf
                <div class="mb-6">
                    
                    <textarea id="regulation" name="regulation" rows="8" placeholder="Введите текст устава" class="w-full p-4 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-orange-500">{{ old('regulation', isset($clan) ? $clan->regulation : '') }}</textarea>
                    @error('regulation')
                        <p class="mt-2 text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-medium px-5 py-2 rounded-lg transition-colors">Сохранить</button>
                    <a href="{{ url('/admin/clan/regulation') }}" class="bg-white/20 hover:bg-white/30 text-white font-medium px-5 py-2 rounded-lg border border-white/30 transition-colors">Отмена</a>
                </div>
            </form>
        </div>
    </div>
   
</div>
@endsection
