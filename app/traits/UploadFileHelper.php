<?php

namespace App\traits;

use Illuminate\Support\Facades\Storage;

trait UploadFileHelper
{

    public function uploadFile($file,$folder='files',$drive='public')
    {
        $file_name = time().'_'.$file->getClientOriginalName();
        return  $file->storeAs($folder,$file_name,$drive);
    }
    public function deleteFile($file,$drive='public')
    {
        if(Storage::drive($drive)->exists($file)){
            return Storage::drive($drive)->delete($file);
        }
    }

    public function updateFile($file,$current_file,$folder='files',$drive='public')
    {
        $this->deleteFile($current_file,$drive);
        return $this->uploadFile($file,$folder,$drive);
    }


}
