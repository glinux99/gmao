import { ref } from "vue";

import { useCookie } from "@vue-composable/cookie";
import instance from "../api/index.js";
export default function useStock() {
    let enterpriseId = 1;
    try {
        enterpriseId = useCookie("userAuth")?.cookie?.value
            ? JSON.parse(useCookie("userAuth").cookie.value).data
                  .active_enterprise
            : 1;
    } catch (error) {}
    const stockServices = ref([]);
    const ficheStock = ref([]);
    const errors = ref("");
    const url = "/api/stockhistory";
    const getStock = async () => {
        let resp = await instance.get(url + "/enterprise/" + enterpriseId);

        stockServices.value = resp.data.data;
    };
    const getStockHistoryUser = async (data) => {
        await instance.post(url + "/byuser", data).then((resp) => {
            ficheStock.value = resp.data.data;
            console.log(resp.data.data);
        });
    };
    const getStockHistoryDeposit = async (data) => {
        await instance
            .post(url + "/fordeposit", {
                deposit_id: data,
            })
            .then((resp) => {
                ficheStock.value = resp.data.data;
                console.log(resp.data.data);
            });
    };
    const storeStock = async (data) => {
        let resp = "";

        data.enterprise_id = enterpriseId;
        if (data.id == null) {
            await instance
                .post(url, { data: data._rawValue })
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

        // stockServices.value += resp.data.data;

        // await routes.push({ name: "admin.home" });0
        // try {
        //     let resp = await instance.post('/api/entreprises', data);
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
        errors,
        getStock,
        ficheStock,
        storeStock,
        removeStock,
        stockServices,
        getStockHistoryUser,
        getStockHistoryDeposit,
    };
}
