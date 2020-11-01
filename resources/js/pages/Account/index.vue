<template>
    <div>
        <p v-if="errors.length">
    <b>Please correct the following error(s):</b>
    <ul>
      <li v-for="(error, index) in errors" :key="index" class="list"><div class="alert alert-danger">{{ error }}</div></li>
    </ul>
  </p>
        <div class="form-group">
            <label for="exampleInputEmail1">Account Number</label>
            <input type="text" v-model="data.account_number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
           
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Amount</label>
            <input type="number" v-model="data.amount_to_send" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Immediate </label>
            <select v-model="data.immediate" class="form-control" id="exampleInputPassword1">
                <option v-for="(option,index) in options" :key="index" :value="option.value">{{option.text}}</option>
                
            </select>
        </div>
        <div class="form-group" v-if="!data.immediate">
            <label for="exampleInputPassword1">Trasfer time</label>
            <input type="date" v-model="data.transferTime" class="form-control" id="exampleInputPassword1">
        </div>
        <button type="submit" @click="send" class="btn btn-primary">Submit</button>
    </div>
</template>
<script>
export default {
    data(){
        return {
            errors:[],
            data:{
                "amount_to_send":"",
                "account_number":"",
                "immediate":true,
                "transferTime":""
            },
            options: [
                    {text: 'Yes', value: true},
                    {text: 'No', value: false},
                    ],
            
        }
    },
    computed:{
        // user:{
        //     get(){
        //         return this.$store.state.user.user;
        //     }
        // }
        token:{
            get(){
                return localStorage.getItem('_token');
            }
        }
    },
    methods:{
        send()
        {
            if(this.validate(this.data)){
                console.log(this.data)
                 this.$store.dispatch('user/sendMoney',this.data)
                 .then(res=>{
                     console.log(res);
                     this.$swal({
                         "type":"Success",
                         "text": "Money is Sent"
                     })
                 })
                 .catch(err=>{
                     this.$swal({
                         "type":"error",
                         "text": err.response.data.message
                     })
                 })
            }
        },
         validate(data){
            this.errors=[];
             if ((data.amount_to_send && data.account_number)||(data.amount_to_send && data.account_number && (data.immediate==false && data.transferTime))) {
            return true;
            }
            if(!data.amount_to_send){
                this.errors.push("amount is required");
            }
            if(!data.account_number){
                this.errors.push("Please type in your account number");
            }
            if(!data.immediate){
                this.errors.push("Please choose immediate");
            }
            if(data.immediate==false && !data.transferTime){
                this.errors.push("Please type in transfer time");
            }
        },
    }
}
</script>