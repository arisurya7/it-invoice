<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nomor_invoice')->nullable();
            $table->foreignId('project_id');
            $table->text('perihal');
            $table->integer('total');
            $table->string('termin');
            $table->string('metode_pembayaran');
            $table->string('bank');
            $table->string('no_rekening');
            $table->string('cabang_bank');
            $table->string('penerima');
            $table->string('status');
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
        Schema::dropIfExists('invoices');
    }
}
