<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

/**
 * Class FileUpload
 * @package App\SOSC\Utilities
 */
class FileUpload
{
    public static function handle($file,$id,$path = 'default',$oldFile = false)
    {
        if($oldFile && file_exists(public_path().$oldFile)){
            unlink(public_path().$oldFile);
        }
        
        $filename = date('YmdHi').$file->getClientOriginalName();
        $file->move(public_path('images/'.$path), $filename);
        return "/images/{$path}/{$filename}";
    }
}