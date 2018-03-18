<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsNsfwIsIsPrivateToImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('image', function (Blueprint $table) {
            $table->boolean('is_nsfw')->default(0);
            $table->boolean('is_private')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('image', function (Blueprint $table) {
            $table->dropColumn('is_nsfw');
            $table->dropColumn('is_private');
        });
    }
}
