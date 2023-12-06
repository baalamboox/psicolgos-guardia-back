const notificationIcon = document?.querySelector('#notificationIcon');
const notificationSound = new Audio('../sounds/sfx-cartoons10.mp3');

window.message = 'Sin novedad';

const dataNotification = () => {
    return {
        notificationMessage: window.message,
        getMessage() {
            if(isAuthenticated) {
                Echo.channel('notifications').listen('Admin.SendNotifications', (event) => {
                    notificationIcon.hidden = false;
                    window.message = `${event.message}`;
                    this.notificationMessage = window.message;
                    notificationSound.play();
                });
            }
        }
    }
}

export {  dataNotification };
