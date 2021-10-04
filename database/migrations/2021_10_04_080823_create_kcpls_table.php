<?php

use App\Models\Bobotcpl;
use App\Models\Cpl;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\TahunAjaran;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKcplsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kcpls', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TahunAjaran::class);
            $table->foreignIdFor(Mahasiswa::class);
            $table->foreignIdFor(MataKuliah::class);
            $table->foreignIdFor(Bobotcpl::class);
            $table->foreignIdFor(Cpl::class);
            $table->string('kode_cpl');
            $table->enum('semester', ['1', '2']);
            $table->enum('kelas', ['A', 'B', 'C']);
            $table->float('nilai_cpl')->nullable()->default('0');
            $table->float('bobot_cpl')->nullable()->default('0');
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
        Schema::dropIfExists('kcpls');
    }
}
