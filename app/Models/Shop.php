<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
