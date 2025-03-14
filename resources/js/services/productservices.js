import { reactive, ref } from "vue";
import axios from "axios";
import routes from "../router/index.js";
import instance from "../api/index.js";
import { useCookie } from "@vue-composable/cookie";
export default function useProducts() {
    let enterpriseId = 1;
    try {
        enterpriseId = useCookie("userAuth")?.cookie?.value
            ? JSON.parse(useCookie("userAuth").cookie.value).data
                  .active_enterprise
            : 1;
    } catch (error) {}
    const products = ref([]);
    const productStores = ref([]);
    const inventoryProducts = ref([]);
    const product = reactive({});
    const errors = ref("");
    const getProducts = async () => {
        // catalogue(pas de qte)

        let resp = await instance.get(
            "/api/services/enterprise/" + enterpriseId
        );

        products.value = resp.data.data;
    };
    const getProduct = async () => {
        let id = null;
        try {
            const value = JSON.parse(useCookie("product").cookie.value);
            id = value;
        } catch (error) {}

        await instance.get(`/api/service/${id}`).then((resp) => {
            const resp2 = resp.data.data;
            for (const [key, value] of Object.entries(resp2)) {
                product[key] = resp2[key];
            }
        });
    };
    const getProductsStore = async (id) => {
        // const id = 1;
        await instance
            .get("/api/services/depositarticles/" + id)
            .then((resp) => {
                productStores.value = resp.data.data;
            });
    };
    const getInventoryStore = async (id) => {
        await instance
            .get(`/api/services/depositarticles/${id}`)
            .then((resp) => {
                inventoryProducts.value = resp.data.data;
            });
    };
    const inventories = ref([]);
    const getInventoryEnterprise = async () => {
        await instance
            .post("/api/services/list")
            .then((response) => {
                inventories.value = response.data.data;
            })
            .catch((error) => {});
    };
    const storeProducts = async (data, id, images) => {
        console.log("data sending data to database");
        console.log(data);
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
                .post("/api/services", data, config)
                .then(function (response) {
                    new useCookie("dataCreate").setCookie(
                        JSON.stringify({
                            service: "Le service",
                            name: data.name,
                            value: true,
                        })
                    );
                })
                .catch((error) => {});
        } else {
            let resp = await instance
                .patch("/api/services/" + `${id}`, data, config)
                .then(function (response) {
                    new useCookie("dataCreate").setCookie(
                        JSON.stringify({
                            service: "Le service",
                            name: data.name,
                            value: true,
                        })
                    );
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    };

    return {
        enterpriseId,
        products,
        product,
        errors,
        getInventoryEnterprise,
        inventories,
        getProduct,
        getProducts,
        storeProducts,
        productStores,
        getProductsStore,
        getInventoryStore,
        inventoryProducts,
    };
}
