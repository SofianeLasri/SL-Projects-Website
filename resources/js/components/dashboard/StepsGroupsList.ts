class StepsGroupsList {
    static stepsGroupLists: Array<StepsGroupsList> = [];
    private parentElement: HTMLElement;
    private stepsListTopElement: HTMLElement;
    private stepsContainer: HTMLElement;
    private mobileDropdownIcon: HTMLElement;
    private readonly stepsButtons: Array<HTMLButtonElement>;
    private allStepsTargets: Array<string> = [];

    constructor(parentElementId: string) {
        let foundParentElement: HTMLElement | null = document.getElementById(parentElementId);
        if (foundParentElement === null) {
            throw new Error("StepsGroupsList: Parent element not found");
        }

        this.parentElement = foundParentElement;
        this.stepsListTopElement = this.parentElement.querySelector('.top')!;
        this.stepsContainer = this.parentElement.querySelector('.content')!;
        this.mobileDropdownIcon = this.parentElement.querySelector('.mobile-dropdown-icon')!;
        this.stepsButtons = Array.from(this.stepsContainer.querySelectorAll('button[data-target]'));

        this.stepsButtons.forEach((button, index) => {
            button.addEventListener('click', () => this.onStepButtonClick(index));
            this.allStepsTargets.push(button.dataset.target!);
        });

        this.stepsListTopElement.addEventListener('click', () => this.onMobileDropdownIconClick());
        StepsGroupsList.stepsGroupLists.push(this);
    }

    private onStepButtonClick(index: number) {
        let target: string = this.allStepsTargets[index];
        let stepButton: HTMLButtonElement = this.stepsButtons[index];
        let targetElement: HTMLElement | null = document.getElementById(target);
        if (targetElement === null) {
            throw new Error("StepsGroupsList: Target element not found");
        }

        this.stepsButtons.forEach((button) => {
            button.classList.remove('active');
        });

        stepButton.classList.add('active');

        this.allStepsTargets.forEach(target => {
            const targetContent = document.getElementById(target)!;
            if (target === stepButton.getAttribute('data-target')) {
                targetContent.classList.remove('d-none');
            } else {
                targetContent.classList.add('d-none');
            }
        });
    }

    private onMobileDropdownIconClick() {
        if (window.matchMedia('(max-width: 900px)').matches) {
            this.stepsContainer.classList.toggle('hide');

            if (this.stepsContainer.classList.contains('hide')) {
                this.mobileDropdownIcon.classList.remove('fa-chevron-down');
                this.mobileDropdownIcon.classList.add('fa-chevron-up');
            } else {
                this.mobileDropdownIcon.classList.remove('fa-chevron-up');
                this.mobileDropdownIcon.classList.add('fa-chevron-down');
            }
        }
    }
}

export default StepsGroupsList;
