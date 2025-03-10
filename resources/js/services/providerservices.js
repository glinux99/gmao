import { reactive, ref } from "vue";
import axios from "axios";
import routes from "../router/index.js";
import instance from "../api/index.js";
import { useCookie } from "@vue-composable/cookie";
export default function useProviders() {
    let enterpriseId = 1;
    try {
        enterpriseId = useCookie("userAuth")?.cookie?.value
            ? JSON.parse(useCookie("userAuth").cookie.value).data
                  .active_enterprise
            : 1;
    } catch (error) {}
    const providers = ref([]);
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
    const url = "/api/providers/";
    const getProviders = async () => {
        // catalogue(pas de qte)

        let resp = await instance.get(url + "enterprise/" + enterpriseId);

        providers.value = resp.data.data;
    };
    const storeProviders = async (data = null, id = null, images = []) => {
        // data.set("enterprise_id", enterpriseId);
        data.enterprise_id = enterpriseId;

        let formData = new FormData();
        for (const [key, value] of Object.entries(data)) {
            if (key == "pricing") {
                formData.append(`${key}`, JSON.stringify(value));
            } else formData.append(`${key}`, value);
        }
        images.value.forEach((e, i) => {
            formData.append(`${i}`, e);
        });
        let config = undefined;
        if (images.value.length > 0) {
            config = {
                headers: { "Content-Type": "multipart/form-data" },
            };
            data = formData;
        }
        if (id == null || typeof id != "number") {
            let resp = await instance
                .post(url, data, config)
                .then(function (response) {
                    const resp = response.data.data;
                    for (const [key, value] of Object.entries(resp)) {
                        provider[key] = resp[key];
                    }
                })
                .catch((error) => {});
        } else {
            let resp = await instance
                .patch("/api/providers/update/" + `${id}`, data, config)
                .then(function (response) {})
                .catch(function (error) {});
        }
    };

    return {
        enterpriseId,
        providers,
        provider,
        errors,
        getProviders,
        storeProviders,
    };
}
