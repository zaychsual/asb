<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatedByLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kecamatans', function (Blueprint $table) {
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->nullable();
        });
        Schema::table('kabupatens', function (Blueprint $table) {
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->nullable();
        });
        Schema::table('provinsis', function (Blueprint $table) {
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->nullable();
        });
        Schema::table('kelurahans', function (Blueprint $table) {
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->nullable();
            $table->dropColumn('id_wilayah');
            $table->dropColumn('id_jcuim');
            $table->dropColumn('id_kemendag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kecamatans', function (Blueprint $table) {
            //
        });
    }
}
