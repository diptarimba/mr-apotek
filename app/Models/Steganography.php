<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Steganography extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'encrypted_image',
        'created_by'
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
