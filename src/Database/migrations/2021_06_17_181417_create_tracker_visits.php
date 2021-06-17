<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackerVisits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracker_visits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cookie_id')->index('cookie_id');
            $table->unsignedBigInteger('session_id')->index('session_id');
            $table->unsignedBigInteger('url_id')->index('url_id')->nullable();
            $table->string('url_string');
            $table->string('ip');
            $table->tinyInteger('hour')->nullable();
            $table->tinyInteger('week')->nullable();
            $table->text('query_string')->nullable();
            $table->text('referer')->nullable();
            $table->text('utm')->nullable();
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
        Schema::dropIfExists('tracker_visits');
    }
}
