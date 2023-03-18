<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Support\Cropper;
use Illuminate\Support\Facades\Storage;

class PropertyImage extends Model {

    use HasFactory;

    protected $fillable = [
        'property',
        'path',
        'cover'
    ];

    public function getUrlCroppedAttribute() {
        return Storage::url(Cropper::thumb($this->path, 1366, 768));
    }

}
