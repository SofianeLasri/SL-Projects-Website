<div class="step-group-list-container">
    <div class="steps-group-list">
        <h5>{{ $title }}</h5>
        <div class="d-flex flex-column gap-2">
            @foreach($steps as $step)
                <x-button id="btn{{ ucfirst($step['id']) }}" type="button"
                          class="btn-light text-start d-flex align-items-center gap-2 {{ (!empty($step['active'])) ? 'active' : '' }}">
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
