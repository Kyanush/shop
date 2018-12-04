<?php

namespace App\Http\Controllers\Admin\Api;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Address;
use App\Models\Company;
use App\Requests\SaveUserRequest;
use App\User;
use Illuminate\Http\Request;
use DB;

class UserController extends AdminController
{


    public function list(Request $request)
    {
        $search  = trim(mb_strtolower($request->input('search')));
        $role_id = $request->input('role_id', 0);

        $list =  User::withTrashed()->with('role')->where(function ($query) use ($search){

                if(!empty($search))
                {
                    $query->Where(   DB::raw('LOWER(name)'),    'like', "%"  . $search . "%");
                    $query->OrWhere( DB::raw('LOWER(email)'),   'like', "%"  . $search . "%");
                    $query->OrWhere( DB::raw('LOWER(surname)'), 'like', "%"  . $search . "%");
                    $query->OrWhere( DB::raw('LOWER(phone)'),   'like', "%"  . $search . "%");
                }

            })
            ->where(function ($query) use ($role_id){
                if($role_id > 0)
                    $query->where('role_id', $role_id);
            })
            ->OrderBy('id', 'DESC')
            ->paginate($request->input('perPage', 10));

        return  $this->sendResponse($list);
    }

    //SaveAttribute
    public function save(SaveUserRequest $request)
    {
        $data = $request->input('user');

        $user = User::withTrashed()->findOrNew($data["id"]);

        if (empty($data['password']))
            unset($data['password']);
        else
            $data['password'] = bcrypt($data['password']);

        $user->fill($data);


        if($user->save())
        {

            if(!empty($data['addresses']))
            {
                foreach ($data['addresses'] as $item)
                {
                    if(intval($item['is_delete']) == 1){
                        Address::destroy($item["id"]);
                    }else{
                        $address = Address::findOrNew($item["id"]);
                        $item['user_id'] = $user->id;
                        $address->fill($item);
                        $address->save();
                    }
                }
            }

            if(!empty($data['companies']))
            {
                foreach ($data['companies'] as $item)
                {
                    if(intval($item['is_delete']) == 1){
                        Company::destroy($item["id"]);
                    }else{
                        $company = Company::findOrNew($item["id"]);
                        $item['user_id'] = $user->id;
                        $company->fill($item);
                        $company->save();
                    }
                }
            }

            if(($user->deleted_at ? 0 : 1) != intval($data['active']))
                if(intval($data['active']) == 0)
                    $user->delete();
                else
                   $user->restore();
        }

        return  $this->sendResponse($user->save() ? $user->id : false);
    }



    public function view($id)
    {
        $user = User::with(['addresses', 'companies'])->withTrashed()->findOrFail($id);

        if($user){
            if($user->addresses)
            {
                $addresses = $user->addresses->map(function ($item){
                    return [
                        'id'        => $item->id,
                        'address'   => $item->address,
                        'city'      => $item->city,
                        'comment'   => $item->comment,
                        'is_delete' => false
                    ];
                });
                unset($user->addresses);
                $user->addresses = $addresses;
            }
            if($user->companies)
            {
                $companies = $user->companies->map(function ($item){
                    return [
                        'id'        => $item->id,
                        'name'      => $item->name,
                        'address'   => $item->address,
                        'county'    => $item->county,
                        'city'      => $item->city,
                        'info'      => $item->info,
                        'is_delete' => false
                    ];
                });
                unset($user->companies);
                $user->companies = $companies;
            }

        }
        return $this->sendResponse($user);
    }


    public function delete($id)
    {
        $user = User::withTrashed()->find($id);
        return  $this->sendResponse($user->forceDelete() ? true : false);
    }





}
