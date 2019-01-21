<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory;
use App\Tools\UploadableTrait;

class UploadImageController extends Controller
{
    use UploadableTrait;

    public function __construct()
    {
        //$this->middleware('guest');
    }

    public function CkeditorUploadImage(Request $request, Factory $validator)
    {

        $valid = $validator->make($request->all(), [
            'upload' => 'mimes:jpeg,jpg,gif,png'
        ]);

        $funcNum = $request->input('CKEditorFuncNum');

        if ($valid->fails()) {
            return response(
                "<script>
                    window.parent.CKEDITOR.tools.callFunction({$funcNum}, '', '{$valid->errors()->first()}');
                </script>"
            );
        }

        $file = $request->file('upload');
        $path = $request->input('path');
        if(empty($path))
            return false;

        $file_name = $this->uploadFile($file, $path);

        if($file_name)
        {
            $url = '/' . $path . $file_name;
            return response(
                "<script>
                    window.parent.CKEDITOR.tools.callFunction({$funcNum}, '{$url}', 'Изображение успешно загружено');
                </script>"
            );
        }else{
            return false;
        }
    }

}