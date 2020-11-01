<template>
    <div>
        
        <div class="form-group">
             <p v-if="errors.length">
    <b>Please correct the following error(s):</b>
    <ul>
      <li v-for="(error, index) in errors" :key="index" class="list"><div class="alert alert-danger">{{ error }}</div></li>
    </ul>
  </p>
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" v-model="user.email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" v-model="user.password" class="form-control" id="exampleInputPassword1" required>
        </div>
        <button type="submit" @click="login" class="btn btn-primary">Submit</button>
    </div>
</template>
<script>
export default {
    data(){
        return {
            errors:[],
            user:{
                email:"",
                password:""
            }
        }
    },
    mounted(){
        if(this.token){
            window.location.replace("/home#/dashboard");
        }
    },
    computed:{
        token:{
            get(){
                return localStorage.getItem('_token');
            }
        }
        
    },
    methods:{

        validate(user){
            this.errors=[];
             if (user.password && user.email) {
            return true;
            }
            if(!user.email){
                this.errors.push("email is required");
            }
            if(!user.password){
                this.errors.push("Please type in your password");
            }
        },
        async login()
        {
            if(this.validate(this.user)){
               await this.$store.dispatch('user/loginUser',this.user)
                .then(res=>{
                    console.log(res.data.data.token)
                    if(res.data.data.token){
                    localStorage.setItem("_token",res.data.data.token)
                    
                        console.log(res)
                        this.$swal({"type":'success',
                        'text':'You have successfully logged In'});
                        window.location.replace('/home#/dashboard');
                    }
                    }).catch((err)=>{
                        if(err.response.data.error){
                               
                            this.errors.push('Account Details is wrong')
                        
                        }
                        else{
                            this.errors.push(err.response.data.message)
                        }
                    });
            }
            
        }
    }
}
</script>