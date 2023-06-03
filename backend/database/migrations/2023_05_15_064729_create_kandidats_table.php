<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKandidatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kandidats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pemilihan_id');
            $table->string('NIS_ketua')->unique();
            $table->string('NIS_wakil')->unique();
            $table->string('foto_kandidat');
            $table->string('nama_pasangan');
            $table->string('nama_ketua');
            $table->string('nama_wakil');
            $table->string('kelas_ketua');
            $table->string('kelas_wakil');
            $table->string('jurusan_ketua');
            $table->string('jurusan_wakil');
            $table->string('visi');
            $table->string('misi');
            $table->string('program_kerja');
            $table->integer('jumlah_suara')->default(0);


            $table->foreign('pemilihan_id')->references('id')->on('pemilihans')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('kandidats');
    }
}
