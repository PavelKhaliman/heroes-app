@extends('admin.layouts.home.app')

@section('title', 'Клан HEROES - Обзор')

@section('content')
<div class="flex">
    @include('admin.components.sidebar')

    <main class="flex-1 p-6">
        <div class="clan-overview">
            <!-- Welcome Section -->
            <div class="welcome-section text-center">
                <div class="welcome-content">
                    <h1 class="welcome-title mb-8">Информация о клане</h1>
                    <p class="welcome-subtitle text-xl w-full">
                      information
                    </p>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
