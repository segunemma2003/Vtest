<?php

namespace App\Services;

use App\Models\User;
use App\Models\SchelduledTask;
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

        $receiver->balance=$receiver->balance+floatval($amount);
        $this->user->save();
        $receiver->save();
        return true;
    }
    public function dTransfer($data)
    {
        
        $receiver=User::where('account_number','=',$data['account_number'])->first();
                    if($receiver){
                        if($data['immediate']){
                            $this->makeTransfer($data['amount_to_send'],$receiver);
                            return [
                                "status"=>true,
                                "message"=>"Money is Sent",
                                "data"=>$this->user
                            ];
                        }else{
                            $this->sendLater($data['amount_to_send'],$receiver,$data['transferTime']);
                            return [
                                "status"=>true,
                                "message"=>"Money is Sent",
                                "data"=>$this->user
                            ];
                        }
                       
                    }
                    return [
                        'status'=>false,
                        'message'=>'Account Number does not exist'
                    ];
    }
    public function sendNow($data)
    {
        $this->user=auth()->user();
        if($data['amount_to_send'] <= $this->user->balance){
            if($data['amount_to_send'] > 50000){
                if($this->user->verified){
                    $this->dTransfer($data);
                }
                return [
                    'status'=>false,
                    'message'=>'You have not yet been verified,please upload your id for proper verification'
                ];
            }else{
                $this->dTransfer($data);
            }

            
        }
        return [
            'status'=>false,
            'message'=>'Insufficient funds'
        ];
        
    }
    public function sendLater($data,$receiver,$time)
    {
        
        $task=new SchelduledTask([
            "sender"=>$this->user->account_number,
            "receiver"=>$receiver,
            "transfer_time"=>$time,
            "amount"=>$data
        ]);
        if($task->save()){
            return true;
        }   
        return false;
    }
    public function sendJob($sender,$receiver,$amount)
    {
        $senderA=User::where('account_number',$sender)->first();
        if($amount >= $senderA->balance){
            if($amount > 50000){
                if($senderA->verified){
                    


                    $receiverA=User::where('account_number','=',$receiver)->first();
                    if($receiverA){
                       
                        $senderA->balance =$senderA->balance - floatval($amount);

                        $receiverA=$receiverA->balance+floatval($amount);
                        $senderA>save();
                        $receiverA->save();
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
            }else{
                $receiverA=User::where('account_number','=',$receiver)->first();
                if($receiverA){
                   
                    $senderA->balance =$senderA->balance - floatval($amount);

                    $receiverA=$receiverA->balance+floatval($amount);
                    $senderA>save();
                    $receiverA->save();
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
            
            
            
        }
        return [
            'status'=>false,
            'message'=>'Insufficient funds'
        ];
    

    }
    public function checkBalance($data)
    {
        return [
            'status'=>true,
            'data'=>$this->user->balance
        ];
    }
}