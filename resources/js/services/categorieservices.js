import { ref } from "vue";
import axios from "axios";
import routes from "../router/index.js";
import instance from "../api/index.js";
import { useCookie } from "@vue-composable/cookie";
export default function useCategories() {
    let enterpriseId = 1;
    try {
        enterpriseId = useCookie("userAuth")?.cookie?.value
            ? JSON.parse(useCookie("userAuth").cookie.value).data
                  .active_enterprise
            : 1;
    } catch (error) {}
    const categories = ref([]);
    const categoriesListString = ref("");
    const errors = ref("");
    const url = "/api/categoriesServices/";
    const getCategories = async () => {
        let resp = await instance.get(url + "enterprise/" + enterpriseId);

        categories.value = resp.data.data;
        categoriesListString.value = "";
        resp.data.data.forEach((element) => {
            categoriesListString.value =
                categoriesListString.value + "," + element.name;
        });
    };
    const storeCategories = async (data) => {
        data.enterprise_id = enterpriseId;
        if (data.id == null) {
            let resp = await instance
                .post(url, data)
                .then((resp) => {
                    new useCookie("dataCreate").setCookie(
                        JSON.stringify({
                            service: "La categorie",
                            name: data.name,
                            value: true,
                        })
                    );
                })
                .catch((error) => {});
        } else {
            let resp = await instance.put(url + data.id, data).then((resp) => {
                new useCookie("dataCreate").setCookie(
                    JSON.stringify({
                        service: "La categorie",
                        name: data.name,
                        value: true,
                    })
                );
            });
        }
    };
    const deleteCategories = async (data) => {
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
        categories,
        categoriesListString,
        errors,
        getCategories,
        storeCategories,
        deleteCategories,
    };
}
