<?php

use App\Models\Cpmk;
use App\Models\DosenAdmin;
use App\Models\MataKuliah;
use App\Models\TahunAjaran;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBtpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('btps', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TahunAjaran::class);
            $table->foreignIdFor(MataKuliah::class);
            $table->foreignIdFor(Cpmk::class);
            $table->foreignIdFor(DosenAdmin::class);
            $table->string('nama');
            $table->enum('semester', ['1', '2']);
            $table->enum('kelas', ['A', 'B', 'C']);
            $table->integer('kategori');
            $table->float('bobot');
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
        Schema::dropIfExists('btps');
    }
}
