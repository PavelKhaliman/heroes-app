@extends('layouts.clan.main')

@section('title', 'Клан HEROES - Обзор')

@section('content')
<div class="clan-overview">
    <!-- Welcome Section -->
    <div class="welcome-section text-center">
        <div class="welcome-content">
            <h1 class="welcome-title mb-8">Информация о клане</h1>
            @if(!empty(optional($clan)->info))
            <div class="welcome-subtitle text-xl w-full text-left max-w-4xl mx-auto">
              {!! nl2br(e($clan->info)) !!}
            </div>
            @else
            <p class="welcome-subtitle text-xl w-full">Информация отсутствует</p>
            @endif
        </div>
    </div>
   
</div>
@endsection
