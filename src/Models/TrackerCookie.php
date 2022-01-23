<?php

namespace Dawnstar\Tracker\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class TrackerCookie
 * @package Dawnstar\Tracker\Models
 *
 * @property int $id
 * @property string $key
 * @property int $device_id
 * @property int $operating_system_id
 * @property int $browser_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property TrackerBrowser $browser
 * @property TrackerDevice $device
 * @property TrackerOperatingSystem $operatingSystem
 * @property TrackerSession[] $sessions
 * @property TrackerVisit[] $visits
 */
class TrackerCookie extends Model
{
    protected $table = 'tracker_cookies';
    protected $guarded = ['id'];
    public $timestamps = ['created_at'];
    const UPDATED_AT = null;

    /**
     * @return BelongsTo
     */
    public function browser(): belongsTo
    {
        return $this->belongsTo(TrackerBrowser::class, 'browser_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function device(): belongsTo
    {
        return $this->belongsTo(TrackerDevice::class, 'device_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function operatingSystem(): belongsTo
    {
        return $this->belongsTo(TrackerOperatingSystem::class, 'operating_system_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(TrackerSession::class, 'cookie_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function visits(): HasMany
    {
        return $this->hasMany(TrackerVisit::class, 'cookie_id', 'id');
    }
}
