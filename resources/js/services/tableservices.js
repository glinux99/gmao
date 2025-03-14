import { ref } from "vue";
import axios from "axios";
import routes from "../router/index.js";
import instance from "../api/index.js";
import statics from "./statics.js";
import { useCookie } from "@vue-composable/cookie";
export default function useTable() {
    let enterpriseId = 1;
    try {
        enterpriseId = useCookie("userAuth")?.cookie?.value
            ? JSON.parse(useCookie("userAuth").cookie.value).data
                  .active_enterprise
            : 1;
    } catch (error) {}
    const tables = ref([]);
    const ficheTable = ref([]);
    const errors = ref("");
    const url = "/api/tables";
    const getTable = async () => {
        let resp = await instance.get(url + "/enterprise/" + enterpriseId);

        tables.value = resp.data.data;
    };
    // const getTableHistoryUser = async (data) => {
    //     await instance.post(url + "/byuser", data).then((resp) => {
    //         ficheTable.value = resp.data.data;
    //         console.log(resp.data.data);
    //     });
    // };
    // const getTableHistoryDeposit = async (data) => {
    //     await instance
    //         .post(url + "/fordeposit", {
    //             deposit_id: data,
    //         })
    //         .then((resp) => {
    //             ficheTable.value = resp.data.data;
    //             console.log(resp.data.data);
    //         });
    // };
    const storeTable = async (data) => {
        let resp = "";

        data.enterprise_id = enterpriseId;
        if (data.id == null) {
            await instance
                .post(url, data)
                .then((resp) => {
                    console.log("response", resp.data);
                })
                .catch((error) => {
                    console.log("ERRRRRRRRRRRRRRRRRO");
                    console.log(data);
                    console.log("ERRRRRRRRRRRRRRRRRO");
                    console.log(error);
                });
        } else {
            await instance.patch(url + "/" + data.id, data).then((resp) => {
                console.log("response", resp);
            });
        }

        // tables.value += resp.data.data;

        // await routes.push({ name: "admin.home" });0
        // try {
        //     let resp = await axios.post('/api/entreprises', data);
        //     // entreprises.value = resp.data.data;

        //     // routes.push({ name: "admin.home" });
        // } catch (error) {
        //    const  storeEntrepriseErrors = error.response.data.errors;
        // for( const key in storeEntrepriseErrors){
        //     errors.value +=storeEntrepriseErrors[key][0]+ ' ';
        // }

        // }
    };
    const removeTable = async () => {
        let resp = await instance.delete(url + "/" + data.id);
    };
    return {
        errors,
        getTable,
        ficheTable,
        storeTable,
        removeTable,
        tables,
    };
}
