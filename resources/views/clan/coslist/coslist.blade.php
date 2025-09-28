@extends('layouts.clan.main')

@section('title', 'Клан HEROES - Обзор')

@section('content')
<div class="clan-overview">
    <div class="welcome-section">
        <div class="welcome-content">
            <h1 class="welcome-title mb-8 text-center">Кос лист</h1>

            @php
                $players = $coslists->filter(function($i){ return !empty($i->nicname) && $i->nicname !== '-'; });
                $guilds = $coslists->filter(function($i){ return empty($i->nicname) || $i->nicname === '-'; });
            @endphp

            <div class="space-y-10">
                <div>
                    <h2 class="text-xl mb-3 text-white">Игроки</h2>
                    @if($players->isEmpty())
                        <div class="text-white/80">Игроков в кос-листе пока нет.</div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-fixed text-left border-separate border-spacing-y-2 text-white">
                                <colgroup>
                                    <col style="width:200px" />
                                    <col style="width:200px" />
                                    <col style="width:400px" />
                                    <col style="width:200px" />
                                </colgroup>
                                <thead class="text-white">
                                    <tr>
                                        <th class="px-4 py-2">Ник</th>
                                        <th class="px-4 py-2">Клан</th>
                                        <th class="px-4 py-2">Причина</th>
                                        <th class="px-4 py-2">Выкуп</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($players as $item)
                                        <tr class="bg-white/5 align-top">
                                            <td class="px-4 py-2 break-words">{{ $item->nicname }}</td>
                                            <td class="px-4 py-2 break-words">{{ $item->guild }}</td>
                                            <td class="px-4 py-2 break-words">{{ $item->reason }}</td>
                                            <td class="px-4 py-2 break-words">{{ $item->repayment }}</td>
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
                        <div class="text-white/80">Кланов в кос-листе пока нет.</div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-fixed text-left border-separate border-spacing-y-2 text-white">
                                <colgroup>
                                    <col style="width:200px" />
                                    <col style="width:200px" />
                                    <col style="width:400px" />
                                    <col style="width:200px" />
                                </colgroup>
                                <thead class="text-white">
                                    <tr>
                                        <th class="px-4 py-2">Клан</th>
                                        <th class="px-4 py-2">Мастер</th>
                                        <th class="px-4 py-2">Причина</th>
                                        <th class="px-4 py-2">Выкуп</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($guilds as $item)
                                        <tr class="bg-white/5 align-top">
                                            <td class="px-4 py-2 break-words">{{ $item->guild }}</td>
                                            <td class="px-4 py-2 break-words">{{ $item->master }}</td>
                                            <td class="px-4 py-2 break-words">{{ $item->reason }}</td>
                                            <td class="px-4 py-2 break-words">{{ $item->repayment }}</td>
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
