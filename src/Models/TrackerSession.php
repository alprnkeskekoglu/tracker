<?php

namespace Dawnstar\Tracker\Models;

use Illuminate\Database\Eloquent\Model;

class TrackerSession extends Model
{
    protected $table = 'tracker_sessions';
    protected $guarded = ['id'];
    public $timestamps = ['created_at'];
    const UPDATED_AT = null;

    public function cookie()
    {
        return $this->belongsTo(TrackerCookie::class);
    }

    public function visits()
    {
        return $this->hasMany(TrackerVisit::class);
    }
}
