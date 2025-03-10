import { reactive, ref } from "vue";
import axios from "axios";
import routes from "../router/index.js";
import instance from "../api/index.js";
import { useCookie } from "@vue-composable/cookie";
export default function usePointOfSales() {
    let enterpriseId = 1;
    try {
        enterpriseId = useCookie("userAuth")?.cookie?.value
            ? JSON.parse(useCookie("userAuth").cookie.value).data
                  .active_enterprise
            : 1;
    } catch (error) {}
    const pointOfSales = ref([]);
    const depositPos = ref([]);
    const agentPos = ref([]);
    const pointOfSale = reactive({
        // id: null,
        // pointOfSaleName: "",
        // adress: "",
        // phone: "",
        // photo: null,
        // type: "physique",
        // mail: "",
        // enterprise_id: 1,
    });
    const errors = ref("");
    const url = "/api/pointofsales/";
    const getPointOfSales = async () => {
        // catalogue(pas de qte)

        await instance
            .get(url + "enterprise_id/" + enterpriseId)
            .then((resp) => {
                pointOfSales.value = resp.data.data;
            });
    };
    const getPointOfSale = async () => {
        let id = null;
        try {
            const value = JSON.parse(useCookie("pos").cookie.value);
            id = value;
        } catch (error) {
            location.href = "/admin/pos";
        }
        await instance.get(url + id).then((resp) => {
            const resp2 = resp.data.data;
            for (const [key, value] of Object.entries(resp2)) {
                pointOfSale[key] = value;
            }
        });
    };
    const storeDepositPos = async (data) => {
        await instance
            .post(url + "affectdeposits/", data)
            .then(function (resp) {})
            .catch((error) => {});
    };
    const getDepositPos = async (id) => {
        await instance
            .get(url + "deposits/" + id)
            .then(function (resp) {
                depositPos.value = resp.data.data;
            })
            .catch((error) => {});
    };
    const storeAgentPos = async (data) => {
        await instance
            .post("/userspointofsale/", data)
            .then(function (response) {})
            .catch((error) => {});
    };
    const getAgentPos = async (id) => {
        await instance
            .get(url + "agents/" + id)
            .then(function (resp) {
                agentPos.value = resp.data.data;
            })
            .catch((error) => {});
    };
    const storePointOfSales = async (data) => {
        // data.set("enterprise_id", enterpriseId);
        data.enterprise_id = enterpriseId;
        const id = data.id;
        console.log(data);
        if (id == null || typeof id != "number" || id == 0 || id == {}) {
            let resp = await instance
                .post(url, data)
                .then(function (response) {})
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
        pointOfSales,
        pointOfSale,
        errors,
        getDepositPos,
        depositPos,
        getAgentPos,
        agentPos,
        storeAgentPos,
        storeDepositPos,
        getPointOfSale,
        getPointOfSales,
        storePointOfSales,
    };
}
