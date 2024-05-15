import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue';
import router from './router';
import axios from 'axios';

// // Add a request interceptor
// axios.interceptors.request.use(config => {
//     const token = localStorage.getItem('auth_token');
//     if (token) {
//         config.headers.Authorization = `Bearer ${token}`;
//     }
//     return config;
// }, error => {
//     return Promise.reject(error);
// });

// export default axios;

import flashmessage from '@/components/Flash.vue';
import DashboardIndex from '@/components/DashboardIndex.vue';

import Feedbacks from '@/components/feedbacks/index.vue';
import CreateFeedback from '@/components/feedbacks/create.vue';
import EditFeedback from '@/components/feedbacks/edit.vue';

createApp({
    components: {
        flashmessage,
    	DashboardIndex,
    	Feedbacks,
        CreateFeedback,
        EditFeedback,
    }
}).use(router).mount('#app')