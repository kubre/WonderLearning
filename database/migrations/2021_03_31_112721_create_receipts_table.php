<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('receipt_no');
            $table->string('amount');
            $table->date('receipt_at')
                ->default(null)
                ->nullable();
            $table->char('for', 20);
            $table->char('payment_mode', 1);
            $table->string('bank_name')
                ->default(null)
                ->nullable();
            $table->string('bank_branch')
                ->default(null)
                ->nullable();
            $table->string('transaction_no')
                ->default(null)
                ->nullable();
            $table->date('paid_at')
                ->default(null)
                ->nullable();
            $table->foreignId('admission_id')
                ->nullable()
                ->default(null)
                ->onDelete('cascade')
                ->constrained();
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
        Schema::dropIfExists('receipts');
    }
}
