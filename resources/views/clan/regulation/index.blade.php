@extends('layouts.clan.main')

@section('title', 'Клан HEROES - Обзор')

@section('content')
<div class="clan-overview">
    <!-- Welcome Section -->
    <div class="welcome-section text-center">
        <div class="welcome-content">
            <h1 class="welcome-title mb-8">Устав клана</h1>
            @if(!empty(optional($clan)->regulation))
            <div class="welcome-subtitle text-xl w-full text-left max-w-4xl mx-auto">
              {!! nl2br(e($clan->regulation)) !!}
            </div>  
            @else
            <p class="welcome-subtitle text-xl w-full">Информация отсутствует</p>
            @endif
        </div>
    </div>
   
</div>
@endsection
