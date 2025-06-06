import { ref } from "vue";
// import instance from "../api/index.js";
import { useCookie } from "@vue-composable/cookie";
import instance from "../api/index";
export default function useRoles() {
    let enterpriseId = 1;
    try {
        enterpriseId = useCookie("userAuth")?.cookie?.value
            ? JSON.parse(useCookie("userAuth").cookie.value).data
                  .active_enterprise
            : 1;
    } catch (error) {}
    const roles = ref([]);
    const role = ref({});
    const permissions = ref([]);
    const url = "/api/roles";
    const getRoles = async () => {
        let resp = await instance.get("/api/roles");
        roles.value = resp.data.data;
    };
    const getRole = async () => {
        let id = useCookie("role").cookie.value;

        let resp = await instance.get(`/api/roles/${id}`);

        role.value = resp.data.data;
    };
    const getRolesPermissions = async () => {
        let resp = await instance.get("/api/rolesPermissions");
        roles.value = resp.data.data;
    };
    // to get Permissions
    const getPermissions = async () => {
        let resp = await instance.get("/api/permissions");
        permissions.value = resp.data.data;
    };
    const storeRoles = async (data) => {
        if (data.id == null || typeof data.id != "number") {
            let resp = await instance
                .post(url, data)
                .then((resp) => {
                    useCookie("dataCreate").setCookie(
                        JSON.stringify({
                            service: "Le role",
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
                            service: "Le role",
                            name: data.name,
                            value: true,
                        })
                    );
                })
                .catch((error) => {});
        }
    };
    return {
        role,
        roles,
        getRole,
        getRoles,
        storeRoles,
        permissions,
        getPermissions,
        getRolesPermissions,
    };
}
