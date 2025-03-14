import { ref } from "vue";
import axios from "axios";
import routes from "../router/index.js";
import instance from "../api/index.js";
import { useCookie } from "@vue-composable/cookie";
export default function useInvoice() {
    let enterpriseId = 1;
    try {
        enterpriseId = useCookie("userAuth")?.cookie?.value
            ? JSON.parse(useCookie("userAuth").cookie.value).data
                  .active_enterprise
            : 1;
    } catch (error) {}
    const url = "/api/invoices";
    const invoices = ref([]);
    const errors = ref("");
    const getInvoice = async () => {
        let resp = await instance.get(url + "/enterprise/" + enterpriseId);

        invoices.value = resp.data.data;
    };
    const storeInvoice = async (data) => {
        data.enterprise_id = enterpriseId;

        await instance
            .post(url, data)
            .then((resp) => {
                invoices.value = resp.data.data;
            })
            .catch((errors) => {});
    };

    return {
        invoices,
        errors,
        getInvoice,
        storeInvoice,
    };
}
