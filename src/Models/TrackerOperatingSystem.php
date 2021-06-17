<?php

namespace Dawnstar\Tracker\Models;

use Illuminate\Database\Eloquent\Model;

class TrackerOperatingSystem extends Model
{
    protected $table = 'tracker_operating_systems';
    protected $fillable = ['name'];
    public $timestamps = false;

    public function cookies()
    {
        return $this->hasMany(TrackerCookie::class);
    }
}
