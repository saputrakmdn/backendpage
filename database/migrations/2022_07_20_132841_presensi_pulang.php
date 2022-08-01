<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PresensiPulang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presensi_pulang', function (Blueprint $table) {
            $table->increments('id_presensi');
            $table->foreignId('id_pegawai');
            $table->date('tanggal');
            $table->time('jam_pulang');
            $table->double('latitude', 8, 6);
            $table->double('longtitude', 9, 6);
            $table->text('keterangan');
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
        //
    }
}
