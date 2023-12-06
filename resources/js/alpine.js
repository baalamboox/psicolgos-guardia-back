import Alpine from 'alpinejs';
import { data } from './init-alpine';
import { profile } from './admin/profile';
import { dataNotification } from './admin/notifications';
window.Alpine = Alpine;
window.data = data;
window.profile = profile;
window.dataNotification = dataNotification;
Alpine.start();
