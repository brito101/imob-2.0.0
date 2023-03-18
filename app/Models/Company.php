<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Company extends Model {

    use HasFactory;

    protected $fillable = [
        'user',
        'social_name',
        'alias_name',
        'document_company',
        'document_company_secondary',
        'zipcode',
        'street',
        'number',
        'complement',
        'neighborhood',
        'state',
        'city'
    ];

    /**
     * Relationships
     */
    public function owner() {
        return $this->hasOne(User::class, 'id', 'user');
    }

    /**
     * Accessors
     */
    public function getDocumentCompanyAttribute($value) {
        return substr($value, 0, 2) . '.' . substr($value, 2, 3) . '.' . substr($value, 5, 3) .
                '/' . substr($value, 8, 4) . '-' . substr($value, 12, 2);
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
    public function setDocumentCompanyAttribute($value) {
        $this->attributes['document_company'] = (!empty($value) ? $this->clearField($value) : null);
    }

    public function setZipcodeAttribute($value) {
        $this->attributes['zipcode'] = (!empty($value) ? $this->clearField($value) : null);
    }

    /**
     * Aux Functions
     */
    private function clearField(?string $param) {
        if (empty($param)) {
            return null;
        }
        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);
    }

}
