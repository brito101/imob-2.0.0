<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\PropertyImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Support\Cropper;
use Illuminate\Support\Str;

class Property extends Model {

    use HasFactory;

    protected $fillable = [
        'sale',
        'rent',
        'category',
        'type',
        'user',
        'sale_price',
        'rent_price',
        'tribute',
        'condominium',
        'description',
        'bedrooms',
        'suites',
        'bathrooms',
        'rooms',
        'garage',
        'garage_covered',
        'area_total',
        'area_util',
        'zipcode',
        'street',
        'number',
        'complement',
        'neighborhood',
        'state',
        'city',
        'air_conditioning',
        'bar',
        'library',
        'barbecue_grill',
        'american_kitchen',
        'fitted_kitchen',
        'pantry',
        'edicule',
        'office',
        'bathtub',
        'fireplace',
        'lavatory',
        'furnished',
        'pool',
        'steam_room',
        'view_of_the_sea',
        'status',
        'title',
        'slug',
        'headline',
        'experience'
    ];

    /**
     * Relationships
     */
    public function user() {
        return $this->belongsTo(User::class, 'user', 'id');
    }

    public function images() {
        return $this->hasMany(PropertyImage::class, 'property', 'id')
                        ->orderBy('cover', 'ASC');
    }

    public function cover() {
        $images = $this->images();
        $cover = $images->where('cover', 1)->first(['path']);
        if (!$cover) {
            $images = $this->images();
            $cover = $images->first(['path']);
        }
        if (empty($cover['path']) || !File::exists('../public/storage/' . $cover['path'])) {
            return url(asset('backend/assets/images/login.svg'));
        }
        return Storage::url(Cropper::thumb($cover['path'], 1366, 768));
    }

    /**
     * Scopes
     */
    public function scopeAvailable($query) {
        return $query->where('status', 1);
    }

    public function scopeUnavailable($query) {
        return $query->where('status', 0);
    }

    public function scopeSale($query) {
        return $query->where('sale', 1);
    }

    public function scopeRent($query) {
        return $query->where('rent', 1);
    }

    /**
     * Accessor
     */
    public function getSalePriceAttribute($value) {
        if (empty($value)) {
            return null;
        }
        return number_format($value, 2, ',', '.');
    }

    public function getRentPriceAttribute($value) {
        if (empty($value)) {
            return null;
        }
        return number_format($value, 2, ',', '.');
    }

    public function getTributeAttribute($value) {
        if (empty($value)) {
            return null;
        }
        return number_format($value, 2, ',', '.');
    }

    public function getCondominiumAttribute($value) {
        if (empty($value)) {
            return null;
        }
        return number_format($value, 2, ',', '.');
    }

    public function getZipcodeAttribute($value) {
        if (empty($value)) {
            return null;
        }
        return substr($value, 0, 2) . '.' . substr($value, 2, 3) . '-' . substr($value, 5, 3);
    }

    /**
     * Mutators
     */
    public function setSaleAttribute($value) {
        $this->attributes['sale'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setRentAttribute($value) {
        $this->attributes['rent'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setStatusAttribute($value) {
        $this->attributes['status'] = ($value == '1' ? 1 : 0);
    }

    public function setSalePriceAttribute($value) {
        $this->attributes['sale_price'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function setRentPriceAttribute($value) {
        $this->attributes['rent_price'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function setTributeAttribute($value) {
        $this->attributes['tribute'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function setCondominiumAttribute($value) {
        $this->attributes['condominium'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function setZipcodeAttribute($value) {
        $this->attributes['zipcode'] = (!empty($value) ? $this->clearField($value) : null);
    }

    public function setAirConditioningAttribute($value) {
        $this->attributes['air_conditioning'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    public function setBarAttribute($value) {
        $this->attributes['bar'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    public function setLibraryAttribute($value) {
        $this->attributes['library'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    public function setBarbecueGrillAttribute($value) {
        $this->attributes['barbecue_grill'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    public function setAmericanKitchenAttribute($value) {
        $this->attributes['american_kitchen'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    public function setFittedKitchenAttribute($value) {
        $this->attributes['fitted_kitchen'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    public function setPantryAttribute($value) {
        $this->attributes['pantry'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    public function setEdiculeAttribute($value) {
        $this->attributes['edicule'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    public function setOfficeAttribute($value) {
        $this->attributes['office'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    public function setBathtubAttribute($value) {
        $this->attributes['bathtub'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    public function setFirePlaceAttribute($value) {
        $this->attributes['fireplace'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    public function setLavatoryAttribute($value) {
        $this->attributes['lavatory'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    public function setFurnishedAttribute($value) {
        $this->attributes['furnished'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    public function setPoolAttribute($value) {
        $this->attributes['pool'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    public function setSteamRoomAttribute($value) {
        $this->attributes['steam_room'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    public function setViewOfTheSeaAttribute($value) {
        $this->attributes['view_of_the_sea'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    public function setSlug() {
        if (!empty($this->title)) {
            $this->attributes['slug'] = Str::slug($this->title) . '-' . $this->id;
            $this->save();
        }
    }

    /**
     * Aux Functions
     */
    private function convertStringToDouble($param) {
        if (empty($param)) {
            return null;
        }
        return str_replace(',', '.', str_replace('.', '', $param));
    }

    private function clearField(?string $param) {
        if (empty($param)) {
            return null;
        }
        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);
    }

}
