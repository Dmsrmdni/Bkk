<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    public function image()
    {
        if ($this->image_perusahaan && file_exists(public_path($this->image_perusahaan))) {
            return asset($this->image_perusahaan);
        }
    }

    public function deleteImage()
    {
        if ($this->image_perusahaan && file_exists(public_path($this->image_perusahaan))) {
            return unlink(public_path($this->image_perusahaan));
        }
    }
}
