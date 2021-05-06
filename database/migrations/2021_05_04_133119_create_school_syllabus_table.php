<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolSyllabusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_syllabus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('syllabus_id')
                ->constrained('syllabi')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('school_id')
                ->constrained('schools')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->date('completed_at')
                ->nullable()
                ->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_syllabus');
    }
}
