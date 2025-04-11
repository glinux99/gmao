import { ref } from "vue";
import instance from "../api/index";

export default function useTeams() {
    const teams = ref([]);
    const isLoading = ref(false);
    const errors = ref([]);

    const getTeams = async () => {
        isLoading.value = true;
        try {
            const response = await instance.get("/api/teams");
            teams.value = response.data.data;
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    const storeTeam = async (data) => {
        isLoading.value = true;
        errors.value = [];
        try {
            await instance.post("/api/teams", data);
            return true;
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    const updateTeam = async (id, data) => {
        isLoading.value = true;
        errors.value = [];
        try {
            await instance.put(`/api/teams/${id}`, data);
            return true;
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };
    const updateTeamMembers = async (id, data) => {
        isLoading.value = true;
        errors.value = [];
        try {
            await instance.put(`/api/teams/${id}`, data);
            return true;
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };
    const destroyTeam = async (id) => {
        isLoading.value = true;
        errors.value = [];
        try {
            await instance.delete(`/api/teams/${id}`);
            return true;
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    return {
        teams,
        getTeams,
        storeTeam,
        destroyTeam,
        updateTeam,
        updateTeamMembers,
        isLoading,
        errors,
    };
}
