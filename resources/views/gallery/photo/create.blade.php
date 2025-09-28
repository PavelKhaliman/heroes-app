@extends('layouts.gallery.main')

@section('title', 'Галерея - Добавить фото')

@section('content')
<div class="clan-overview">
    <div class="welcome-section">
        <div class="welcome-content">
            <h1 class="welcome-title mb-6">Добавить фото</h1>

            <form action="{{ route('gallery.photo.store') }}" method="POST" enctype="multipart/form-data" class="max-w-2xl text-left" onsubmit="const b=this.querySelector('[data-submit-btn]'); if(b){b.disabled=true; b.classList.add('opacity-50','pointer-events-none'); b.textContent='Загрузка...';}">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block mb-2 text-white">Титул</label>
                    <input id="title" name="title" type="text" value="{{ old('title') }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Введите заголовок" required />
                    @error('title')
                        <p class="mt-2 text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <input id="image" name="image" type="file" accept="image/*" class="hidden" required onchange="document.getElementById('image-picker-label').textContent = this.files?.[0]?.name || 'Выберите файл';" />
                    <label for="image" id="image-picker-label" class="block w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white cursor-pointer hover:bg-white/15 transition-colors">Выберите файл</label>
                    @error('image')
                        <p class="mt-2 text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="block mb-2 text-white">Описание (необязательно)</label>
                    <textarea id="description" name="description" rows="4" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-orange-500">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit" data-submit-btn class="welcome-title text-white hover:text-white/80 hover:underline cursor-pointer transition-colors" style="font-size: 1rem; line-height: 1.5;">Загрузить</button>
                    <a href="{{ route('gallery.photo.index') }}" class="welcome-title text-white hover:text-white/80 transition-colors" style="font-size: 1rem; line-height: 1.5;">Отмена</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
