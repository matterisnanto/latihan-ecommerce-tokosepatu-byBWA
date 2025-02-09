<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductTransaction extends Model
{
    //
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = ['name', 'phone', 'email', 'booking_trx_id', 'city', 'post_code', 'proof', 'shoe_size', 'address', 'quantity', 'sub_total_amount', 'grand_total_amount', 'discount_amount', 'is_paid', 'shoe_id', 'promo_code_id'];
    
    public static function generateUniqueTrxId()
    {
        $prefix = 'ss';
        do {
            $randomSring = $prefix . mt_rand(1000, 9999);
        } while (self::where('booking_trx_id', $randomSring)->exists());

        return $randomSring;

    }
    public function shoes(): HasMany
    {
        return $this->hasMany(Shoe::class);
    }

    public function promoCode(): HasMany
    {
        return $this->hasMany(PromoCode::class);
    }
}
