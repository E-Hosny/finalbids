<?php

namespace App\Traits;  
use Illuminate\Http\Request;
use File;

trait ImageTrait {  
    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function verifyAndUpload(Request $request, $fieldname = 'image', $oldFile = null, $folder="users") {
        if( $request->hasFile( $fieldname ) ) {
            $img = time().$fieldname.'.'.$request[$fieldname]->extension();
            $path = public_path("img/$folder");
            if(!File::exists($path)){
                File::makeDirectory($path, 0755, true, true);
            }
            $request->file($fieldname)->move($path, $img);
            if(!empty($oldFile) && File::exists(public_path("img/$folder/$oldFile"))){
                File::delete(public_path("img/$folder/$oldFile"));
            }
            return $img;
        }
        return null;
    }

    public function uploadImage($imgName = "img", $image = 'image', $path="uploads", $oldFile = null) {
        $img = time().$imgName.'.'.$image->extension();
        $path = public_path($path);
        if(!File::exists($path)){
            File::makeDirectory($path, 0755, true, true);
        }
        $image->move($path, $img);
        if(!empty($oldFile) && File::exists($path.'/'.$oldFile)){
            File::delete($path.'/'.$oldFile);
        }
        return $img;
    }
  
}