import { useCookie } from "@vue-composable/cookie";
import { ref } from "vue";
import instance from "../api/index.js";
export default function useMesureUnity() {
    let enterpriseId = 1;
    try {
        enterpriseId = useCookie("userAuth")?.cookie?.value
            ? JSON.parse(useCookie("userAuth").cookie.value).data
                  .active_enterprise
            : 1;
    } catch (error) {}
    const url = "/api/unitofmeasures/";
    const mesureUnity = ref([]);
    const errors = ref("");
    const getMesureUnity = async () => {
        let resp = await instance.get(url + "enterprise/" + enterpriseId);
        mesureUnity.value = resp.data.data;
    };
    const storeMesureUnity = async (data) => {
        data.enterprise_id = enterpriseId;
        if (data.id == null || typeof data.id != "number") {
            let resp = await instance
                .post(url, data)
                .then((resp) => {
                    new useCookie("dataCreate").setCookie(
                        JSON.stringify({
                            service: "L'unite de mesure",
                            name: data.name,
                            value: true,
                        })
                    );
                })
                .catch((error) => {});
        } else {
            let resp = await instance
                .patch(url + "/" + data.id, data)
                .then((resp) => {
                    new useCookie("dataCreate").setCookie(
                        JSON.stringify({
                            service: "L'unite de mesure",
                            name: data.name,
                            value: true,
                        })
                    );
                })
                .catch((error) => {});
        }
    };

    const deleteMesureUnity = async (data) => {
        await instance.delete(url + data.id).then((resp) => {
            new useCookie("dataCreate").setCookie(
                JSON.stringify({
                    service: "La categorie",
                    name: data.name,
                    value: true,
                })
            );
        });
    };
    return {
        mesureUnity,
        errors,
        getMesureUnity,
        storeMesureUnity,
        deleteMesureUnity,
    };
}
