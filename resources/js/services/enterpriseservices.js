import { ref } from "vue";
import axios from "axios";
// import routes from "../router/index.js";
// import instance from "../api/index.js";
import { useCookie } from "@vue-composable/cookie";
import { useToastr } from "../toastr.js";
// let { cookie2, setCookie2, removeCookie2 } = useCookie("enterprises");

export default function useEntreprises() {
    const toastr = useToastr();
    let { cookie, setCookie, removeCookie } = useCookie("userAuth");
    const entreprises = ref([]);
    const activeEntreprise = ref([]);

    const errors = ref("");
    const getEntreprise = async () => {
        await instance
            .get("/api/enterprises")
            .then((resp) => {
                entreprises.value = resp.data.data;
            })
            .catch((error) => {});
        // toastr.success("Message de succès");
    };
    const getDefaultMonnaie = async () => {
        await instance.get;
    };
    function activated() {
        return (
            JSON.parse(useCookie("userAuth").cookie.value).data
                .active_enterprise == undefined
        );
    }
    const storeActiveEntreprise = async (name, id, reload = true) => {
        await instance
            .post("/api/enterprise/active", {
                enterprise_id: id,
            })
            .then((resp) => {
                setCookie(JSON.stringify(resp.data));
                let delay = false;
                if (activated()) {
                    delay = true;
                }
                new useCookie("dataActive").setCookie(
                    JSON.stringify({
                        service: "L'entreprise",
                        name: name,
                        value: true,
                        delay: delay,
                    })
                );
                if (reload) location.reload();
            })
            .catch((errors) => {});
    };
    const storeEntreprise = async (data) => {
        await instance
            .post("/api/enterprises", data)
            .then((resp) => {
                new useCookie("dataCreate").setCookie(
                    JSON.stringify({
                        service: "L'entreprise",
                        name: data.get("name"),
                        value: true,
                    })
                );
                if (activated()) {
                    storeActiveEntreprise(
                        resp.data.data.name,
                        resp.data.data.id,
                        false
                    );
                }
            })
            .catch((errors) => {});
    };

    return {
        entreprises,
        errors,
        storeActiveEntreprise,
        getEntreprise,
        storeEntreprise,
    };
}
