@extends('admin.layouts.clan.main')

@section('title', 'Клан HEROES - Кос лист')

@section('content')
<div class="clan-overview">
    <div class="welcome-section">
        <div class="welcome-content">
            <div class="flex items-center justify-between mb-6">
                <h1 class="welcome-title">Кос лист</h1>
                <div class="flex gap-3">
                    <a href="{{ route('admin.clan.coslist.create.personal') }}" class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-medium px-5 py-2 rounded-lg transition-colors">Добавить игрока</a>
                    <a href="{{ route('admin.clan.coslist.create.guild') }}" class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-medium px-5 py-2 rounded-lg transition-colors">Добавить клан</a>
                </div>
            </div>

			@php
				$players = $coslists->filter(function($i){ return !empty($i->nicname) && $i->nicname !== '-'; });
				$guilds = $coslists->filter(function($i){ return empty($i->nicname) || $i->nicname === '-'; });
			@endphp

			<div class="space-y-10">
				<div>
					<h2 class="text-xl mb-3 text-white">Игроки</h2>
					@if($players->isEmpty())
						<div class="text-white">Игроков в кос-листе пока нет.</div>
					@else
						<div class="overflow-x-auto">
							<table class="min-w-full table-fixed text-left border-separate border-spacing-y-2 text-white">
								<colgroup>
									<col style="width:200px" />
									<col style="width:200px" />
									<col style="width:400px" />
									<col style="width:200px" />
									<col style="width:200px" />
                                </colgroup>
								<thead class="text-white">
									<tr>
									<th class="px-4 py-2">Ник</th>
									<th class="px-4 py-2">Клан</th>
									<th class="px-4 py-2">Причина</th>
									<th class="px-4 py-2">Выкуп</th>
                                    <th class="px-4 py-2 text-center">Действия</th>
									</tr>
								</thead>
								<tbody>
									@foreach($players as $item)
										<tr class="bg-white/5 align-top">
										<td class="px-4 py-2 break-words">{{ $item->nicname }}</td>
										<td class="px-4 py-2 break-words">{{ $item->guild }}</td>
										<td class="px-4 py-2 break-words">{{ $item->reason }}</td>
										<td class="px-4 py-2 break-words">{{ $item->repayment }}</td>
                                        <td class="px-2 py-2 align-middle text-center w-10" onclick="event.stopPropagation();">
                                            <a href="{{ route('admin.clan.coslist.edit', $item) }}" class="text-white/80 hover:text-white underline mr-2">Редактировать</a>
                                            <form action="{{ route('admin.clan.coslist.delete', $item) }}" method="POST" onsubmit="event.stopPropagation(); return confirm('Удалить запись #{{ $item->id }}?');" class="inline-block">
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
									@endforeach
								</tbody>
							</table>
						</div>
					@endif
				</div>

				<div>
					<h2 class="text-xl mb-3 text-white">Кланы</h2>
					@if($guilds->isEmpty())
						<div class="text-white">Кланов в кос-листе пока нет.</div>
					@else
						<div class="overflow-x-auto">
							<table class="min-w-full table-fixed text-left border-separate border-spacing-y-2 text-white">
								<colgroup>
									<col style="width:200px" />
									<col style="width:200px" />
									<col style="width:400px" />
									<col style="width:200px" />
									<col style="width:200px" />
                                </colgroup>
								<thead class="text-white">
									<tr>
									<th class="px-4 py-2">Клан</th>
									<th class="px-4 py-2">Мастер</th>
									<th class="px-4 py-2">Причина</th>
									<th class="px-4 py-2">Выкуп</th>
                                    <th class="px-4 py-2 text-center">Действия</th>
									</tr>
								</thead>
								<tbody>
									@foreach($guilds as $item)
										<tr class="bg-white/5 align-top">
										<td class="px-4 py-2 break-words">{{ $item->guild }}</td>
										<td class="px-4 py-2 break-words">{{ $item->master }}</td>
										<td class="px-4 py-2 break-words">{{ $item->reason }}</td>
										<td class="px-4 py-2 break-words">{{ $item->repayment }}</td>
                                        <td class="px-2 py-2 align-middle text-center w-10" onclick="event.stopPropagation();">
                                            <a href="{{ route('admin.clan.coslist.edit', $item) }}" class="text-white/80 hover:text-white underline mr-2">Редактировать</a>
                                            <form action="{{ route('admin.clan.coslist.delete', $item) }}" method="POST" onsubmit="event.stopPropagation(); return confirm('Удалить запись #{{ $item->id }}?');" class="inline-block">
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
									@endforeach
								</tbody>
							</table>
						</div>
					@endif
				</div>
			</div>
        </div>
    </div>

</div>
@endsection
