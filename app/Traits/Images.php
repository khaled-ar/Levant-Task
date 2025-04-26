<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait Images {

    // This function do changing image name and then move it.
    public function moveImage($image, $model, $dir = 'public') {
        $new_name = Str::random(50) .  '.' . $image->getClientOriginalExtension();

        if($dir == 'public') {
            // Public Directory
            File::move($image->getRealPath(), public_path("$model") . '/' . $new_name);
        } else {
            // Storage Directory
            $image->storeAs("public/$model", $new_name);
        }

        return $new_name;
    }

    // This function do image delation.
    public function deleteImage($path) {
        if(file_exists($path)) {
            unlink($path);
        }
    }
}
