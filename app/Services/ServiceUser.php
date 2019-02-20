<?php
namespace App\Services;

use App\User;
use Auth;
use Illuminate\Support\Facades\Hash;

class ServiceUser
{

    private $model;
    private $role_id = 2;

    public function __construct()
    {
        $this->model = new User();
    }

    public function createUser($email, $password, $name, $phone, $role_id = 0)
    {
        $data = [
            'name'     => $name,
            'email'    => $email,
            'phone'    => $phone,
            'role_id'  => $role_id > 0 ? $role_id : $this->role_id];

        if($password)
            $data['password'] = Hash::make($password);

        return $this->model::create($data);
    }

    public function findOrNewUserCart($email, $name, $phone){
        //Пользователь
        if(Auth::check()){
            return Auth::user();
        }else{
            $user = $this->model::where('email', $email)->first();
            if(!$user){
                $user = $this->createUser(
                    $email,
                    null,
                    $name,
                    $phone
                );
                Auth::loginUsingId($user->id);
            }
            return $user;
        }
    }

}