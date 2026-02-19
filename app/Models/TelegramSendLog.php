<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $shop_id
 * @property int $order_id
 * @property string $message
 * @property string $status
 * @property string|null $error
 * @property \Carbon\CarbonImmutable $sent_at
 * @property-read \App\Models\Order $order
 * @property-read \App\Models\Shop $shop
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramSendLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramSendLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramSendLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramSendLog whereError($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramSendLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramSendLog whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramSendLog whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramSendLog whereSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramSendLog whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramSendLog whereStatus($value)
 * @mixin \Eloquent
 */
class TelegramSendLog extends Model
{
    use HasFactory;

    protected $table = 'telegram_send_log';

    public const CREATED_AT = null;
    public const UPDATED_AT = null;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'shop_id',
        'order_id',
        'message',
        'status',
        'error',
        'sent_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
        ];
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
