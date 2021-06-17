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
        return $this->belongsTo(TrackerBrowser::class, 'browser_id', 'id');
    }

    public function device()
    {
        return $this->belongsTo(TrackerDevice::class, 'device_id', 'id');
    }

    public function operatingSystem()
    {
        return $this->belongsTo(TrackerOperatingSystem::class, 'operating_system_id', 'id');
    }

    public function sessions()
    {
        return $this->hasMany(TrackerSession::class, 'cookie_id', 'id');
    }

    public function visits()
    {
        return $this->hasMany(TrackerVisit::class, 'cookie_id', 'id');
    }
}
