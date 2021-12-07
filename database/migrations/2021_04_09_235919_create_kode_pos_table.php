<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKodePosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kode_pos', function (Blueprint $table) {
            $table->id();
            $table->integer('provinsi_id');
            $table->integer('kota_id');
            $table->integer('kecamatan_id');
            $table->integer('desa_id');
            // $table->string('kode')->unique();
            $table->string('kode');
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
        Schema::dropIfExists('kode_pos');
    }
}
