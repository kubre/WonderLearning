<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->date('admission_at');
            $table->char('program', 9);
            $table->unsignedTinyInteger('fees_installments');
            $table->unsignedInteger('discount')->default(null)->nullable();
            $table->char('batch', 7);
            $table->boolean('is_transportation_required');
            $table->foreignId('student_id')
                ->nullable()
                ->default(null)
                ->constrained()
                ->onDelete('SET NULL');
            $table->foreignId('school_id')
                ->nullable()
                ->constrained()
                ->onDelete('SET NULL');
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
        Schema::dropIfExists('admissions');
    }
}
