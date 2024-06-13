import {Notification} from '../../components/dashboard/Notification';

const firstButton: HTMLButtonElement = document.getElementById('firstBtn') as HTMLButtonElement;
const secondButton: HTMLButtonElement = document.getElementById('secondBtn') as HTMLButtonElement;
const thirdButton: HTMLButtonElement = document.getElementById('thirdBtn') as HTMLButtonElement;

firstButton.addEventListener('click', () => {
    new Notification({
        title: 'Notification',
        message: 'This is a success notification!',
    });
});

secondButton.addEventListener('click', () => {
    new Notification({
        title: 'Notification',
        message: 'This is an error notification!',
        type: 'error',
    });
});

thirdButton.addEventListener('click', () => {
    new Notification({
        title: 'Notification',
        message: 'This is a warning notification!',
        type: 'warning',
    });
});
