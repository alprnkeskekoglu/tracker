<?php

namespace Dawnstar\Tracker\Models;

use Dawnstar\Tracker\Enums\TrackerEnum;
use Illuminate\Contracts\Broadcasting\HasBroadcastChannel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class TrackerDevice
 * @package Dawnstar\Tracker\Models
 *
 * @property int $id
 * @property string $name
 * @property TrackerCookie[] $cookies
 */
class TrackerDevice extends Model
{
    protected $table = 'tracker_devices';
    protected $fillable = ['name'];
    public $timestamps = false;

    /**
     * @return HasMany
     */
    public function cookies(): HasMany
    {
        return $this->hasMany(TrackerCookie::class, 'device_id', 'id');
    }

    /**
     * @return bool
     */
    public function isRobot(): bool
    {
       return $this->name === TrackerEnum::ROBOT;
    }
}
