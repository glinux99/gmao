import api from "../api";

const LoginService = {
    login(credentials) {
        return new Promise((resolve, reject) => {
            // api.post("/api/login", credentials)
            api.post("/login", credentials)
                .then((response) => {
                    resolve(response.data);
                })
                .catch((error) => {
                    reject(error);
                });
        });
    },
};

export default LoginService;
