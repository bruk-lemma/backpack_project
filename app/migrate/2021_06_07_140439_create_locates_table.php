<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
           // $table->id();
            //$table->timestamps();
           // $table->string('address-input')->nullable();
           // $table->string('name');
            $table->json('address-input')->nullable();
            //$table->double('address_latitude')->nullable();
            //$table->double('address_longitude')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locates');
    }
}
