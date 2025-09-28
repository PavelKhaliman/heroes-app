@extends('admin.layouts.clan.main')

@section('title', 'Клан HEROES - Заявки')

@section('content')
<div class="clan-overview">
    <div class="welcome-section">
        <div class="welcome-content">
            <h1 class="welcome-title mb-8 text-center">Заявки на вступление</h1>

            @if(session('success'))
                <div class="max-w-6xl mx-auto mb-4 p-3 rounded bg-green-600/20 text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto max-w-6xl mx-auto">
                <table class="w-full text-left border-separate border-spacing-y-2">
                    <thead>
                        <tr class="text-white/80">
                            <th class="px-3 py-2">Имя</th>
                            <th class="px-3 py-2">Возраст</th>
                            <th class="px-3 py-2">Ник</th>
                            <th class="px-3 py-2">
                                <a href="{{ route('admin.clan.application.index', ['sort' => 'status', 'dir' => request('dir') === 'asc' ? 'desc' : 'asc']) }}" class="hover:underline">Статус</a>
                            </th>
                            <th class="px-2 py-2 text-center w-10">
                                <span class="sr-only">Удалить</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 inline-block align-middle text-white/80">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                                    <path d="M10 11v6"></path>
                                    <path d="M14 11v6"></path>
                                    <path d="M9 6V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"></path>
                                </svg>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $app)
                            <tr class="cursor-pointer {{ $app->status === 'accepted' ? 'bg-green-600/20 hover:bg-green-600/30' : ($app->status === 'rejected' ? 'bg-red-600/20 hover:bg-red-600/30' : 'bg-yellow-500/20 hover:bg-yellow-500/30') }}" onclick="window.location='{{ route('admin.clan.application.show', $app) }}'">
                                <td class="px-3 py-2 align-top text-white">{{ $app->name }}</td>
                                <td class="px-3 py-2 align-top text-white">{{ $app->age }}</td>
                                <td class="px-3 py-2 align-top text-white">{{ $app->nic_name }}</td>
                                <td class="px-3 py-2 align-top text-white">{{ $app->status_label }}</td>
                                <td class="px-2 py-2 align-top text-right w-10" onclick="event.stopPropagation();">
                                    <form action="{{ route('admin.clan.application.delete', $app) }}" method="POST" onsubmit="event.stopPropagation(); return confirm('Удалить заявку #{{ $app->id }}?');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-white/70 hover:text-red-400 p-1 rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                                                <path d="M10 11v6"></path>
                                                <path d="M14 11v6"></path>
                                                <path d="M9 6V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-3 py-6 text-center text-white/70" colspan="4">Заявок пока нет</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
