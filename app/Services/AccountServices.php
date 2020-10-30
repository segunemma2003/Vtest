<?php

namespace App\Services;

use App\Models\User;
use Auth;
class AccountServices
{
    protected $user;
    public function __construct()
    {
        $this->user=auth()->user();
    }

    public function makeTransfer($amount,$receiver)
    {
        $this->user->balance =$this->user->balance - floatval($amount);
        $receiver=$receiver->balance+floatval($amount);
        $receiver->save();
    }
    public function sendNow($data)
    {
        if($data->amount_to_send >= $this->user->balance){
            if($data->amount_to_send > 50000){
                if($this->user->verified){
                    $receiver=User::where('account_number','=',$data->account_number)->first();
                    if($receiver){
                        $this->makeTransfer($data->amount_to_send,$receiver);
                        return [
                            "status"=>true,
                            "message"=>"Money is Sent",
                            "data"=>$this->user
                        ];
                    }
                    return [
                        'status'=>false,
                        'message'=>'Account Number does not exist'
                    ];
                }
                return [
                    'status'=>false,
                    'message'=>'You have not yet been verified'
                ];
            }

            
        }
        return [
            'status'=>false,
            'message'=>'Insufficient funds'
        ];
        
    }
    public function sendLater($data)
    {
        
    }
    public function checkBalance($data)
    {
        return [
            'status'=>true,
            'data'=>$this->user->balance
        ];
    }
}