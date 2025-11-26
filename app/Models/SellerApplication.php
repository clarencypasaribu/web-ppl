<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SellerApplication extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'store_name',
        'owner_name',
        'email',
        'phone',
        'address',
        'city',
        'province',
        'postal_code',
        'product_category',
        'product_description',
        'business_license_number',
        'tax_id_number',
        'bank_account_name',
        'bank_account_number',
        'bank_name',
        'status',
        'verification_notes',
        'verified_at',
        'activation_token',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $application) {
            $application->status ??= self::STATUS_PENDING;
        });
    }
}
