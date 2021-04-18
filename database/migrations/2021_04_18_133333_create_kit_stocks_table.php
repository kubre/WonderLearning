<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKitStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kit_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedMediumInteger('playgroup_total');
            $table->unsignedMediumInteger('playgroup_assigned')->default(0);
            $table->unsignedMediumInteger('nursery_total');
            $table->unsignedMediumInteger('nursery_assigned')->default(0);
            $table->unsignedMediumInteger('junior_kg_total');
            $table->unsignedMediumInteger('junior_kg_assigned')->default(0);
            $table->unsignedMediumInteger('senior_kg_total');
            $table->unsignedMediumInteger('senior_kg_assigned')->default(0);
            $table->foreignId('school_id')
                ->nullable()
                ->default(null)
                ->onDelete('cascade')
                ->constrained();
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
        Schema::dropIfExists('kit_stocks');
    }
}
