<?php

namespace Dawnstar\Tracker\Models;

use Illuminate\Database\Eloquent\Model;

class TrackerBrowser extends Model
{
    protected $table = 'tracker_browsers';
    protected $fillable = ['name'];
    public $timestamps = false;

    public function cookies()
    {
        return $this->hasMany(TrackerCookie::class, 'browser_id', 'id');
    }
}
