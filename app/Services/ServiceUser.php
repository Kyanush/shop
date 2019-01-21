<?php
namespace App\Services;

use App\User;
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

}