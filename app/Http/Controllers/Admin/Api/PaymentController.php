<?php

namespace App\Http\Controllers\Admin\Api;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Payment;
use App\Requests\SavePaymentRequest;
use Illuminate\Http\Request;
use DB;
use App\Tools\UploadableTrait;
use File;

class PaymentController extends AdminController
{
    use UploadableTrait;

    public function list(Request $request)
    {
        $search = trim(mb_strtolower($request->input('search')));

        $list =  Payment::where(function ($query) use ($search){

                    if(!empty($search))
                    {
                        $query->Where(   DB::raw('LOWER(name)'),          'like', "%"  . $search . "%");
                    }

                })
                ->OrderBy('ID', 'DESC')
                ->paginate($request->input('perPage') ?? 5);

        return  $this->sendResponse($list);
    }

    public function save(SavePaymentRequest $request)
    {
        $data = $request->all();
        $data = $data['payment'];

        $payment = Payment::findOrNew($data["id"]);

        if($request->file('payment.logo'))
        {
            if($payment->logo)
                $payment->deleteLogo();

            $data['logo'] = $this->uploadFile($data['logo'], config('shop.payments_path_file'));
        }
        $payment->fill($data);

        return  $this->sendResponse($payment->save() ? $payment->id : false);
    }

    public function view($id)
    {
        return  $this->sendResponse(
            Payment::findOrFail($id)
        );
    }

    public function delete($id)
    {
        return  $this->sendResponse(Payment::destroy($id) ? true : false);
    }

}