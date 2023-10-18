import Alpine from 'alpinejs';
import { data } from './init-alpine';
import { profile } from './admin/profile';
window.Alpine = Alpine;
window.data = data;
window.profile = profile;
Alpine.start();
