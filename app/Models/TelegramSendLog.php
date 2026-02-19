<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
