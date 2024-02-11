<div id="{{ $id }}" class="step-group-list-container">
    <div class="steps-group-list">
        <div class="top">
            <h5>{{ $title }}</h5>
            <i class="mobile-dropdown-icon fa-solid fa-chevron-down"></i>
        </div>
        <div class="content">
            @foreach($steps as $step)
                <x-button id="btn{{ ucfirst($step['id']) }}" type="button"
                          class="btn-light text-start d-flex align-items-center gap-2 {{ (!empty($step['active'])) ? 'active' : '' }}"
                          data-target="{{ $step['id'] }}">
                    @if($useCheckIcon)
                        <i class="fa-regular fa-circle-check"></i>
                    @endif
                    {{ $step['title'] }}
                </x-button>
            @endforeach
        </div>
    </div>
    <div class="steps-group-content">
        {{ $slot }}
    </div>
</div>

@push('scripts')
    <script type="module">
        const stepsGroupList = new StepsGroupsList('{{ $id }}');
    </script>
@endpush
