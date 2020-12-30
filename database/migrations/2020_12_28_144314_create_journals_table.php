<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('company_id')->unsigned();
            $table->date('deal_date');
            $table->string('debit_account_key');
            $table->string('debit_sub_account_key')->nullable();
            $table->integer('debit_amount');
            $table->string('credit_account_key');
            $table->string('credit_sub_account_key')->nullable();
            $table->integer('credit_amount');
            $table->string('remark')->nullable();
            $table->boolean('is_multiple_journal');
            $table->timestamps();
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
        Schema::dropIfExists('journals');
    }
}
