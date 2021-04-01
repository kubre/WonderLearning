<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->json('playgroup');
            $table->unsignedInteger('playgroup_total');
            $table->json('nursery');
            $table->unsignedInteger('nursery_total');
            $table->json('junior_kg');
            $table->unsignedInteger('junior_kg_total');
            $table->json('senior_kg');
            $table->unsignedInteger('senior_kg_total');
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
        Schema::dropIfExists('fees');
    }
}
