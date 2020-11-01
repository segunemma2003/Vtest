import axios from "axios";
import validatableModule from "vuex-module-validatable-state";


const state={
    user:{
        
    },
    color:"red"
};
const getters= {}
const actions ={
    logout(){
        localStorage.clear()
    },
    sendMoney({commit,state},data){
        axios.post('/balane',{
            "amount_to_send":data.amount_to_send,
            "account_number":data.account_number,
            "immediate":data.immediate,
            "transferTime":data.transferTime
        });    
    },
    getDetails({commit}){
        axios.get('/api/details')
        .then(response=>{
            localStorage.setItem('user_details',JSON.stringify(response.data.data))
            console.log(commit('setUser',response.data.data));
        })
        .catch(err=>console.log(err));
    },
    loginUser({},user){
        return axios.post("/api/login",{
           email:user.email,
           password:user.password 
        })
        
    },
    registerUser({},user){
        console.log(user);
       return axios.post("/api/register",{
           email:user.email,
           password:user.password,
           c_password:user.c_password,
           name:user.name,
           image:user.image,
           refered_by:user.refered_by
        })
        
    }
}
const mutations={
    setUser(state,data) {
        console.log("s",data)
        state.user=data;
       
    },

}


export default {
    namespaced:true,
    state,
    getters,
    actions,
    mutations
}