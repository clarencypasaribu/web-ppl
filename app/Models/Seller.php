<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'store_name',
        'short_description',
        'pic_name',
        'pic_phone',
        'pic_email',
        'street_address',
        'rt',
        'rw',
        'ward_name',
        'city',
        'province',
        'pic_identity_number',
        'pic_identity_photo_path',
        'pic_profile_photo_path',
        'status',
        'verification_notes',
        'verified_at',
        'password',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $hidden = [
        'password',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
