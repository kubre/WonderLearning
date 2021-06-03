<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformanceReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performance_reports', function (Blueprint $table) {
            $table->foreignId('admission_id')
                ->constrained('admissions')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('division_id')
                ->index()
                ->constrained('divisions')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->json('performance');
            $table->timestamp('date_at');
            $table->timestamp('approved_at')
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
        Schema::dropIfExists('performance_reports');
    }
}
