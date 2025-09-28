@extends('admin.layouts.clan.main')

@section('title', 'Админка - Пользователи')

@section('content')
<div class="clan-overview">
    <div class="welcome-section">
        <div class="welcome-content">
            <h1 class="welcome-title mb-6">Пользователи</h1>

            @if($users->isEmpty())
                <div class="text-white/80">Пока нет пользователей.</div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full table-fixed text-left border-separate border-spacing-y-2 text-white">
                        <colgroup>
                            <col style="width:30%" />
                            <col style="width:40%" />
                            <col style="width:20%" />
                            <col style="width:10%" />
                        </colgroup>
                        <thead class="text-white">
                            <tr>
                                <th class="px-4 py-2">Ник</th>
                                <th class="px-4 py-2">Имя</th>
                                <th class="px-4 py-2">Роль</th>
                                <th class="px-4 py-2 text-center">Удалить</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="bg-white/5 align-top hover:bg-white/10 transition-colors cursor-pointer" onclick="window.location='{{ route('admin.users.show', $user) }}'">
                                    <td class="px-4 py-2 break-words">{{ $user->nickname ?? '—' }}</td>
                                    <td class="px-4 py-2 break-words">{{ $user->name }}</td>
                                    <td class="px-4 py-2 break-words">{{ strtoupper($user->role) }}</td>
                                    <td class="px-2 py-2 align-middle text-center w-10" onclick="event.stopPropagation();">
                                        @php($current = auth()->user())
                                        @if(!($current && $current->isModerator() && $user->isAdmin()))
                                            <form action="{{ route('admin.users.delete', $user) }}" method="POST" onsubmit="event.stopPropagation(); return confirm('Удалить пользователя #{{ $user->id }}?');" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-white/70 hover:text-red-400 p-1 rounded" title="Удалить">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                                                        <path d="M10 11v6"></path>
                                                        <path d="M14 11v6"></path>
                                                        <path d="M9 6V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">{{ $users->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection


