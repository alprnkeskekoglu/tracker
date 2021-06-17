<?php

namespace Dawnstar\Tracker\Models;

use Illuminate\Database\Eloquent\Model;

class TrackerCookie extends Model
{
    protected $table = 'tracker_cookies';
    protected $guarded = ['id'];
    public $timestamps = ['created_at'];
    const UPDATED_AT = null;

    public function browser()
    {
        return $this->belongsTo(TrackerBrowser::class);
    }

    public function device()
    {
        return $this->belongsTo(TrackerDevice::class);
    }

    public function operatingSystem()
    {
        return $this->belongsTo(TrackerOperatingSystem::class);
    }

    public function sessions()
    {
        return $this->hasMany(TrackerSession::class);
    }

    public function visits()
    {
        return $this->hasMany(TrackerVisit::class);
    }
}
