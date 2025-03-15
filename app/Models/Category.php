<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'description',
        'icon'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relations
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function professionals()
    {
        return $this->hasMany(User::class, 'profession_category_id');
    }

    // Scopes
    public function scopeServiceCategories($query)
    {
        return $query->where('type', 'service');
    }

    public function scopeMaterialCategories($query)
    {
        return $query->where('type', 'material');
    }
}
