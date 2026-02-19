<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @property-read \App\Models\TelegramIntegration|null $telegramIntegration
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TelegramSendLog> $telegramSendLogs
 * @property-read int|null $telegram_send_logs_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereName($value)
 * @mixin \Eloquent
 */
class Shop extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
    ];

    public function telegramIntegration(): HasOne
    {
        return $this->hasOne(TelegramIntegration::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function telegramSendLogs(): HasMany
    {
        return $this->hasMany(TelegramSendLog::class);
    }
}
