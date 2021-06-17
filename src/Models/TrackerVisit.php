<?php

namespace Dawnstar\Tracker\Models;

use Dawnstar\Models\Url;
use Illuminate\Database\Eloquent\Model;

class TrackerVisit extends Model
{
    protected $table = 'tracker_visits';
    protected $guarded = ['id'];
    public $timestamps = ['created_at'];
    const UPDATED_AT = null;

    public function cookie()
    {
        return $this->belongsTo(TrackerCookie::class);
    }

    public function session()
    {
        return $this->belongsTo(TrackerSession::class);
    }

    public function url()
    {
        return $this->belongsTo(Url::class);
    }
}
