<?php

namespace Dawnstar\Tracker\Models;

use Illuminate\Database\Eloquent\Model;

class TrackerDevice extends Model
{
    protected $table = 'tracker_devices';
    protected $fillable = ['name'];
    public $timestamps = false;

    public function cookies()
    {
        return $this->hasMany(TrackerCookie::class, 'device_id', 'id');
    }
}
