<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainerInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_informations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('container_name',400);
            $table->date('delivery_date');
            $table->double('total_items');
            $table->string('status',400);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('container_informations');
    }
}
