// /**
//  * First we will load all of this project's JavaScript dependencies which
//  * includes Vue and other libraries. It is a great starting point when
//  * building robust, powerful web applications using Vue and Laravel.
//  */

// require("./bootstrap");

// window.Vue = require("vue").default;

// /**
//  * The following block of code may be used to automatically register your
//  * Vue components. It will recursively scan this directory for the Vue
//  * components and automatically register them with their "basename".
//  *
//  * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
//  */

// // const files = require.context('./', true, /\.vue$/i)
// // files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component(
//     "example-component",
//     require("./components/ExampleComponent.vue").default
// );

// /**
//  * Next, we will create a fresh Vue application instance and attach it to
//  * the page. Then, you may begin adding components to this application
//  * or customize the JavaScript scaffolding to fit your unique needs.
//  */

// const app = new Vue({
//     el: "#content",
// });

// require("./bootstrap");
import { createApp } from "vue";
import { i18nVue } from "laravel-vue-i18n";
// import routers from "./router";
// import store from "./store/index.js";
import modalComponent from "./components/modals/modalComponent.vue";
// import initEntreprise from "./pages/entreprises/initEntreprise.vue";
// import enterpriseComponent from "./pages/entreprises/enterpriseComponent.vue";
// import dashBoard from "./pages/dashBoard.vue";
// import userList from "./pages/users/userList.vue";
// import userDetails from "./pages/users/userDetails.vue";
// import userAgentActivity from "./pages/users/userAgentActivity.vue";
// import userAgentApiKeyLog from "./pages/users/userAgentApiKeyLog.vue";
// import userAgentDeclaration from "./pages/users/userAgentDeclaration.vue";
// import userAgentFacture from "./pages/users/userAgentSecurity.vue";
// import userAgentSecurity from "./pages/users/userAgentSecurity.vue";
// import userAgentSetting from "./pages/users/userAgentSetting.vue";
// import userDetailsAgent from "./pages/users/userDetailsAgent.vue";
import roleList from "./pages/roles/roleList.vue";
import addRole from "./pages/roles/addRole.vue";
import roleView from "./pages/roles/roleView.vue";
import taskList from "./pages/task/taskList.vue";
import projectList from './pages/project/projectList.vue';
import equipmentList from './pages/equipment/equipementList.vue';
import calendarList from "./pages/calendar/calendarList.vue";
import maintenanceList from './pages/maintenance/maintenanceList.vue';
import testChart from "./components/charts/testChart.vue";
import taskChart from  "./components/charts/taskChart.vue";


import Accordion from 'primevue/accordion';
import AccordionPanel from 'primevue/accordionpanel';
import AccordionHeader from 'primevue/accordionheader';
import AccordionContent from 'primevue/accordioncontent';
// import loginUser from "./pages/auth/loginUser.vue";
// import signUp from "./pages/auth/signUp.vue";
// import storeList from "./pages/stores/storeList.vue";
// import posList from "./pages/pointOfSale/posList.vue";
// import productStore from "./pages/products/productStore.vue";
// import productDetails from "./pages/products/productDetails.vue";
// import catalogueService from "./pages/products/catalogueService.vue";
// import productList from "./pages/products/productList.vue";
// import categoryAdd from "./pages/categories/categoryAdd.vue";
// import categoryList from "./pages/categories/categoryList.vue";
// import mesureUnityAdd from "./pages/mesureUnity/mesureUnityAdd.vue";
// import enterpriseAdd from "./pages/entreprises/enterpriseAdd.vue";
// import enterpriseList from "./pages/entreprises/enterpriseList.vue";
// import enterpriseCount from "./pages/entreprises/enterpriseCount.vue";
// import priceAdd from "./pages/prices/priceAdd.vue";
// import ficheStock from "./pages/stocks/ficheStock.vue";
// import valoryStock from "./pages/stocks/valoryStock.vue";
// import approvisionnementStock from "./pages/stocks/approvisionnementStock.vue";
// import stockTableComponent from "./pages/stocks/stockTableComponent.vue";
// import destockageStock from "./pages/stocks/destockageStock.vue";
// // import posList from "./pages/pos/posList.vue";
// import exportPdf from "./pages/pos/exportPdf.vue";
// import logoComponent from "./components/logo/logoComponent.vue";
// import logoLgComponent from "./components/logo/logoLgComponent.vue";
// import inventoryRepport from "./pages/stocks/inventoryRepport.vue";
// import moneyList from "./pages/moneys/moneyList.vue";
// import moneyEntry from "./pages/moneys/moneyEntry.vue";
// import moneyDefault from "./pages/moneys/moneyDefault.vue";
// import moneyOut from "./pages/moneys/moneyOut.vue";
// import moneyAccount from "./pages/moneys/moneyAccount.vue";
// import redirectApp from "./pages/redirect/redirectApp.vue";
// import cardTemplate from "./pages/stocks/cardTemplate.vue";
// import storeView from "./pages/stores/storeView.vue";
// import posView from "./pages/pointOfSale/posView.vue";
// import excel from "vue-excel-export";
// import customerList from "./pages/customers/customerList.vue";
// import providerList from "./pages/providers/providerList.vue";
// import navLinkComponent from "./components/navLinkComponent.vue";
// import facturationList from "./pages/facturation/facturationList.vue";
// import inventoryEnterprise from "./pages/inventory/inventoryEnterprise.vue";
// import storeDefault from "./pages/stores/storeDefault.vue";
// const app = createApp(App);
// app.use(routers);
// app.mount("#contentVue");
// Vue.prototype.$userAuth = document.querySelector("meta[name='user_auth']").getAttribute('content');

// Vue.config.productionTip = false;
import Permissions from "./mixins/Permissions.vue";
import PrimeVue from 'primevue/config';
const app = createApp({
    components: {
        // dashBoard,
        // userList,
        taskList,
        roleList,
        projectList,
        equipmentList,
        calendarList,
        maintenanceList,
        testChart,
        taskChart,
        // initEntreprise,
        // enterpriseComponent,
        // loginUser,
        // signUp,
        // storeList,
        // // posList,
        modalComponent,
        // productStore,
        // productDetails,
        // catalogueService,
        // categoryAdd,
        // categoryList,
        // productList,
        // mesureUnityAdd,
        // enterpriseAdd,
        // enterpriseList,
        // enterpriseCount,
        // priceAdd,
        // ficheStock,
        // posList,
        // valoryStock,
        // exportPdf,
        // approvisionnementStock,
        // inventoryRepport,
        // destockageStock,
        // logoComponent,
        // logoLgComponent,
        // moneyList,
        // userDetails,
        addRole,
        roleView,
        // userDetailsAgent,
        // userAgentSetting,
        // userAgentApiKeyLog,
        // userAgentDeclaration,
        // userAgentFacture,
        // userAgentSecurity,
        // userAgentActivity,
        // redirectApp,
        // stockTableComponent,
        // cardTemplate,
        // storeView,
        // posView,
        // navLinkComponent,
        // moneyEntry,
        // moneyOut,
        // moneyAccount,
        // customerList,
        // providerList,
        // moneyDefault,
        // facturationList,
        // inventoryEnterprise,
        // storeDefault,
    },
});
import Aura from '@primeuix/themes/aura';
import MaintenanceList from "./pages/maintenance/maintenanceList.vue";
// app.component("dash-bord", require("./pages/Dashbord.vue").default);
app.use(PrimeVue);
app.component('Accordion', Accordion);
app.component('AccordionPanel', AccordionPanel);
app.component('AccordionHeader', AccordionHeader);
app.component('AccordionContent', AccordionContent);
app.use(i18nVue, {
    shared: false,
    theme: {
        preset: Aura
    },
    onLoad: () => {
        // app.use(store);
        // app.use(excel);
        app.use(Permissions);
        app.mount("#contentVue");
    },
    resolve: (lang) => import(`../lang/${lang}.json`),
});

// app.config.globalProperties.$store = store;
// import * as Vue from "vue";
// import App from "./App.vue";
// import router from "./router";
// import store from "./store";

// Vue.config.productionTip = false;

// new Vue({
//     router,
//     store,
//     render: (h) => h(App),
// }).$mount("#app");
