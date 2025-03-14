import { ref } from "vue";
import axios from "axios";
import routes from "../router/index.js";
import instance from "../api/index.js";
import statics from "./statics.js";
import { useCookie } from "@vue-composable/cookie";
export default function useStock() {
    let enterpriseId = 1;
    try {
        enterpriseId = useCookie("userAuth")?.cookie?.value
            ? JSON.parse(useCookie("userAuth").cookie.value).data
                  .active_enterprise
            : 1;
    } catch (error) {}
    const stockServices = ref([]);
    const errors = ref("");
    const url = "/api/stockhistory";
    const getStock = async () => {
        let resp = await instance.get(url + "/enterprise/" + enterpriseId);

        stockServices.value = resp.data.data;
    };
    const storeStock = async (data) => {
        let resp = "";

        data.enterprise_id = enterpriseId;
        if (data.id == null) {
            resp = await instance.post(url, data);
        } else {
            resp = await instance.patch(url + "/" + data.id, data);
        }

        // stockServices.value += resp.data.data;

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
    const removeStock = async () => {
        let resp = await instance.delete(url + "/" + data.id);
    };
    return {
        stockServices,
        errors,
        getStock,
        storeStock,
        removeStock,
    };
}
