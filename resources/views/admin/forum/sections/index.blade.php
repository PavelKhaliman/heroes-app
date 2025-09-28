@extends('admin.layouts.home.app')

@section('content')
<div class="p-6 text-white">
    <div class="flex items-center justify-between mb-4">
        <h1 class="welcome-title">Разделы форума</h1>
        <a href="{{ route('admin.forum.sections.create') }}" class="px-4 py-2 bg-orange-600 hover:bg-orange-500 rounded">Добавить раздел</a>
    </div>

    <div class="space-y-4">
        @foreach($sections as $section)
            <div class="bg-black/60 rounded p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-lg font-semibold">{{ $section->title }}</div>
                        <div class="text-xs text-gray-400">slug: {{ $section->slug }} • позиция: {{ $section->position }}</div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.forum.sections.edit', $section) }}" class="px-3 py-1 bg-blue-600 hover:bg-blue-500 rounded">Изменить</a>
                        <form method="POST" action="{{ route('admin.forum.sections.destroy', $section) }}">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 bg-red-600 hover:bg-red-500 rounded" onclick="return confirm('Удалить раздел?')">Удалить</button>
                        </form>
                        <a href="{{ route('admin.forum.subsections.create', $section) }}" class="px-3 py-1 bg-orange-700 hover:bg-orange-600 rounded">Добавить подраздел</a>
                    </div>
                </div>
                @if($section->subsections->count())
                    <ul class="mt-3 grid md:grid-cols-2 gap-2">
                        @foreach($section->subsections as $sub)
                            <li class="bg-black/40 rounded p-3 flex items-center justify-between hover:bg-black/60 hover:ring-1 hover:ring-orange-500 transition">
                                <div>
                                    <div class="font-medium">{{ $sub->title }}</div>
                                    <div class="text-xs text-gray-400">slug: {{ $sub->slug }} • позиция: {{ $sub->position }}</div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.forum.subsections.edit', [$section, $sub]) }}" class="px-3 py-1 bg-blue-600 hover:bg-blue-500 rounded">Изменить</a>
                                    <form method="POST" action="{{ route('admin.forum.subsections.destroy', [$section, $sub]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 bg-red-600 hover:bg-red-500 rounded" onclick="return confirm('Удалить подраздел?')">Удалить</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection


