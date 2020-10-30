import axios from "axios";

const state={
    user:{
        email:"test@g.com",
        isLoggedIn:false
    },
    color:"red"
};
const getters= {}
const actions ={
    logout(){
        localStorage.clear()
    },
    getDetails(){
        axios.get('/api/details')
        .then(response=>{
            commit('setUser',response.data);
        })
        .catch(err=>console.log(err.response.data));
    },
    loginUser({},user){
        axios.post("/api/login",{
           email:user.email,
           password:user.password 
        })
        .then(res=>{
            if(Response.data.access_token){
                localStorage.setItem("_token",response.data.data.token)
            }
            console.log(res)
            window.location.replace('/home');
        }).catch((err)=>{
            console.log(err.response.data.message)
        });
    },
    registerUser({},user){
        axios.post("/api/register",{
           email:user.email,
           password:user.password,
           c_password:user.c_password,
           name:user.name,
           image:user.image,
           refered_by:user.refered_by
        })
        .then(res=>{
            if(Response.data.access_token){
                localStorage.setItem("_token",response.data.data.token)
            }
            console.log(res)
            window.location.replace('/home');
        }).catch((err)=>{
            console.log(err.response.data.message)
        });
    }
}
const mutations={
    setUser(state,data) {
        state.user=data;
    }
}


export default {
    namespaced:true,
    state,
    getters,
    actions,
    mutations
}