<?php

namespace App\Tools;

use File;
use Illuminate\Http\UploadedFile;

trait UploadableTrait
{

    public function uploadFile($file, $path)
    {
        if(is_uploaded_file($file))
        {
            $fileName = md5(uniqid('', true)).'.'.$file->extension();
            if($file->move($path, $fileName))
                return $fileName;
            else
                return '';
        }
        return $file;
    }

    public function copyFile($oldPath, $newPath){
        if(!File::exists($oldPath))
            return false;

        //формат файла
        $fileExtension = File::extension($oldPath);

        //новое имя
        $fileName = md5(uniqid('', true)) . '.' . $fileExtension;

        //создаем папку product/{product_id}

        if(!File::isDirectory($newPath))
            File::makeDirectory($newPath);

        return File::copy($oldPath , $newPath . $fileName) ? $fileName : false;
    }

}
