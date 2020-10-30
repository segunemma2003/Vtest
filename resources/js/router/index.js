import Vue from 'vue';

import VueRouter from 'vue-router';


Vue.use(VueRouter);

import Dashboard from '../pages/Dashboard';
import Account from '../pages/Account';



const routes =[
    {
        component:Dashboard,
        name:"dashboard",
        path: "/dashboard",
        
    },
    {
        component:Account,
        name:"account",
        path: "/account",
       
    },
    {
        component:Dashboard,
        name:"transfer",
        path: "/transfer",
        
    },
];


export default new VueRouter({
    routes:routes
});