import axios from "axios";
// import store from "../store/index";
import { useCookie } from "@vue-composable/cookie";
// import useUsers from "../services/userservices";

const instance = axios.create({
    baseURL: process.env.BASE_URL,
    withCredentials: true,
});

let acceder = useCookie("userAuth").cookie.value
    ? JSON.parse(useCookie("userAuth").cookie.value)
    : {
          token: "",
      };

instance.interceptors.request.use(
    async (config) => {
        if (true) {
            if (acceder.token) {
                config.headers.Authorization = `Bearer ${acceder.token}`;
            }
        }

        if (
            !config.headers.hasOwnProperty("Authorization") &&
            location.href != "register" &&
            location.href != "login"
        ) {
            try {
                const element = document.getElementById("logOut");
                element.click();
            } catch (error) {}
        }
        console.log(config.headers["Authorization"]);

        return config;
    },
    (error) => {
        Promise.reject(error);
    }
);

export default instance;
