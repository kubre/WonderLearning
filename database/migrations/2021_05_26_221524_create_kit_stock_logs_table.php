<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKitStockLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kit_stock_logs', function (Blueprint $table) {
            $table->foreignId('kit_stock_id')
                ->constrained('kit_stocks')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->char('program', 9);
            $table->unsignedInteger('quantity');
            $table->timestamp('added_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kit_stock_logs');
    }
}
