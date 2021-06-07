<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeKitStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kit_stocks', function (Blueprint $table) {
            $table->unsignedInteger('playgroup_total')->default(0)->change();
            $table->unsignedInteger('nursery_total')->default(0)->change();
            $table->unsignedInteger('junior_kg_total')->default(0)->change();
            $table->unsignedInteger('senior_kg_total')->default(0)->change();
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
