@extends('layouts.home.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 text-white">
    <h1 class="welcome-title mb-6">Голосование</h1>

    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-600/20 text-green-200">{{ session('success') }}</div>
    @endif

    @forelse($applications as $app)
        <div class="bg-black/60 rounded p-4 mb-4">
            <div class="flex justify-between items-start gap-4">
                <div class="min-w-0">
                    <div class="text-lg font-semibold">{{ $app->nic_name }} ({{ $app->charecter_class }})</div>
                    <div class="text-sm text-gray-300">Уровень: {{ $app->level }} · Возраст: {{ $app->age }} · Прайм (МСК): {{ $app->prime_msk }}</div>
                    <div class="mt-2 text-sm text-gray-300">Статус: {{ $app->status_label }}</div>
                    <div class="mt-2 text-sm">БОЕВЫЕ: {{ $app->strong }}, ВЫЖИВАЕМОСТЬ: {{ $app->survival }}, КОСы: {{ $app->kos_list }}</div>
                    <div class="mt-2 whitespace-pre-wrap">{{ $app->info }}</div>

                    @php $role = auth()->user()->role ?? null; @endphp
                    @if(in_array($role, ['admin','moderator']))
                        <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="bg-black/40 rounded p-3">
                                <div class="text-sm text-green-400 font-semibold mb-2">Проголосовали ЗА ({{ $app->votes->where('vote','for')->count() }})</div>
                                <ul class="text-sm text-white/90 list-disc list-inside space-y-1">
                                    @forelse($app->votes->where('vote','for') as $v)
                                        <li>{{ $v->user->nickname ?? $v->user->name }}</li>
                                    @empty
                                        <li class="text-white/60">Нет голосов</li>
                                    @endforelse
                                </ul>
                            </div>
                            <div class="bg-black/40 rounded p-3">
                                <div class="text-sm text-red-400 font-semibold mb-2">Проголосовали ПРОТИВ ({{ $app->votes->where('vote','against')->count() }})</div>
                                <ul class="text-sm text-white/90 list-disc list-inside space-y-1">
                                    @forelse($app->votes->where('vote','against') as $v)
                                        <li>{{ $v->user->nickname ?? $v->user->name }}</li>
                                    @empty
                                        <li class="text-white/60">Нет голосов</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="text-right shrink-0">
                    <div class="text-sm text-gray-300">Голоса: <span class="text-green-400">За {{ $app->votes_for }}</span> / <span class="text-red-400">Против {{ $app->votes_against }}</span></div>
                    <form method="POST" action="{{ route('member.applications.vote', $app) }}" class="mt-2 flex gap-2">
                        @csrf
                        <input type="hidden" name="vote" value="for">
                        <button class="px-4 py-2 rounded bg-green-600 hover:bg-green-500">ЗА</button>
                    </form>
                    <form method="POST" action="{{ route('member.applications.vote', $app) }}" class="mt-2 flex gap-2">
                        @csrf
                        <input type="hidden" name="vote" value="against">
                        <button class="px-4 py-2 rounded bg-red-600 hover:bg-red-500">ПРОТИВ</button>
                    </form>
                    @php $my = $userVotes[$app->id] ?? null; @endphp
                    @if($my)
                        <div class="mt-2 text-xs text-gray-400">Ваш голос: {{ $my === 'for' ? 'ЗА' : 'ПРОТИВ' }}</div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="text-gray-400">Новых заявок для голосования нет.</div>
    @endforelse

    @if(method_exists($applications, 'links'))
        <div class="mt-6">
            {{ $applications->links() }}
        </div>
    @endif
</div>
@endsection
