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
            $table->foreignId('provinsi_id');
            $table->foreignId('kota_id');
            $table->foreignId('kecamatan_id');
            $table->foreignId('desa_id');
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
