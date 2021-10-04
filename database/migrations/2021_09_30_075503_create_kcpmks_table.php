<?php

use App\Models\Btp;
use App\Models\Cpmk;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\TahunAjaran;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKcpmksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kcpmks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TahunAjaran::class);
            $table->foreignIdFor(Btp::class);
            $table->foreignIdFor(Mahasiswa::class);
            $table->foreignIdFor(MataKuliah::class);
            $table->foreignIdFor(Cpmk::class);
            $table->string('kode_cpmk');
            $table->enum('semester', ['1', '2']);
            $table->enum('kelas', ['A', 'B', 'C']);
            $table->float('nilai_kcpmk')->nullable()->default('0');
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
        Schema::dropIfExists('kcpmks');
    }
}
