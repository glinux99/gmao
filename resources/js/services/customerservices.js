import { reactive, ref } from "vue";
import axios from "axios";
import routes from "../router/index.js";
import instance from "../api/index.js";
import statics from "./statics.js";
import { useCookie } from "@vue-composable/cookie";
export default function useCustomer() {
    console.log(useCookie("userAuth")?.cookie?.value);
    console.log(useCookie("userAuth").cookie.value);
    console.log("xxxxxxxxxxxx");
    let enterpriseId = 1;
    try {
        enterpriseId = useCookie("userAuth")?.cookie?.value
            ? JSON.parse(useCookie("userAuth").cookie.value).data
                  .active_enterprise
            : 1;
    } catch (error) {}
    const customers = ref([]);
    const customerUsers = ref([]);
    const customer = reactive({});
    const servicesCustomer = ref([]);
    const errors = ref("");
    const url = "/api/customers";
    const getCustomers = async () => {
        console.log("xxxxxxxxxssx");
        let resp = await instance.get(url + "/enterprise/" + enterpriseId);
        customers.value = resp.data.data;
        console.log(resp.data.data);
    };

    const getCustomerAuthUser = async () => {
        let resp = await instance.post("/api/customer/users");
        customers.value = resp.data.data;
    };
    const storeServiceCustomer = async (data) => {
        console.log("###############");

        console.log(data);
        await instance.post("/api/customer/addservices/", data).then((resp) => {
            // customerUsers.value = resp.data.data;
        });
    };
    // const getCustomer = async () => {
    //     let id = null;
    //     console.log(useCookie("store").cookie.value);
    //     try {
    //         const value = JSON.parse(useCookie("store").cookie.value);
    //         id = value;
    //     } catch (error) {
    //         location.href = "/admin/store";
    //     }

    //     await instance.get(`${url}/${id}`).then((resp) => {
    //         const resp2 = resp.data.data;
    //         for (const [key, value] of Object.entries(resp2)) {
    //             customer[key] = resp2[key];
    //         }
    //     });
    // };
    const getServicesCustomer = async () => {
        let resp = await instance.get(
            url + "/services/enterprise/" + enterpriseId
        );
        servicesCustomer.value = resp.data.data;
    };
    const getUsersCustomer = async (data) => {
        await instance.post(url + "/participants", data).then((resp) => {
            customerUsers.value = resp.data.data;
        });
    };
    const storeUserCustomer = async (data, id = null, action = 0) => {
        data.enterprise_id = enterpriseId;

        if (id == null || action == 0) {
            console.log("post data");
            await instance.post("/api/customersusers", data).then((resp) => {
                console.log(resp.data);
            });
        } else {
            if (action == 1) {
                console.log("put data");
                await instance
                    .put(`/api/customersusers/update/${id}`, data)
                    .then((resp) => {
                        console.log(resp.data);
                    });
            } else {
                console.log("delete data");
                await instance
                    .delete(`/api/customersusers/delete/${id}`)
                    .then((resp) => {
                        console.log(resp.data);
                    });
            }
        }
    };
    const storeCustomer = async (data) => {
        let resp = "";

        data.enterprise_id = enterpriseId;
        if (data.id == null || typeof data.id != "number" || data.id == 0) {
            resp = await instance.post(url, data).then((resp) => {
                // const resp2 = resp.data.data;
                // console.log(resp2);
                // for (const [key, value] of Object.entries(resp2)) {
                //     customer[key] = resp2[key];
                // }
                // new useCookie("dataCreate").setCookie(
                //     JSON.stringify({
                //         service: "Le depot",
                //         name: data.name,
                //         value: true,
                //     })
                // );
            });
        } else {
            console.log(data.id);
            console.log(data);
            resp = await instance
                .patch(url + "/update/" + data.id, data)
                .then((resp) => {
                    new useCookie("dataCreate").setCookie(
                        JSON.stringify({
                            service: "L'utilisateur",
                            name: data.customerName,
                            value: true,
                        })
                    );
                });
        }
    };
    const removeCustomer = async () => {
        let resp = await instance.delete(url + "/" + data.id);
    };
    return {
        errors,
        customer,
        customers,
        // getCustomer,
        getCustomers,
        storeCustomer,
        customerUsers,
        removeCustomer,
        servicesCustomer,
        getUsersCustomer,
        storeUserCustomer,
        getCustomerAuthUser,
        getServicesCustomer,
        storeServiceCustomer,
    };
}
