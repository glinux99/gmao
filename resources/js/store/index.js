// import { Vue } from "vue";
// import routers from "../router";
// import instance from "../api";
// import { createStore } from "vuex";
// import { useCookie } from "@vue-composable/cookie";
// import axios from "axios";
// let { cookie, setCookie, removeCookie } = useCookie("userAuth");
// const store = createStore({
//     state: {
//         count: 1,
//         authenticated: false,
//         user: null,
//         token: null,
//         enterprise: null,
//         logErrors: "",
//         inputError: {},
//         servicePrices: [],
//     },
//     mutations: {
//         authenticateUser(state) {
//             state.authenticated = true;
//             // state.token = data.token;
//             // state.user = data.user;
//         },
//         unauthenticateUser(state) {
//             state.authenticated = false;
//             state.token = null;
//             state.user = null;
//         },
//         enterpriseActive(state, data) {
//             state.enterprise = data.id;
//         },
//         logError(state, data, inputError) {
//             state.logErrors = data;
//             state.inputError = inputError;
//         },
//         ServicePrices(state, data) {
//             state.servicePrices.push(data);
//         },
//     },
//     actions: {
//         async redirect({ commit }, provider) {
//             removeCookie();
//             // await axios.get("sanctum/csrf-cookie");
//             // res.setHeader('Access-Control-Allow-Origin', '*');

//             await axios
//                 .get(`/api/auth/user`)
//                 .then(function (response) {
//                     if (response.data.status == false) {
//                         store.commit(
//                             "logError",
//                             response.data.message,
//                             response.data.errors
//                         );
//                     } else {
//                         setCookie(JSON.stringify(response.data));
//                         const auth = new useCookie("authenticateUser");
//                         auth.setCookie(true);
//                         const acceder = useCookie("userAuth").cookie.value;
//                         commit("authenticateUser");
//                         let redirectUrl = "/admin/home";
//                         if (response.data.stepper == true) {
//                             redirectUrl = "/admin/stepper";
//                         }
//                         location.href = redirectUrl;
//                     }
//                 })
//                 .catch(function () {
//                     store.commit(
//                         "logError",
//                         "Impossible de connecter votre compte google.",
//                         {}
//                     );
//                 });
//         },
//         async login({ commit }, credentials) {
//             removeCookie();
//             // await axios.get("/sanctum/csrf-cookie");
//             // let token = await axios.get("/token");

//             await axios
//                 .post("/auth/login", credentials)
//                 .then(function (response) {
//                     if (response.data.status == false) {
//                         store.commit(
//                             "logError",
//                             response.data.message,
//                             response.data.errors
//                         );
//                     } else {
//                         setCookie(JSON.stringify(response.data));
//                         const auth = new useCookie("authenticateUser");
//                         auth.setCookie(true);
//                         const acceder = useCookie("userAuth").cookie.value;
//                         commit("authenticateUser");
//                         let redirectUrl = "/admin/home";
//                         if (response.data.stepper == true) {
//                             redirectUrl = "/admin/stepper";
//                         }
//                         location.href = redirectUrl;
//                     }
//                 })
//                 .catch(function () {
//                     store.commit(
//                         "logError",
//                         "Email & Password does not match with our record.",
//                         {}
//                     );
//                 });
//         },

//         async singUp({ commit }, credentials) {
//             removeCookie();
//             await instance.get("sanctum/csrf-cookie");

//             await axios
//                 .post("/auth/register", credentials)
//                 .then(function (response) {
//                     if (response.data.status == false) {
//                         store.commit("logError", response.data.message, "");
//                     } else {
//                         console.log(response.data);
//                         setCookie(JSON.stringify(response.data));
//                         let redirectUrl = "";
//                         if (!response.data.stepper == true) {
//                             redirectUrl = "";
//                         } else {
//                             redirectUrl = "/admin/stepper";
//                         }
//                         location.href = redirectUrl;
//                         const auth = new useCookie("registerUser");
//                         auth.setCookie(true);
//                     }
//                 })
//                 .catch((error) => {
//                     console.error(error);
//                     store.commit(
//                         "logError",
//                         error.response.data.message,
//                         error.response.data.errors
//                     );
//                 });
//         },
//         async authUser() {
//             await axios.get("sanctum/csrf-cookie");
//             const res = await axios.get("authUser");
//             commit("authenticateUser", res.data);
//         },
//         async logout({ commit }) {
//             await axios.post("logout");

//             commit("unauthenticateUser");
//         },
//     },
//     getters: {
//         isAuthenticated(state) {
//             return state.authenticated;
//         },
//         authUser(state) {
//             return state.user;
//         },
//         userToken(state) {
//             return state.token;
//         },
//         errorInLogin(state) {
//             return state.logErrors;
//         },
//         servicePrices(state) {
//             return state.servicePrices;
//         },
//     },
//     modules: {},
// });
// export default store;
