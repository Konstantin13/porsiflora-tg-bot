<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $shop_id
 * @property string $bot_token
 * @property string $chat_id
 * @property bool $enabled
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Shop $shop
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramIntegration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramIntegration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramIntegration query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramIntegration whereBotToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramIntegration whereChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramIntegration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramIntegration whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramIntegration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramIntegration whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramIntegration whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TelegramIntegration extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'shop_id',
        'bot_token',
        'chat_id',
        'enabled',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'enabled' => 'boolean',
        ];
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
