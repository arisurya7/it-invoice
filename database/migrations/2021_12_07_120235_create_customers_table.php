<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_customer');
            $table->string('telp');
            $table->string('email');
            $table->foreignId('id_provinsi')->unsigned();
            $table->foreignId('id_kota')->unsigned();
            $table->foreignId('id_kecamatan')->unsigned();
            $table->string('kodepos');
            $table->string('alamat');
            $table->timestamps();
        });

        Schema::table('projects', function(Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });

        Schema::table('customers', function(Blueprint $table) {
            $table->foreign('id_provinsi')->references('id')->on('provinsis');
            $table->foreign('id_kota')->references('id')->on('kotas');
            $table->foreign('id_kecamatan')->references('id')->on('kecamatans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
