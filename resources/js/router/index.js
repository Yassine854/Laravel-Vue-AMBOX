
import {createWebHistory, createRouter} from "vue-router";
import {
    checkUserRole
  } from "../auth";

// import Home from '../pages/Home';
import Register from '../pages/Register';
import Login from '../pages/Login';

import DashboardAdmin from '../components/admin/Dashboard';
import DashboardExpediteur from '../components/expediteur/Dashboard';
import DashboardLivreur from '../components/livreur/Dashboard';

import admins from '../components/admin/admin';
import expediteurs from '../components/admin/expediteur';
import livreurs from '../components/admin/livreur';
import colisAdmin from '../components/admin/coli';
import colisExpediteur from '../components/expediteur/coli';


export const routes = [

    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'login',
        path: '/',
        component: Login
    },

    {
        name: 'dashboard-admin',
        path: '/dashboard-admin',
        component: DashboardAdmin
    },
    {
        name: 'dashboard-expediteur',
        path: '/dashboard-expediteur',
        component: DashboardExpediteur,
    },
    {
        name: 'dashboard-livreur',
        path: '/dashboard-livreur',
        component: DashboardLivreur
    },
    {
        name: 'admins',
        path: '/admins',
        component: admins
    },
    {
        name: 'expediteurs',
        path: '/expediteurs',
        component: expediteurs
    },
    {
        name: 'livreurs',
        path: '/livreurs',
        component: livreurs
    },
    {
        name: 'colis_admin',
        path: '/admin/colis',
        component: colisAdmin
    },
    {
        name: 'colis_expediteur',
        path: '/expediteur/colis',
        component: colisExpediteur
    },

];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
