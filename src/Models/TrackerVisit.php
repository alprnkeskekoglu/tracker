<?php

namespace Dawnstar\Tracker\Models;

use Carbon\Carbon;
use Dawnstar\Core\Models\Url;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class TrackerVisit
 * @package Dawnstar\Tracker\Models
 *
 * @property int $id
 * @property int $cookie_id
 * @property int $session_id
 * @property int $url_id
 * @property string $ip
 * @property int $hour
 * @property int $week
 * @property string $query_string
 * @property string $referer
 * @property string $utm
 * @property Carbon|null $created_at
 * @property TrackerCookie $cookie
 * @property TrackerSession $session
 * @property Url $url
 */
class TrackerVisit extends Model
{
    protected $table = 'tracker_visits';
    protected $guarded = ['id'];
    public $timestamps = ['created_at'];
    const UPDATED_AT = null;

    /**
     * @return BelongsTo
     */
    public function cookie(): belongsTo
    {
        return $this->belongsTo(TrackerCookie::class, 'cookie_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function session(): belongsTo
    {
        return $this->belongsTo(TrackerSession::class, 'session_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function url(): belongsTo
    {
        return $this->belongsTo(Url::class);
    }
}
