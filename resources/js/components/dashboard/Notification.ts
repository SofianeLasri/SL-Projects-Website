import route from 'ziggy-js';

interface NotificationAction {
    text: string;
    callback: (() => void) | string;
}

interface NotificationData {
    title: string;
    message: string;
    date?: Date;
    type?: 'information' | 'warning' | 'error';
    duration?: number;
    primaryAction?: NotificationAction;
    secondaryAction?: NotificationAction;
}

class Notification {
    private static template: HTMLElement | null = null;
    private static notificationsWrapper: HTMLElement | null = null;
    private static queue: Notification[] = [];
    private static isShowing: boolean = false;

    private notificationElement: HTMLElement;
    private data: NotificationData;
    private timeoutId: number | null = null;

    constructor(data: NotificationData, showOnCreation: boolean = true) {
        this.data = {
            type: 'information',
            duration: 5,
            ...data,
        };

        this.notificationElement = document.createElement('div');
        this.init(showOnCreation);
    }

    private async init(showOnCreation: boolean) {
        if (!Notification.template) {
            await Notification.loadTemplate();
        }

        this.notificationElement = Notification.template!.cloneNode(true) as HTMLElement;
        this.populateNotification();

        if (showOnCreation) {
            this.show();
        }
    }

    private static async loadTemplate() {
        const response = await fetch(route('dashboard.ajax.components.notification-html'));
        const html = await response.text();
        const wrapper = document.createElement('div');
        wrapper.innerHTML = html;
        Notification.template = wrapper.querySelector('.notification')!;
        Notification.notificationsWrapper = wrapper.querySelector('#notificationsWrapper')!;
        Notification.notificationsWrapper.innerHTML = '';
        document.body.appendChild(Notification.notificationsWrapper);
    }

    private populateNotification(): void {
        this.setTitle();
        this.setMessage();
        this.setIcon();
        this.setDate();
        this.setActions();
        this.setCloseButton();
    }

    private setTitle() {
        const titleElement = this.notificationElement.querySelector('.title')!;
        titleElement.textContent = this.data.title;
    }

    private setMessage() {
        const messageElement = this.notificationElement.querySelector('p')!;
        messageElement.textContent = this.data.message;
    }

    private setIcon() {
        const iconElement = this.notificationElement.querySelector('.icon i')!;
        const iconClass = this.getIconClass(this.data.type!);
        iconElement.className = `fa-solid ${iconClass}`;
    }

    private getIconClass(type: string): string {
        switch (type) {
            case 'warning':
                return 'fa-circle-exclamation';
            case 'error':
                return 'fa-circle-xmark';
            default:
                return 'fa-circle-info';
        }
    }

    private setDate() {
        const dateElement = this.notificationElement.querySelector('.date') as HTMLElement;
        if (this.data.date) {
            dateElement.textContent = this.formatDate(this.data.date);
        } else {
            dateElement.style.display = 'none';
        }
    }

    private formatDate(date: Date): string {
        const daysOfWeek = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        const now = new Date();
        const diffSeconds = Math.floor((now.getTime() - date.getTime()) / 1000);
        const diffMinutes = Math.floor(diffSeconds / 60);
        const diffHours = Math.floor(diffMinutes / 60);
        const diffDays = Math.floor(diffHours / 24);
        const diffWeeks = Math.floor(diffDays / 7);
        const diffMonths = Math.floor(diffDays / 30);
        const diffYears = Math.floor(diffDays / 365);

        const formatTime = (date: Date) => {
            const hours = date.getHours().toString().padStart(2, '0');
            const minutes = date.getMinutes().toString().padStart(2, '0');
            return `${hours}H${minutes}`;
        };

        if (diffDays === 0) {
            return `Aujd à ${formatTime(date)}`;
        } else if (diffDays === 1) {
            return `Hier à ${formatTime(date)}`;
        } else if (diffDays < 7) {
            return `${daysOfWeek[date.getDay()]} à ${formatTime(date)}`;
        } else if (diffWeeks < 4) {
            return `Il y a ${diffWeeks} semaines`;
        } else if (diffMonths < 12) {
            return `Il y a ${diffMonths} mois`;
        } else {
            return `Il y a ${diffYears} ans`;
        }
    }

    private setActions() {
        const actionsContainer = this.notificationElement.querySelector('.actions') as HTMLElement;
        const primaryButton = actionsContainer.querySelector('.primary') as HTMLButtonElement;
        const secondaryButton = actionsContainer.querySelector('.secondary') as HTMLButtonElement;

        if (this.data.primaryAction) {
            primaryButton.textContent = this.data.primaryAction.text;
            this.setActionCallback(primaryButton, this.data.primaryAction.callback);
        } else {
            primaryButton.style.display = 'none';
        }

        if (this.data.secondaryAction) {
            secondaryButton.textContent = this.data.secondaryAction.text;
            this.setActionCallback(secondaryButton, this.data.secondaryAction.callback);
        } else {
            secondaryButton.style.display = 'none';
        }

        if (!this.data.primaryAction && !this.data.secondaryAction) {
            actionsContainer.style.display = 'none';
        }
    }

    private setActionCallback(button: HTMLButtonElement, callback: (() => void) | string) {
        if (typeof callback === 'string') {
            button.addEventListener('click', () => {
                window.location.href = callback;
            });
        } else {
            button.addEventListener('click', callback);
        }
    }

    private setCloseButton() {
        const closeButton = this.notificationElement.querySelector('.close')!;
        closeButton.addEventListener('click', () => this.close());
    }

    public show() {
        if (!Notification.notificationsWrapper) {
            throw new Error('Notifications wrapper not found. Make sure the template has been loaded.');
        }

        Notification.queue.push(this);
        if (!Notification.isShowing) {
            this.displayNext();
        }
    }

    private displayNext() {
        if (Notification.queue.length === 0) {
            Notification.isShowing = false;
            return;
        }

        Notification.isShowing = true;
        const nextNotification = Notification.queue.shift()!;
        Notification.notificationsWrapper!.appendChild(nextNotification.notificationElement);

        nextNotification.notificationElement.addEventListener('mouseover', () => {
            if (nextNotification.timeoutId) {
                clearTimeout(nextNotification.timeoutId);
                nextNotification.timeoutId = null;
            }
        });

        nextNotification.notificationElement.addEventListener('mouseout', () => {
            nextNotification.startAutoClose();
        });

        nextNotification.startAutoClose();
    }

    private startAutoClose() {
        this.timeoutId = window.setTimeout(() => this.close(), this.data.duration! * 1000);
    }

    private close() {
        if (this.timeoutId) {
            clearTimeout(this.timeoutId);
        }

        this.notificationElement.remove();
        this.displayNext();
    }
}

export {Notification, NotificationData, NotificationAction};
