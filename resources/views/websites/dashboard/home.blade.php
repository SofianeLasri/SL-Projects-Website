@extends('websites.dashboard.layouts.app')

@section('pageName', 'Accueil')

@section('pageContent')
    <div class="px-3 py-2">
        <h3>Il n'y a rien à voir ici</h3>
        {{ request()->cookie('isDashboardSidebarOpened') }}
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">

    </script>
@endpush
