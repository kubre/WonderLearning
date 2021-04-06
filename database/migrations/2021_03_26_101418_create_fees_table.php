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
            $table->json('playgroup')->default(null)->nullable();
            $table->unsignedInteger('playgroup_total')->default(null)->nullable();
            $table->json('nursery')->default(null)->nullable();
            $table->unsignedInteger('nursery_total')->default(null)->nullable();
            $table->json('junior_kg')->default(null)->nullable();
            $table->unsignedInteger('junior_kg_total')->default(null)->nullable();
            $table->json('senior_kg')->default(null)->nullable();
            $table->unsignedInteger('senior_kg_total')->default(null)->nullable();
            $table->foreignId('school_id')
                ->index()
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
