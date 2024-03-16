
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
import colisLivreur from '../components/livreur/coli';
import agence from '../components/livreur/agence';
import pickup_livreur from '../components/livreur/pickup';
import pickup_livreur_colis from '../components/livreur/pickup_coli';
import manifeste from '../components/admin/manifeste';
import Encours from '../components/livreur/Encours';
import paiement_colis from '../components/admin/paiement_colis';
import paiement from '../components/admin/paiement';
import paiement_expediteurs from '../components/admin/paiement_expediteurs';
import paiement_expediteur_layout from '../components/expediteur/paiement';
import Retour from '../components/admin/retour';
import livraison from '../components/admin/livraison';
import livraison_livreurs from '../components/admin/livraison_livreurs';
import livraison_liv from '../components/livreur/livraison';

import profile_admin from '../components/admin/profile';
import profile_expediteur from '../components/expediteur/profile';
import profile_livreur from '../components/livreur/profile';

import PageNotFound from '../pages/PageNotFound'
import forgotPassword from '../pages/ForgotPassword'
import resetPassword from '../pages/ResetPassword'



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
    {
        name: 'colis_livreur',
        path: '/livreur/colis/:agence',
        component: colisLivreur,
        props: route => ({ agence: route.params.agence }),
    },
    {
        name: 'agence',
        path: '/livreur/agence',
        component: agence
    },
    {
        name: 'pickup_livreur',
        path: '/livreur/pickup',
        component: pickup_livreur
    },
    {
        name: 'pickup_livreur_colis',
        path: '/livreur/pickup/colis/:expediteur',
        component: pickup_livreur_colis,
        props: route => ({ expediteur: route.params.expediteur }),
    },
    {
        name: 'manifeste',
        path: '/admin/manifeste',
        component: manifeste
    },
    {
        name: 'Encours',
        path: '/colis/Encours',
        component: Encours
    },
    {
        name: 'paiement_colis',
        path: '/admin/paiement_colis',
        component: paiement_colis
    },
    {
        name: 'paiement',
        path: '/admin/paiement_expediteurs',
        component: paiement
    },
    {
        name: 'paiement_expediteurs',
        path: '/admin/paiement_expediteurs/:expediteur',
        component: paiement_expediteurs,
        props: route => ({ expediteur: route.params.expediteur}),
    },
    {
        name: 'paiement_expediteur_layout',
        path: '/expediteur/paiement',
        component: paiement_expediteur_layout
    },
    {
        name: 'Retour',
        path: '/admin/Retour',
        component: Retour
    },

    {
        name: 'livraison',
        path: '/admin/livreurs',
        component: livraison
    },
    {
        name: 'livraison_livreurs',
        path: '/admin/:livreur/livraisons',
        component: livraison_livreurs,
        props: route => ({ livreur: route.params.livreur}),
    },

    {
        name: 'livraison_liv',
        path: '/livraisons',
        component: livraison_liv
    },

    {
        name: 'profile_admin',
        path: '/admin/profile',
        component: profile_admin
    },
    {
        name: 'profile_expediteur',
        path: '/expediteur/profile',
        component: profile_expediteur
    },
    {
        name: 'profile_livreur',
        path: '/livreur/profile',
        component: profile_livreur
    },
    {
        name: 'notFound',
        path: '/:pathMatch(.*)*',
        component: PageNotFound,
      },
      {
        name: 'forgotPassword',
        path: '/forgot-password',
        component: forgotPassword,
      },
      {
        path: '/reset-password/:token/:email',
        name: 'reset-password',
        component: resetPassword,
      },

];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
