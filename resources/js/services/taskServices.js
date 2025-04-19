import { useCookie } from '@vue-composable/cookie';
import { ref } from 'vue';
import instance from '../api/index.js';

export default function useTasks() {
    let userAuthCookie = useCookie("userAuth");
    const tasks = ref([]);
    const task = ref({});
    const errors = ref({});
    const isLoading = ref(false);
    const getUserLogin=async()=>{
        let provider =JSON.parse(document.querySelector("meta[name='user_auth']").getAttribute('content')).provider;
        let email =JSON.parse(document.querySelector("meta[name='user_auth']").getAttribute('content')).email;
        console.log(provider);
        console.log(email);
        if(provider=="google" || provider=="google.com"){
         await   axios.post('/api/login', {email: email, password: 12345678}).then((response)=>{
            if(response.data.token!=null)    {
                userAuthCookie.setCookie(
                    JSON.stringify({ token: response.data })
                );
                localStorage.setItem('userAuth', JSON.stringify({ data: response.data }) );
                console.log("response.data.token");
                console.log(response.data);
            }
            });
        }

    }
    const getTasks = async () => {
       await getUserLogin();
        errors.value = {};
        isLoading.value = true;
        try {
            const response = await instance.get('/api/tasks');
            tasks.value = response.data.data;
        } catch (e) {
            errors.value = e.response.data.errors;
            console.log("errors.value");
        } finally {
            isLoading.value = false;
        }
    };

    const getTask = async (id) => {
        errors.value = {};
        isLoading.value = true;
        try {
            const response = await instance.get(`/api/tasks/${id}`);
            task.value = response.data.data;
        } catch (e) {
            errors.value = e.response.data.errors;

        } finally {
            isLoading.value = false;
        }
    };

    const storeTask = async (data) => {
        errors.value = {};
        isLoading.value = true;
        try {
            const response = await instance.post('/api/tasks', data);
            // tasks.value.push(response.data.data);
             return true;
        } catch (e) {
            errors.value = e.response.data.error;
            return false;
        } finally {
            isLoading.value = false;
        }
    };

    const updateTask = async (id, data) => {
        errors.value = {};
        isLoading.value = true;
        try {
            const response = await instance.put(`/api/tasks/${id}`, data);
            // const index = tasks.value.findIndex((t) => t.id === id);
            // if (index !== -1) {
            //     tasks.value[index] = response.data.data;
            // }
            return true;
        } catch (e) {
            errors.value = e.response.data.errors;
            return false;
        } finally {
            isLoading.value = false;
        }
    };

    const destroyTask = async (id) => {
        errors.value = {};
        isLoading.value = true;
        try {
            await instance.delete(`/api/tasks/${id}`);
            tasks.value = tasks.value.filter((task) => task.id !== id);
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    const getTaskCategories = async () => {
        return [
           {"name":  "Préventive"},
           {"name":  "Corrective"},
            {"name": "Predictive"},
           {"name": "Inspection"}
        ];
    }
    const storeImport=async(data, config)=>{
          try{
              const res= await instance.post('/api/tasks/import',data,config
              )
             console.log(res.data);

          }catch(e){
                  console.log(e.message);
          }

      }

    return {
        tasks,
        task,
        errors,
        isLoading,
        getTasks,
        getTask,
        storeTask,
        updateTask,
        destroyTask,
        getTaskCategories,
        getUserLogin,
        storeImport
    };
}
