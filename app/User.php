<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Request;
use Hash;
class User extends Authenticatable
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
    protected $table="user";
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public  function signup(){
        $check=$this->usernamepwd();
        if(!$check){
            return ['state'=> 0,'msg'=>'用户名密码不能为空'];
        }

          $username=$check[0];
          $pwd=$check[1];
         /* $user_exists = $this->where('username',$username)
              ->exists();
          if($user_exists){
              return ['state'=>0,'msg'=>'用户已存在'];

          }*/
              $pwds=bcrypt($pwd);
              $user=$this;

              $user->username=$username;
              $user->password=$pwds;

              if($user->save()){
                  return ['state'=>1,'id'=>$user->id];
              }

    }
    public function login(){
        $check=$this->usernamepwd();
        if(!$check){
            return ['state'=> 0,'msg'=>'用户名密码不能为空'];
        }
        $username=$check[0];
        $pwd=$check[1];
        $user=$this->where('username',$username)->first();
        if(!$user){
            return ['state'=>0,'msg'=>'用户不已存在'];
        }
        $userpwd=$user->password;
        if(!Hash::check($pwd),$userpwd){
            return ['state'=>0,'msg'=>'用户不已存在'];
        } else {

          /* return ['state'=>1,'id'=>$user->id];

            session()->put('username',$user->username);
            session()->put('user_id',$user->id);*/
        }
    }
    public  function  usernamepwd(){
        $username=Request::get('username');
        $pwd=Request::get('password');

       if($username && $pwd){
           return [$username,$pwd];
       }else{
           return false;
       }

    }
}
