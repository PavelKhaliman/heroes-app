@extends('admin.layouts.clan.main')

@section('title', 'Клан HEROES - Заявка')

@section('content')
<div class="clan-overview">
    <div class="welcome-section">
        <div class="welcome-content">
            <h1 class="welcome-title mb-8 text-center">Заявка #{{ $application->id }}</h1>

            @if(session('success'))
                <div class="max-w-4xl mx-auto mb-4 p-3 rounded bg-green-600/20 text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="max-w-4xl mx-auto space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-white/5 rounded p-3">
                        <div class="text-white/70 text-sm">Имя</div>
                        <div class="text-white text-lg">{{ $application->name }}</div>
                    </div>
                    <div class="bg-white/5 rounded p-3">
                        <div class="text-white/70 text-sm">Возраст</div>
                        <div class="text-white text-lg">{{ $application->age }}</div>
                    </div>
                    <div class="bg-white/5 rounded p-3">
                        <div class="text-white/70 text-sm">Ник</div>
                        <div class="text-white text-lg">{{ $application->nic_name }}</div>
                    </div>
                    <div class="bg-white/5 rounded p-3">
                        <div class="text-white/70 text-sm">Класс персонажа</div>
                        <div class="text-white text-lg">{{ $application->charecter_class }}</div>
                    </div>
                    <div class="bg-white/5 rounded p-3">
                        <div class="text-white/70 text-sm">Уровень</div>
                        <div class="text-white text-lg">{{ $application->level }}</div>
                    </div>
                    <div class="bg-white/5 rounded p-3">
                        <div class="text-white/70 text-sm">Боевые качества</div>
                        <div class="text-white text-lg">{{ $application->strong }}</div>
                    </div>
                    <div class="bg-white/5 rounded p-3">
                        <div class="text-white/70 text-sm">Выживаемость</div>
                        <div class="text-white text-lg">{{ $application->survival }}</div>
                    </div>
                    <div class="bg-white/5 rounded p-3">
                        <div class="text-white/70 text-sm">Прайм (МСК)</div>
                        <div class="text-white text-lg">{{ $application->prime_msk }}</div>
                    </div>
                    <div class="bg-white/5 rounded p-3 sm:col-span-2">
                        <div class="text-white/70 text-sm">КОСы</div>
                        <div class="text-white text-lg">{{ $application->kos_list }}</div>
                    </div>
                    <div class="bg-white/5 rounded p-3 sm:col-span-2">
                        <div class="text-white/70 text-sm">Статус</div>
                        <div class="text-white text-lg">{{ $application->status_label }}</div>
                    </div>
                    <div class="bg-white/5 rounded p-3 sm:col-span-2">
                        <div class="text-white/70 text-sm">О себе</div>
                        <div class="text-white whitespace-pre-wrap">{{ $application->info }}</div>
                    </div>
                </div>

                <div class="bg-white/5 rounded p-4">
                    <div class="text-white/80 font-semibold mb-2">Голосование</div>
                    <div class="text-white/70 text-sm mb-3">Сумма: <span class="text-green-400">За {{ $application->votes_for }}</span> / <span class="text-red-400">Против {{ $application->votes_against }}</span></div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-black/40 rounded p-3">
                            <div class="text-sm text-green-400 font-semibold mb-2">Проголосовали ЗА ({{ $application->votes->where('vote','for')->count() }})</div>
                            <ul class="text-sm text-white/90 list-disc list-inside space-y-1">
                                @forelse($application->votes->where('vote','for') as $v)
                                    <li>{{ $v->user->nickname ?? $v->user->name }}</li>
                                @empty
                                    <li class="text-white/60">Нет голосов</li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="bg-black/40 rounded p-3">
                            <div class="text-sm text-red-400 font-semibold mb-2">Проголосовали ПРОТИВ ({{ $application->votes->where('vote','against')->count() }})</div>
                            <ul class="text-sm text-white/90 list-disc list-inside space-y-1">
                                @forelse($application->votes->where('vote','against') as $v)
                                    <li>{{ $v->user->nickname ?? $v->user->name }}</li>
                                @empty
                                    <li class="text-white/60">Нет голосов</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    
                    <form action="{{ route('admin.clan.application.status.update', $application) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="accepted">
                        <button class="bg-green-600 hover:bg-green-700 text-white font-medium px-5 py-2 rounded-lg transition-colors">Принять</button>
                    </form>
                    <form action="{{ route('admin.clan.application.status.update', $application) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="pending">
                        <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-5 py-2 rounded-lg transition-colors">В ожидание</button>
                    </form>
                    <form action="{{ route('admin.clan.application.status.update', $application) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="rejected">
                        <button class="bg-red-600 hover:bg-red-700 text-white font-medium px-5 py-2 rounded-lg transition-colors">Отклонить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
