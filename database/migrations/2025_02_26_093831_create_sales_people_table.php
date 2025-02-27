<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_persons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('nama')->nullable();
            $table->string('no_hp')->nullable();
            $table->unsignedInteger('provinsi_id')->nullable();
            $table->unsignedInteger('kabupaten_id')->nullable();
            $table->unsignedInteger('kecamatan_id')->nullable();
            $table->unsignedInteger('kelurahan_id')->nullable();
            $table->string('nama_provinsi')->nullable();
            $table->string('nama_kabupaten')->nullable();
            $table->string('nama_kecamatan')->nullable();
            $table->string('nama_kelurahan')->nullable();
            $table->text('alamat')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->tinyInteger('soft_delete')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_persons');
    }
}
