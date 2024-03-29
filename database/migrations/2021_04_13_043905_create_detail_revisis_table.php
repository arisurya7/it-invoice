<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailRevisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_revisis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('revisi_id')->constrained('revisis')->onUpdate('cascade')->onDelete('cascade');
            $table->text('deskripsi');
            $table->string('ammount');
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
        Schema::dropIfExists('detail_revisis');
    }
}
