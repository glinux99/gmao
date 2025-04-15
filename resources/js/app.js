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
import { i18nVue } from "laravel-vue-i18n";
import { createApp } from "vue";

// import routers from "./router";
// import store from "./store/index.js";
import Aura from '@primeuix/themes/aura';

import PrimeVue from 'primevue/config';
import taskChart from "./components/charts/taskChart.vue";
import testChart from "./components/charts/testChart.vue";
import modalComponent from "./components/modals/modalComponent.vue";
import loginUser from './pages/auth/loginUser.vue';
import calendarList from "./pages/calendar/calendarList.vue";
import categoryList from "./pages/categories/categoryList.vue";
import documentList from "./pages/documents/documentList.vue";
import enginList from "./pages/engin/enginList.vue";
import entryList from "./pages/entry/entryList.vue";
import equipmentList from './pages/equipment/equipementList.vue';
import maintenanceList from './pages/maintenance/maintenanceList.vue';
import priorityList from "./pages/priority/priorityList.vue";
import projectList from './pages/project/projectList.vue';
import regionList from "./pages/region/regionList.vue";
import repportDetails from "./pages/repports/repportDetails.vue";
import repportList from "./pages/repports/repportList.vue";
import roleList from "./pages/roles/roleList.vue";
import roleView from "./pages/roles/roleView.vue";
import taskList from "./pages/task/taskList.vue";
import taskShow from "./pages/task/taskShow.vue";
import technicienList from "./pages/technicien/technicienList.vue";
import userList from "./pages/users/userList.vue";
import teamList from "./teams/teamList.vue";


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
        teamList,
        priorityList,
        modalComponent,
        taskShow,
        loginUser,
        roleView,
        categoryList,
        userList,
        entryList,
        technicienList,
        regionList,
        enginList,
        documentList,
        repportList,
        repportDetails,
    },
});
// app.component("dash-bord", require("./pages/Dashbord.vue").default);

import 'primeicons/primeicons.css';
import AutoComplete from 'primevue/autocomplete';
import Button from 'primevue/button';
import Calendar from 'primevue/calendar';
import Card from 'primevue/card';
import Checkbox from 'primevue/checkbox';
import Chips from 'primevue/chips';
import Column from 'primevue/column';
import Dialog from 'primevue/dialog';
import Dropdown from 'primevue/dropdown';
import IftaLabel from 'primevue/iftalabel';
import InputGroup from 'primevue/inputgroup';
import InputGroupAddon from 'primevue/inputgroupaddon';
import InputNumber from 'primevue/inputnumber';
import InputText from 'primevue/inputtext';
import Menu from 'primevue/menu';
import MultiSelect from 'primevue/multiselect';
import RadioButton from 'primevue/radiobutton';
import Row from 'primevue/row';
import SplitButton from 'primevue/splitbutton';
import Toast from 'primevue/toast';
import ToastService from 'primevue/toastservice';

import MeterGroup from 'primevue/metergroup';

import Tree from 'primevue/tree';


import { ConfirmDialog } from "primevue";
import Accordion from 'primevue/accordion';
import AccordionContent from 'primevue/accordioncontent';
import AccordionHeader from 'primevue/accordionheader';
import AccordionPanel from 'primevue/accordionpanel';
import Badge from "primevue/badge";
import Chart from "primevue/chart";
import ColumnGroup from 'primevue/columngroup'; // optional
import ConfirmationService from 'primevue/confirmationservice';
import DataTable from 'primevue/datatable';
import Password from "primevue/password";

import TreeTable from 'primevue/treetable';

import OrganizationChart from 'primevue/organizationchart';
import VueNumber from "vue-number-animation";
import VueHtml2pdf from 'vue3-html2pdf';
// import VueApexCharts from "vue3-apexcharts";





app.component('Dropdown', Dropdown);
app.component('MultiSelect', MultiSelect);
app.component("Calendar", Calendar);
app.component("Dialog", Dialog);
app.component('InputText', InputText);
app.component('ConfirmDialog', ConfirmDialog);
app.component('RadioButton', RadioButton);
app.component('Button', Button);
app.component('Card', Card);
app.component('MultiSelect', MultiSelect);
app.component('Chips', Chips);
app.component('AutoComplete', AutoComplete);
app.component('Checkbox', Checkbox);
app.component('Toast', Toast);
app.component('InputGroup', InputGroup);
app.component('InputGroupAddon', InputGroupAddon);
app.component('InputNumber', InputNumber);
app.component('IftaLabel', IftaLabel);
app.component('SplitButton', SplitButton);
app.component('Menu', Menu);
app.component('DataTable', DataTable);
app.component('Column', Column);
app.component('Row', Row);
app.component('ColumnGroup', ColumnGroup);
app.component('Password', Password);
app.component('Accordion', Accordion);
app.component('AccordionContent', AccordionContent);
app.component('AccordionHeader', AccordionHeader);
app.component('AccordionPanel', AccordionPanel);
app.component('Badge', Badge);
app.component('Chart', Chart);
app.component('OrganizationChart', OrganizationChart);
app.component('Tree', Tree);
app.component('TreeTable', TreeTable);
app.component('MeterGroup', MeterGroup);
app.use(VueHtml2pdf)
app.use(VueNumber);


app.use(ToastService);
app.use(ConfirmationService);
// app.use(VueApexCharts);


app.use(i18nVue, {
    shared: false,
    theme: {
        preset: Aura
    },
    onLoad: () => {
        // app.use(store);
        // app.use(excel);
        // app.use(Permissions);
        app.mount("#contentVue");
    },
    // resolve: (lang) => import(`../lang/${lang}.json`),
});
app.use(PrimeVue, {
    zIndex: {
        modal: 1057,        //dialog, drawer
        overlay: 1000,      //select, popover
        menu: 1000,         //overlay menus
        tooltip: 1100       //tooltip
    },
    theme:{
        preset: Aura,
        options:{
            prefix: 'p',
            darkModeSelector: ".data-bs-theme",

            csslayer: false
        }
    }
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
