@extends('layouts.link.main')

@section('title', 'Клан HEROES - Обзор')

@section('content')
<div class="clan-overview">
    <!-- Welcome Section -->
    <div class="welcome-section text-center">
        <div class="welcome-content">
            <h1 class="welcome-title mb-8">Связь</h1>
            <div class="text-left max-w-2xl mx-auto text-white">
                @if(!empty(optional($contact)->telegram))
                    <div class="mb-3"><span class="text-white/70">Telegram:</span> <span class="text-white">{{ $contact->telegram }}</span></div>
                @endif
                @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isModerator() || auth()->user()->isMember()))
                    @if(!empty(optional($contact)->teamspeak))
                        <div class="mb-3"><span class="text-white/70">Teamspeak:</span> <span class="text-white">{{ $contact->teamspeak }}</span></div>
                    @endif
                @endif
                @if(!empty(optional($contact)->officers))
                    <div class="mb-3"><span class="text-white/70">Офицеры:</span>
                        <div class="mt-1 whitespace-pre-wrap break-words">{{ $contact->officers }}</div>
                    </div>
                @endif
                @if(empty(optional($contact)->telegram) && empty(optional($contact)->teamspeak) && empty(optional($contact)->officers))
                    <div class="text-white/70">Информация пока не добавлена.</div>
                @endif
            </div>
        </div>
    </div>
   
</div>
@endsection
