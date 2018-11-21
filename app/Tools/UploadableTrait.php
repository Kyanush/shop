<?php

namespace App\Tools;

use File;
use Illuminate\Http\UploadedFile;

trait UploadableTrait
{
/*
    public function deleteFiles($files, $delete_files)
    {
        if(!empty($files) and !empty($delete_files))
        {
            $files = json_decode($files);
            foreach($delete_files as $delete_file)
            {
                $key = array_search($delete_file, $files);
                if($key >= 0)
                {
                    File::delete('public/uploads/' . $files[$key]);
                    unset($files[$key]);
                }
            }
            return !empty($files) ? json_encode(array_values($files)) : null;
        }

        return $files;
    }


    public function uploadsFiles($files, $old_files = null)
    {
        if(is_array($files))
        {
            $add_files = [];
            foreach ($files as $file)
            {
                $name = rand() .'-'.  $file->getClientOriginalName();
                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                if($ext != 'php' and $ext != 'js')
                    if($file->move('public/uploads/', $name))
                        $add_files[] = $name;
            }

            if(count($add_files) > 0)
                return empty($old_files) ? json_encode($add_files) : json_encode(array_merge(json_decode($old_files), $add_files));
        }

        return $old_files;
    }
 */

    public function uploadFile($file, $path)
    {

        if(is_file($file))
        {
            //$fileName = rand() . '-' .  $file->getClientOriginalName();
            $fileName       = md5(uniqid('', true)).'.'.$file->extension();

            if($file->move($path, $fileName))
                return $fileName;
            else
                return '';
        }
        return $file;
    }

}
