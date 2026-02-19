<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $shop_id
 * @property string $number
 * @property numeric $total
 * @property string $customer_name
 * @property \Carbon\CarbonImmutable $created_at
 * @property-read \App\Models\Shop $shop
 * @property-read \App\Models\TelegramSendLog|null $telegramSendLog
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTotal($value)
 *
 * @mixin \Eloquent
 */
class Order extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'shop_id',
        'number',
        'total',
        'customer_name',
        'created_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
            'created_at' => 'datetime',
        ];
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function telegramSendLog(): HasOne
    {
        return $this->hasOne(TelegramSendLog::class);
    }
}
