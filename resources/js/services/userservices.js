import { useCookie } from "@vue-composable/cookie";
import { reactive, ref } from "vue";
// import axios from "../api/index.js";
import axios from "axios";
export default function useUsers() {
    // let { cookie, setCookie, removeCookie } = useCookie("userAuth");
    let enterpriseId = 1;
    let user_id = 1;
    const users = ref([]);
    const url = "/api/users/";
    const user = ref({});
    // const totalAccounts = ref(0);
    // const defaultMonnaie = reactive({});
    // const totalCash = ref(0);
    // const totalCredits = ref(0);
    // const totalEntries = ref(0);
    // const totalExpenditures = ref(0);
    // const totalDebts = ref(0);
    // const totalFences = ref(0);
    // const cash = ref(0);
    // const credits = ref(0);
    // const expenditures = ref([]);
    // const entries = ref([]);
    // const fences = ref([]);
    // const debts = ref([]);
    // const accounts = ref([]);
    // const localizationUser = ref([]);
    // const getLocalizationUser = async () => {
    //     axios.get("/api/user/localization").then((resp) => {
    //         localizationUser.value = resp.data.data;
    //     });
    // };
    const getUsers = async () => {
        let resp = await axios.get(`${url}`);
        users.value = resp.data;
    };
    // const getUser = async () => {
    //     let id = useCookie("user").cookie.value;

    //     let resp = await axios.get(`${url}${id}`);

    //     user.value = resp.data.data;
    // };
    // const getAuthUser = async () => {
    //     await axios.get("/api/auth/user").then((resp) => {
    //         console.log(resp.data);
    //     });
    // };
    // const storeUser = async (data, id) => {
    //     let resp = "";

    //     data.enterprise_id = enterpriseId;
    //     if (id == null || typeof id != "number" || id == 0) {
    //         resp = await axios.post(url, data).then((resp) => {
    //             new useCookie("dataCreate").setCookie(
    //                 JSON.stringify({
    //                     service: "L'utilisateur",
    //                     name: data.name,
    //                     value: true,
    //                 })
    //             );
    //         });
    //     } else {
    //         console.log("modif");
    //         console.log(data);
    //         resp = await axios
    //             .patch(url + id, data)
    //             .then(function (response) {
    //                 if (response.data.status == false) {
    //                     // store.commit(
    //                     //     "logError",
    //                     //     response.data.message,
    //                     //     response.data.errors
    //                     // );
    //                 } else {
    //                     if (
    //                         JSON.parse(useCookie("userAuth").cookie.value).data
    //                             .id == id
    //                     ) {
    //                         setCookie(JSON.stringify(response.data));
    //                         const auth = new useCookie("authenticateUser");
    //                         auth.setCookie(true);
    //                         const acceder = useCookie("userAuth").cookie.value;
    //                         // commit("authenticateUser");
    //                     }
    //                     console.log(response.data);
    //                 }
    //             })
    //             .catch(function (error) {
    //                 console.error(error.message);
    //                 // store.commit(
    //                 //     "logError",
    //                 //     "Email & Password does not match with our record.",
    //                 //     {}
    //                 // );
    //             });
    //     }
    // };
    // const logOutUserAll = async () => {
    //     await axios.get("/api/user/logout-all").then((resp) => {
    //         location.href = "/";
    //     });
    // };
    return {
        users,
        // getUser,
        getUsers,

    };
}
