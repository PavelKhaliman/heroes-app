@extends('admin.layouts.clan.main')

@section('title', 'Клан HEROES - Обзор')

@section('content')
<div class="clan-overview">
    <!-- Welcome Section -->
    <div class="welcome-section text-center">
        <div class="welcome-content">
            <h1 class="welcome-title mb-8">Информация о клане</h1>
            @if(!empty(optional($clan)->info))
            <div class="welcome-subtitle text-xl w-full text-left max-w-4xl mx-auto mb-6">
                {!! nl2br(e($clan->info)) !!}
            </div>
            @endif
            <div class="flex gap-4 justify-center">
                <a href="/admin/clan/info/create" class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-medium px-5 py-2 rounded-lg transition-colors">Добавить/обновить информацию</a>
               
            </div>
        </div>
    </div>
   
</div>
@endsection
