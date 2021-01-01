<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultipleJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multiple_journals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('company_id')->unsigned();
            $table->bigInteger('journal_id')->unsigned();
            $table->integer('multiple_journal_index');
            $table->date('deal_date');
            $table->string('debit_account_key')->nullable();
            $table->string('debit_sub_account_key')->nullable();
            $table->integer('debit_amount');
            $table->string('credit_account_key')->nullable();
            $table->string('credit_sub_account_key')->nullable();
            $table->integer('credit_amount');
            $table->string('remark')->nullable();
            $table->timestamps();
            $table->foreign('journal_id')
            ->references('id')->on('journals')
            ->onDelete('cascade');
            $table->foreign('company_id')
            ->references('id')->on('companies')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('multiple_journals');
    }
}
