<?php

namespace Dawnstar\Tracker\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class TrackerBrowser
 * @package Dawnstar\Tracker\Models
 *
 * @property int $id
 * @property string $name
 * @property TrackerCookie[] $cookies
 */
class TrackerBrowser extends Model
{
    protected $table = 'tracker_browsers';
    protected $fillable = ['name'];
    public $timestamps = false;

    /**
     * @return HasMany
     */
    public function cookies(): HasMany
    {
        return $this->hasMany(TrackerCookie::class, 'browser_id', 'id');
    }
}
