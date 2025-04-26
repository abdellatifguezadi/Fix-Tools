<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'professional_id',
        'service_request_id',
        'rating',
        'comment',
        'is_approved'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id')->withDefault([
            'name' => 'Deleted User',
            'id' => null
        ]);
    }

    public function professional()
    {
        return $this->belongsTo(User::class, 'professional_id')->withDefault([
            'name' => 'Deleted User',
            'id' => null
        ]);
    }

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }

 
}
