@extends('admin.layouts.home.app')

@section('content')
<div class="p-6 text-white max-w-xl">
    <h1 class="welcome-title mb-4">Новый раздел</h1>
    <form method="POST" action="{{ route('admin.forum.sections.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm mb-1">Заголовок</label>
            <input name="title" value="{{ old('title') }}" class="w-full bg-black/60 rounded p-2" />
            @error('title')<div class="text-red-400 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-sm mb-1">Slug</label>
            <input name="slug" value="{{ old('slug') }}" class="w-full bg-black/60 rounded p-2" />
            @error('slug')<div class="text-red-400 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-sm mb-1">Описание</label>
            <textarea name="description" class="w-full bg-black/60 rounded p-2" rows="3">{{ old('description') }}</textarea>
        </div>
        <div>
            <label class="block text-sm mb-1">Позиция</label>
            <input type="number" name="position" value="{{ old('position', 0) }}" class="w-full bg-black/60 rounded p-2" />
        </div>
        <button class="px-4 py-2 bg-orange-600 hover:bg-orange-500 rounded">Сохранить</button>
    </form>
 </div>
@endsection


