import { createRouter, createWebHistory } from 'vue-router'

import DashboardIndex from '@/components/DashboardIndex.vue'

import Feedbacks from '@/components/feedbacks/index.vue'
import CreateFeedback from '@/components/feedbacks/create.vue'
import EditFeedback from '@/components/feedbacks/edit.vue'

const routes = [
    {
        path: '/dashboard',
        name: 'dashboardView',
        component: DashboardIndex
    },
    {
        path: '/feedbacks',
        name: 'feedbacksView',
        component: Feedbacks
    },
    {
        path: '/feedbacks/create',
        name: 'createFeedbackView',
        component: CreateFeedback
    },
    {
        path: '/feedbacks/:id/edit',
        name: 'editFeedbackView',
        component: EditFeedback
    },
];
 
export default createRouter({
    history: createWebHistory(),
    routes
})