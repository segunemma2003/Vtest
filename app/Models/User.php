<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Hashids;
class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];
protected $guarded=['id'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected static function boot()
    {
        $lastUser=User::lastest()->first();
        $count=0;
        if($lastUser != null){
            $count=$lastUser->id + 1;
        }
        User::saving(function ($model) {
            if($count)
            $model->referal_id=Hashids::encode($count);
            $model->account_number=Hashids::connection('alternative')->encode($count);
            if($this->refered_by != null){
                $user =User::where('referal_id','=',$this->refered_by)->first();
                if($user){
                    $user->balance=$user->balance+1000;
                    $user->save();
                }
            }

        });
    }
  
}
