<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_data', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('mobile')->length(20);
            $table->string('email')->unique();
            $table->string('source',450);
            $table->string('destination',450);
            // $table->decimal('d_latitude', 10, 8);
            // $table->decimal('d_longitude', 11, 8);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('map_data');
    }
}
