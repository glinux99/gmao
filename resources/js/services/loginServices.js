import axios from "axios";
const LoginService = {
    loginProvider(provider) {
        // Directly redirect the browser to the Laravel route
        window.location.href = `/redirect/${provider}`;
    },

    login(credentials) {
        console.log("Attempting login...");
        return new Promise((resolve, reject) => {
            axios.post("/login", credentials);
            axios.post("/api/login", credentials)
                .then((response) => {
                    console.log("Login successful:", response.data);
                    localStorage.setItem('userAuth', JSON.stringify({ data: response.data }) );

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
