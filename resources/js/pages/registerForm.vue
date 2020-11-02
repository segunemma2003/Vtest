<template>
    <div>
        <p v-if="errors.length">
    <b>Please correct the following error(s):</b>
    <ul>
      <li v-for="(error, index) in errors" :key="index" class="list"><div class="alert alert-danger">{{ error }}</div></li>
    </ul>
  </p>

        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="email" v-model="user.name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" v-model="user.email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Referer code</label>
            <input type="email" v-model="user.refered_by" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
        </div>
        <div class="form-group row">
            <div class="col-md-3" v-if="user.image">
                              <img :src="user.image" class="img-responsive" height="70" width="90">
                           </div>
             <div class="col-md-6">              
            <label for="exampleInputPassword1">ID card </label>
            <input type="file" v-on:change="onImageChange"  ref="image" refs="image"  class="form-control" id="exampleInputPassword1">
             </div>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" v-model="user.password" class="form-control" id="exampleInputPassword1" required>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Verify Password</label>
            <input type="password" v-model="user.c_password" class="form-control" id="exampleInputPassword1" required>
        </div>
        <button type="submit" @click="register" class="btn btn-primary">Submit</button>
    </div>
</template>
<script>
export default {
    data(){
        return {
            errors:[],
            user:{
                name:"",
                email:"",
                password:"",
                c_password:"",
                image:"",
                refered_by:""
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
             if (user.name && user.email && user.password == user.c_password) {
            return true;
            }
            if(!user.name){
                this.errors.push("Name is required");
            }
            if(!user.email){
                this.errors.push("Email is required");
            }
            if(user.password != user.c_password){
                this.errors.push("Password does not match");
            }
        },
        async register()
        {
          
            if(this.validate(this.user)){
               await this.$store.dispatch('user/registerUser',this.user)
                .then(res=>{
                    console.log(res.data.data)
 
                    if(res.data.data.token){
                        
                    localStorage.setItem("_token",res.data.data.token)
                    
                        console.log(res)
                        this.$swal({"type":'success',
                        'text':'You have successfully registered'});
                        window.location.replace('/home#/dashboard');
                    }
                    }).catch((err)=>{
                        if(err.response.data.error){
                                if(err.response.data.error.email ){
                        this.errors.push('email is already taken')
                        }else if(err.response.data.password){
                            this.errors.push('check that your password match')
                        }
                        }
                        else{
                            this.errors.push(err.response.data.message)
                        }
                    });
            }
        },
         onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
    }
}
</script>