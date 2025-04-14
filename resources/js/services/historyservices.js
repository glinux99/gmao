import { useCookie } from "@vue-composable/cookie";
import { reactive, ref } from "vue";
export default function useHistoryWebServices() {
    const hostCookie = useCookie("histories");
    const storeHistory = () => {
        hostCookie.setCookie(
            JSON.stringify({
                name: location.href.replace(location.origin, ""),
                host: location.origin,
            })
        );
    };
    const linkHistory = reactive({
        name: "",
        host: "",
        title: "",
        active: true,
    });
    const getHistory = () => {
        try {
            linkHistory.name = `${JSON.parse(
                hostCookie.cookie.value
            ).name.replace("/admin/", "")}`;
            linkHistory.host = `${JSON.parse(hostCookie.cookie.value).host}${
                JSON.parse(hostCookie.cookie.value).name
            }`;
            linkHistory.title = location.href
                .replace(location.origin, "")
                .replace("/admin/", "");
            linkHistory.active = true;
            if (linkHistory.host == location.href) {
                linkHistory.name = "Dashboard";
                linkHistory.host = "/admin/home";
            }
            if (
                linkHistory.title == "home" &&
                location.href
                    .replace(location.origin, "")
                    .replace("/admin/", "") == "home"
            ) {
                linkHistory.active = false;
            }
        } catch (error) {}
        storeHistory();
    };
    return {
        storeHistory,
        getHistory,
        linkHistory,
    };
}
