@extends('layouts.guide.main')

@section('title', 'Гайды - Редактировать (Центральные)')

@section('content')
<div class="clan-overview grid grid-cols-1 md:grid-cols-[240px_minmax(0,1fr)] gap-6">
    <div>@include('components.guide-sidebar')</div>
    <div class="welcome-section">
        <div class="welcome-content">
            <h1 class="welcome-title mb-6">Редактировать гайд #{{ $guide->id }}</h1>

            <form action="{{ route('guide.central.update', $guide) }}" method="POST" enctype="multipart/form-data" class="max-w-2xl text-left">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="title" class="block mb-2 text-white">Титул</label>
                    <input id="title" name="title" type="text" value="{{ old('title', $guide->title) }}" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white" required />
                </div>
                <div class="mb-4">
                    <label for="excerpt" class="block mb-2 text-white">Краткое описание</label>
                    <textarea id="excerpt" name="excerpt" rows="3" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white">{{ old('excerpt', $guide->excerpt) }}</textarea>
                </div>
                <div class="mb-4">
                    <input id="image" name="image" type="file" accept="image/*" class="hidden" onchange="document.getElementById('image-picker-label-edit').textContent = this.files?.[0]?.name || 'Выберите файл';" />
                    <label for="image" id="image-picker-label-edit" class="block w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white cursor-pointer hover:bg-white/15 transition-colors">Выберите файл</label>
                    @if($guide->image_path)
                        <div class="mt-2">
                            <img src="{{ route('media', ['path' => $guide->image_path]) }}" alt="Текущее изображение" class="max-h-48 object-contain" />
                        </div>
                    @endif
                </div>
                <div class="mb-6">
                    <label for="body" class="block mb-2 text-white">Текст гайда</label>
                    <textarea id="body" name="body" rows="8" class="w-full p-3 rounded-lg bg-white/10 border border-white/20 text-white" required>{{ old('body', $guide->body) }}</textarea>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="welcome-title text-white hover:text-white/80 hover:underline cursor-pointer transition-colors" style="font-size: 1rem; line-height: 1.5;">Сохранить</button>
                    <a href="{{ route('guide.central.show', $guide) }}" class="welcome-title text-white hover:text-white/80 transition-colors" style="font-size: 1rem; line-height: 1.5;">Отмена</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


