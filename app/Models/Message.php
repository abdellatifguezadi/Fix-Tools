<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'content',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        // 'updated_at' => 'datetime',
        // 'deleted_at' => 'datetime'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id')->withDefault([
            'name' => 'Deleted User',
            'id' => null
        ]);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id')->withDefault([
            'name' => 'Deleted User',
            'id' => null
        ]);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
