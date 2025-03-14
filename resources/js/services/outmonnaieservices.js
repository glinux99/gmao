import { reactive, ref } from "vue";
import axios from "axios";
import routes from "../router/index.js";
import instance from "../api/index.js";
import { useCookie } from "@vue-composable/cookie";
export default function useExpenditures() {
    let enterpriseId = 1;
    try {
        enterpriseId = useCookie("userAuth")?.cookie?.value
            ? JSON.parse(useCookie("userAuth").cookie.value).data
                  .active_enterprise
            : 1;
    } catch (error) {}
    const expenditures = ref([]);
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
    const url = "/api/expenditures/";
    const getExpenditures = async () => {
        // catalogue(pas de qte)

        await instance.get(url + "enterprise/" + enterpriseId).then((resp) => {
            expenditures.value = resp.data.data;
        });
    };
    const storeExpenditures = async (data) => {
        const id = data.id;
        // data.set("enterprise_id", enterpriseId);
        console.log("############XX##########");
        console.log(data);
        data.enterprise_id = enterpriseId;
        if (id == null || typeof id != "number" || id == 0) {
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
                .then(function (response) {
                    console.log(data);
                    console.log("update running ok");
                    console.log(response.data);
                    console.log(url + `update/${id}`);
                })
                .catch(function (error) {});
        }
    };

    return {
        enterpriseId,
        expenditures,
        provider,
        errors,
        getExpenditures,
        storeExpenditures,
    };
}
