<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Ramsey\Uuid\Uuid;

class FileInfo extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function (FileInfo $model) {
            $model->setAttribute($model->getKeyName(), Uuid::uuid4());
        });
    }

    public function children(): HasMany
    {
        return $this->hasMany(FileInfo::class, 'file_info_id', 'id');
    }

    public function parent(): HasOne
    {
        return $this->hasOne(FileInfo::class, 'id', 'file_info_id');
    }
}

