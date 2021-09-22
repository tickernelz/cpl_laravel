<?php

use App\Models\Btp;
use App\Models\Cpl;
use App\Models\Cpmk;
use App\Models\MataKuliah;
use App\Models\TahunAjaran;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBobotcplsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bobotcpls', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TahunAjaran::class);
            $table->foreignIdFor(MataKuliah::class);
            $table->foreignIdFor(Cpl::class);
            $table->foreignIdFor(Cpmk::class);
            $table->foreignIdFor(Btp::class);
            $table->enum('semester', ['1', '2']);
            $table->integer('bobot_cpl');
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
        Schema::dropIfExists('bobotcpls');
    }
}
