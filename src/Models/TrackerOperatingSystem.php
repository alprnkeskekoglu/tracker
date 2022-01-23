<?php

namespace Dawnstar\Tracker\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class TrackerOperatingSystem
 * @package Dawnstar\Tracker\Models
 *
 * @property int $id
 * @property string $name
 * @property TrackerCookie[] $cookies
 */
class TrackerOperatingSystem extends Model
{
    protected $table = 'tracker_operating_systems';
    protected $fillable = ['name'];
    public $timestamps = false;

    /**
     * @return HasMany
     */
    public function cookies(): HasMany
    {
        return $this->hasMany(TrackerCookie::class, 'operating_system_id', 'id');
    }
}
