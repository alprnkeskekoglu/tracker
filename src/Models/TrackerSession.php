<?php

namespace Dawnstar\Tracker\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class TrackerSession
 * @package Dawnstar\Tracker\Models
 *
 * @property int $id
 * @property int $cookie_id
 * @property string $key
 * @property Carbon|null $created_at
 * @property TrackerCookie $cookie
 * @property TrackerVisit[] visits
 */
class TrackerSession extends Model
{
    protected $table = 'tracker_sessions';
    protected $guarded = ['id'];
    public $timestamps = ['created_at'];
    const UPDATED_AT = null;

    /**
     * @return BelongsTo
     */
    public function cookie(): belongsTo
    {
        return $this->belongsTo(TrackerCookie::class, 'session_id', ',d');
    }

    /**
     * @return HasMany
     */
    public function visits(): hasMany
    {
        return $this->hasMany(TrackerVisit::class, 'session_id', 'id');
    }
}
