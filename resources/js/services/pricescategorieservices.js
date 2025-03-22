import { ref } from "vue";
import instance from "../api/index.js";
export default function usePriceCategorie() {
    const url = "/api/price/categorie";
    const priceCategorie = ref([]);
    const errors = ref("");
    const getPriceCategorie = async () => {
        let resp = await instance.get(url);

        priceCategorie.value = resp.data.data;
    };
    const storePriceCategorie = async (data) => {
        let resp = await instance.post(url, data);

        // await routes.push({ name: "admin.home" });0
        // try {
        //     let resp = await instance.post('/api/entreprises', data);
        //     // entreprises.value = resp.data.data;

        //     // routes.push({ name: "admin.home" });
        // } catch (error) {
        //    const  storeEntrepriseErrors = error.response.data.errors;
        // for( const key in storeEntrepriseErrors){
        //     errors.value +=storeEntrepriseErrors[key][0]+ ' ';
        // }

        // }
    };

    return {
        priceCategorie,
        errors,
        getPriceCategorie,
        storePriceCategorie,
    };
}
