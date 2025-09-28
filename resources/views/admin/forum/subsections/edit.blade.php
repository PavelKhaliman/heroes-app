@extends('admin.layouts.home.app')

@section('content')
<div class="p-6 text-white max-w-xl">
    <h1 class="welcome-title mb-4">Редактировать подраздел: {{ $section->title }}</h1>
    <form method="POST" action="{{ route('admin.forum.subsections.update', [$section, $subsection]) }}" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm mb-1">Заголовок</label>
            <input name="title" value="{{ old('title', $subsection->title) }}" class="w-full bg-black/60 rounded p-2" />
            @error('title')<div class="text-red-400 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-sm mb-1">Slug</label>
            <input name="slug" value="{{ old('slug', $subsection->slug) }}" class="w-full bg-black/60 rounded p-2" />
            @error('slug')<div class="text-red-400 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-sm mb-1">Описание</label>
            <textarea name="description" class="w-full bg-black/60 rounded p-2" rows="3">{{ old('description', $subsection->description) }}</textarea>
        </div>
        <div>
            <label class="block text-sm mb-1">Позиция</label>
            <input type="number" name="position" value="{{ old('position', $subsection->position) }}" class="w-full bg-black/60 rounded p-2" />
        </div>
        <button class="px-4 py-2 bg-orange-600 hover:bg-orange-500 rounded">Сохранить</button>
    </form>
 </div>
@endsection


