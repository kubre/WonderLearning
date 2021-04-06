<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('photo')->default(null)->nullable();
            $table->date('dob_at');
            $table->char('gender', 11);
            $table->unsignedMediumInteger('code');
            $table->string('father_name')->default(null)->nullable();
            $table->char('father_contact', 10)->default(null)->nullable();
            $table->string('father_occupation')->default(null)->nullable();
            $table->string('father_email')->default(null)->nullable();
            $table->string('father_organization_name')->default(null)->nullable();
            $table->string('mother_name')->default(null)->nullable();
            $table->char('mother_contact', 10)->default(null)->nullable();
            $table->string('mother_occupation')->default(null)->nullable();
            $table->string('mother_email')->default(null)->nullable();
            $table->string('mother_organization_name')->default(null)->nullable();
            $table->string('previous_school')->default(null)->nullable();
            $table->json('siblings')->default(null)->nullable();
            $table->string('address');
            $table->string('city')->default(null)->nullable();
            $table->string('state')->default(null)->nullable();
            $table->char('postal_code', 6)->default(null)->nullable();
            $table->string('nationality')->default(null)->nullable();
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
        Schema::dropIfExists('students');
    }
}
