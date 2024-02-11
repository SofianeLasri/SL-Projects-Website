<div class="step-group-list-container">
    <div class="steps-group-list">
        <div class="top">
            <h5>{{ $title }}</h5>
            <i class="mobile-dropdown fa-solid fa-chevron-down"></i>
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

@pushonce('scripts')
    <script type="text/javascript">
        const stepsGroupLists = document.querySelectorAll('.step-group-list-container');
        stepsGroupLists.forEach(stepsGroupList => {
            const top = stepsGroupList.querySelector('.top');
            const content = stepsGroupList.querySelector('.content');
            const mobileDropdown = stepsGroupList.querySelector('.mobile-dropdown');
            const steps = content.querySelectorAll('button[data-target]');

            top.addEventListener('click', () => {
                if (window.matchMedia('(max-width: 900px)').matches) {
                    content.classList.toggle('hide');

                    if (content.classList.contains('hide')) {
                        mobileDropdown.classList.remove('fa-chevron-down');
                        mobileDropdown.classList.add('fa-chevron-up');
                    } else {
                        mobileDropdown.classList.remove('fa-chevron-up');
                        mobileDropdown.classList.add('fa-chevron-down');
                    }
                }
            });

            let allStepsTarget = [];
            steps.forEach(step => {
                allStepsTarget.push(step.getAttribute('data-target'));

                step.addEventListener('click', () => {
                    allStepsTarget.forEach(target => {
                        const targetContent = document.getElementById(target);
                        if (target === step.getAttribute('data-target')) {
                            targetContent.classList.remove('d-none');
                        } else {
                            targetContent.classList.add('d-none');
                        }
                    });

                    steps.forEach(s => {
                        s.classList.remove('active');
                    });
                    step.classList.add('active');
                });
            });
        });
    </script>
@endpushonce
