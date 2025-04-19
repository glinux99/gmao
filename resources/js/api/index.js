import { useCookie } from "@vue-composable/cookie";
import axios from "axios";

const instance = axios.create({
    baseURL: import.meta.env.APP_URL,
    withCredentials: true,
});

//Get the cookie value for userAuth
let userAuthCookie = useCookie("userAuth");

// Get the initial token from the cookie (if it exists)
let userToken = userAuthCookie.cookie.value
    ? JSON.parse(userAuthCookie.cookie.value).token
    : null;
// Interceptor to add the token to each request
instance.interceptors.request.use(
    async (config) => {
        // Check if a user token exists
        if (userToken) {
            config.headers.Authorization = `Bearer ${userToken}`;
        }
        console.log('xxxxxxxxxxxxxxxxxxxxxxxxx');
        console.log(userToken);
            // Check if the request is for login or logout to adjust token handling
        if (
            config.url != "/api/login" && config.url != "/api/logout" &&
            config.headers.hasOwnProperty("Authorization") && config.headers.Authorization == null
        ) {
            try {
                // Redirect to login if there's an attempt to access a protected resource without a token

              if(!config.headers.Authorization) window.location.href = "/login";
                console.error("Error: No token provided for protected request. Redirecting to login.");

            } catch (error) {
                 console.error("Error redirecting to login:", error);
            }
        }

        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

// Interceptor to handle responses
instance.interceptors.response.use(
    (response) => {
        // If the response is from the login request, update the token and save it in cookie.
        if (response.config.url === "/api/login") {
            userToken = response.data.token;
            userAuthCookie.setCookie(

                JSON.stringify({ token: userToken })
            );
             console.log("token set : ",userToken);
        }
        if(response.config.url === "home"){
            axios.post('/api/login', {email: window.Laravel, password: 12345678}).then((response)=>{
                userToken = response.data.token;
            userAuthCookie.setCookie(
                JSON.stringify({ token: userToken })
            );
            })
        }
        return response;
    },
    (error) => {
        // Handle 401 errors (unauthorized) which might mean token is invalid or expired
        if (error.response && error.response.status === 401) {
          console.error("Unauthorized request. Clearing token and redirecting to login.");
            //logout user and remove cookie
          userToken = null;
          userAuthCookie.removeCookie();
           if(window.location.href != import.meta.env.APP_URL+'login'){
            axios.post('/logout').then((e)=>{
                // window.location.href = "/login";
            }).catch((e)=>{

            })

          }
        }

        return Promise.reject(error);
    }
);

export default instance;
