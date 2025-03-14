import { ref } from "vue";
import axios from "axios";
import routes from "../router/index.js";
import instance from "../api/index.js";
import { useCookie } from "@vue-composable/cookie";
export default function useMoney() {
    let enterpriseId = 1;
    try {
        enterpriseId = useCookie("userAuth")?.cookie?.value
            ? JSON.parse(useCookie("userAuth").cookie.value).data
                  .active_enterprise
            : 1;
    } catch (error) {}
    const url = "/api/money";
    const money = ref([]);
    const errors = ref("");
    const getMoney = async () => {
        let resp = await instance.get(url + "/enterprise/" + enterpriseId);

        money.value = resp.data.data;
        console.log(money);
    };
    const storeMoney = async (data) => {
        // let resp = await instance.post(url, data);

        data.enterprise_id = enterpriseId;
        if (data.id == null || typeof data.id != "number") {
            let resp = await instance
                .post(url, data)
                .then((resp) => {
                    new useCookie("dataCreate").setCookie(
                        JSON.stringify({
                            service: "La monnaie",
                            name: data.label,
                            value: true,
                        })
                    );
                })
                .catch((error) => {});
        } else {
            console.log(data);
            await instance
                .patch(url + "/update/" + data.id, data)
                .then((resp) => {
                    new useCookie("dataCreate").setCookie(
                        JSON.stringify({
                            service: "La monnaie",
                            name: data.abreviation,
                            value: true,
                        })
                    );
                })
                .catch((error) => {});
        }
    };

    return {
        money,
        errors,
        getMoney,
        storeMoney,
    };
}
