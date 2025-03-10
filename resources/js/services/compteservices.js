import { reactive, ref } from "vue";
import axios from "axios";
import routes from "../router/index.js";
import instance from "../api/index.js";
import { useCookie } from "@vue-composable/cookie";
export default function useAccounts() {
    let enterpriseId = 1;
    try {
        enterpriseId = useCookie("userAuth")?.cookie?.value
            ? JSON.parse(useCookie("userAuth").cookie.value).data
                  .active_enterprise
            : 1;
    } catch (error) {}
    const accounts = ref([]);
    const provider = reactive({
        // id: null,
        // providerName: "",
        // adress: "",
        // phone: "",
        // photo: null,
        // type: "physique",
        // mail: "",
        // enterprise_id: 1,
    });
    const errors = ref("");
    const url = "/api/accounts/";
    const getAccounts = async () => {
        // catalogue(pas de qte)

        await instance.get(url + "enterprise/" + enterpriseId).then((resp) => {
            accounts.value = resp.data.data;
        });
    };
    const storeAccounts = async (data) => {
        // data.set("enterprise_id", enterpriseId);
        data.enterprise_id = enterpriseId;
        const id = data.id;
        console.log(data);
        if (id == null || typeof id != "number" || id == 0 || id == {}) {
            let resp = await instance
                .post(url, data)
                .then(function (response) {
                    const resp = response.data.data;
                    for (const [key, value] of Object.entries(resp)) {
                        provider[key] = resp[key];
                    }
                })
                .catch((error) => {});
        } else {
            await instance
                .patch(url + `update/${id}`, data)
                .then(function (response) {})
                .catch(function (error) {});
        }
    };

    return {
        enterpriseId,
        accounts,
        provider,
        errors,
        getAccounts,
        storeAccounts,
    };
}
