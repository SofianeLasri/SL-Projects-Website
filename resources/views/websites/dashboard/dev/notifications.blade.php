@extends('websites.dashboard.layouts.app')

@section('pageName', 'Notifications')

@section('pageContent')
    <div class="p-3">
        <x-button id="firstBtn" class="btn-primary">First Button</x-button>
        <x-button id="secondBtn" class="btn-secondary">Second Button</x-button>
        <x-button id="thirdBtn" class="btn-outline-dark">Third Button</x-button>
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/pages/dashboard/DevNotification.ts'])
@endpush
