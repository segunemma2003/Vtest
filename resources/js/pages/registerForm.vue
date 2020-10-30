<template>
    <div>
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="email" v-model="user.email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" v-model="user.email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Referer code</label>
            <input type="email" v-model="user.email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group row">
            <div class="col-md-3" v-if="user.image">
                              <img :src="user.image" class="img-responsive" height="70" width="90">
                           </div>
             <div class="col-md-6">              
            <label for="exampleInputPassword1">ID card </label>
            <input type="file" v-on:change="onImageChange"  class="form-control" id="exampleInputPassword1">
             </div>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Verify Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <button type="submit" @click="login" class="btn btn-primary">Submit</button>
    </div>
</template>
<script>
export default {
    data(){
        return {
            user:{
                name:"",
                email:"",
                password:"",
                c_password:"",
                image:"",
                referal_id:""
            }
        }
    },
    computed:{
        // user:{
        //     get(){
        //         return this.$store.state.user.user;
        //     }
        // }
    },
    methods:{
        register()
        {
            this.$store.dispatch('user/registerUser',this.user);
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