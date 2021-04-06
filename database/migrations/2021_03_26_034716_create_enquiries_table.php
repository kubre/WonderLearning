<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->char('gender', 11);
            $table->date('dob_at');
            $table->char('program', 9);
            $table->string('enquirer_name');
            $table->string('enquirer_email');
            $table->char('enquirer_contact', 10);
            $table->string('locality');
            $table->string('reference');
            $table->date('follow_up_at');
            $table->foreignId('student_id')
                ->nullable()
                ->default(null)
                ->onDelete('cascade')
                ->constrained();
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
        Schema::dropIfExists('enquiries');
    }
}
