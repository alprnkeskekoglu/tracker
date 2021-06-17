<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackerCookies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracker_cookies', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->unsignedInteger('device_id');
            $table->unsignedInteger('operating_system_id');
            $table->unsignedInteger('browser_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracker_cookies');
    }
}
