// import { createRouter, createWebHistory } from "vue-router";
// // import Dashbord from "../pages/dashBord.vue";
// import Users from "../pages/users/users.vue";
// import User from "../pages/users/user.vue";
// import Roles from "../pages/roles/roles.vue";
// import Role from "../pages/roles/role.vue";
// import Permissions from "../pages/permissions/permissions.vue";
// import Permission from "../pages/permissions/permission.vue";
// import Produits from "../pages/products/produits.vue";
// import Produit from "../pages/products/produit.vue";
// import Stepper from "../pages/entreprises/initEntreprise.vue";
// import Login from "../pages/auth/login.vue";
// import Pos from "../pages/pos/pos.vue";
// import axios from "../api/index.js";

// const routes = [
//     // {
//     //     path: "/admin/stepper",
//     //     name: "stepper",
//     //     component: Stepper,
//     // },
//     {
//         path: "/admin/home",
//         name: "admin.home",
//         component: Dashbord,
//     },
//     {
//         path: "/admin/users",
//         name: "users",
//         component: Users,
//     },
//     {
//         path: "/admin/user",
//         name: "user",
//         component: User,
//     },
//     {
//         path: "/admin/roles",
//         name: "roles",
//         component: Roles,
//     },
//     {
//         path: "/admin/role",
//         name: "role",
//         component: Role,
//     },
//     {
//         path: "/admin/permissions",
//         name: "permissions",
//         component: Permissions,
//     },
//     {
//         path: "/admin/permission",
//         name: "permission",
//         component: Permission,
//     },
//     {
//         path: "/admin/produits",
//         name: "produits",
//         component: Produits,
//     },
//     ,
//     {
//         path: "/admin/produit",
//         name: "produit",
//         component: Produit,
//     },
//     {
//         path: "/admin/login",
//         name: "login",
//         component: Login,
//     },
// ];

// const routers = createRouter({
//     history: createWebHistory(),
//     routes,
// });
// routers.beforeEach(async (to, from, next) => {
//     // to.matched.some((record) => record.meta.requiresAuth)
//     if (true) {
//         if (store.getters.isAuthenticated) {
//             // next({
//             //     path: "/admin/login",
//             //     redirect: to.fullPath,
//             // });
//             next();
//         } else {
//             let res = axios.get("api/stepper");

//             if (!res.data.data) {

//                 next();
//             } else {
//                 next({
//                     path: "/admin/stepper",
//                     redirect: to.fullPath,
//                 });
//             }
//         }
//     }
// });
// export default routers;
// // GOOD
// // routes.beforeEach((to, from, next) => {
// //     if (to.name !== 'Login' && !isAuthenticated) next({ name: 'Login' })
// //     else next()
// //   })
