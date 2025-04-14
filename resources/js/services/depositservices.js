import { reactive, ref } from "vue";
import axios from "axios";
import routes from "../router/index.js";
import instance from "../api/index.js";
import statics from "./statics.js";
import { useCookie } from "@vue-composable/cookie";
export default function useDeposit() {
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
    const deposits = ref([]);
    const depositUsers = ref([]);
    const deposit = reactive({});
    const servicesDeposit = ref([]);
    const errors = ref("");
    const url = "/api/deposits";
    const getDeposits = async () => {
        let resp = await instance.get(url + "/enterprise/" + enterpriseId);
        deposits.value = resp.data.data;
        console.log(enterpriseId);
    };
    const getDepositAuthUser = async () => {
        let resp = await instance.post("/api/deposit/users");
        deposits.value = resp.data.data;
    };
    const storeServiceDeposit = async (data) => {
        console.log("###############");

        console.log(data);
        await instance.post("/api/deposit/addservices/", data).then((resp) => {
            // depositUsers.value = resp.data.data;
        });
    };
    const getDeposit = async (withDefault = false, idDefault = null) => {
        let id = null;
        console.log(useCookie("store").cookie.value);
        try {
            const value = JSON.parse(useCookie("store").cookie.value);
            id = value;
        } catch (error) {
            if (withDefault) {
                id = idDefault;
            } else {
                location.href = "/admin/store";
            }
        }

        await instance.get(`${url}/${id}`).then((resp) => {
            const resp2 = resp.data.data;
            for (const [key, value] of Object.entries(resp2)) {
                deposit[key] = resp2[key];
            }
        });
    };
    const getServicesDeposit = async () => {
        let resp = await instance.get(
            url + "/services/enterprise/" + enterpriseId
        );
        servicesDeposit.value = resp.data.data;
    };
    const getUsersDeposit = async (data) => {
        await instance.post(url + "/participants", data).then((resp) => {
            depositUsers.value = resp.data.data;
        });
    };
    const storeUserDeposit = async (data, id = null, action = 0) => {
        data.enterprise_id = enterpriseId;

        if (id == null || action == 0) {
            console.log("post data");
            await instance.post("/api/depositsusers", data).then((resp) => {
                console.log(resp.data);
            });
        } else {
            if (action == 1) {
                console.log("put data");
                await instance
                    .put(`/api/depositsusers/update/${id}`, data)
                    .then((resp) => {
                        console.log(resp.data);
                    });
            } else {
                console.log("delete data");
                await instance
                    .delete(`/api/depositsusers/delete/${id}`)
                    .then((resp) => {
                        console.log(resp.data);
                    });
            }
        }
    };
    const storeDeposit = async (data) => {
        let resp = "";

        data.enterprise_id = enterpriseId;
        if (data.id == null || typeof data.id != "number" || data.id == 0) {
            resp = await instance.post(url, data).then((resp) => {
                const resp2 = resp.data.data;
                console.log(resp2);
                for (const [key, value] of Object.entries(resp2)) {
                    deposit[key] = resp2[key];
                }

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
                .patch(url + "/" + data.id, data)
                .then((resp) => {
                    new useCookie("dataCreate").setCookie(
                        JSON.stringify({
                            service: "Le depot",
                            name: data.name,
                            value: true,
                        })
                    );
                });
        }
    };
    const removeDeposit = async () => {
        let resp = await instance.delete(url + "/" + data.id);
    };
    return {
        errors,
        deposit,
        deposits,
        getDeposit,
        getDeposits,
        storeDeposit,
        depositUsers,
        removeDeposit,
        servicesDeposit,
        getUsersDeposit,
        storeUserDeposit,
        getDepositAuthUser,
        getServicesDeposit,
        storeServiceDeposit,
    };
}
