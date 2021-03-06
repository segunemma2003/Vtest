<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AccountServices;
class AccountController extends Controller
{
    protected $account_services;
    public function __construct(AccountServices $account_services){
        $this->account_services=$account_services;
    }


    // public function sendNow(Request $request)
    // {
    //     $balance=$this->account_services->sendNow($request->all());
    //     if (isset($balance['status']) && !$balance['status']) {
    //         return $this->badRequest($balance['message']);
    //     }

    //     return $this->success($balance);
    // }
    public function send(Request $request)
    {   
        
       
    //     $validator=$request->validate([
    //         "amount_to_send"=>"required",
    //         "account_number"=>"required",
    //         "transferTime"=>"nullable",
    //         "immediate"=>"required"

    //     ]);
    // //    dd($validator);
       
    //     if($validator->fails()){
    //         return $this->badRequest($validator->errors);
    //     }
    //     return response([
    //         "it worked"
    //     ],200);
        
        $balance=$this->account_services->sendNow($request->all());
        if (isset($balance['status']) && !$balance['status']) {
            return $this->badRequest($balance['message']);
        }

        return $this->success($balance);

    }
    public function checkBalance(Request $request)
    {

        $balance=$this->account_services->checkBalance($request->all());
        if (isset($balance['status']) && !$balance['status']) {
            return $this->badRequest($balance['message']);
        }

        return $this->success($balance);
    }
}
