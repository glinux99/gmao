import api from "../api";
const LoginService = {
    loginProvider(provider) {
        // Directly redirect the browser to the Laravel route
        window.location.href = `/redirect/${provider}`;
    },
    login(credentials) {
        console.log("Attempting login...");
        return new Promise((resolve, reject) => {
            api.post("/login", credentials)
            api.post("/api/login", credentials)
                .then((response) => {
                    console.log("Login successful:", response.data);
                    resolve(response.data);
                })
                .catch((error) => {
                    console.error("Login failed:", error);
                    reject(error);
                });
        });
    },
};

export default LoginService;
