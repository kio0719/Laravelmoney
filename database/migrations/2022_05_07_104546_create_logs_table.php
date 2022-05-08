<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->Bigincrements('log_id');
            $table->integer('member_id');
            $table->dateTime('use_date');
            $table->dateTime('withdrawl_date');
            $table->integer('account_id');
            $table->integer('Asset_id');
            $table->integer('amount');
            $table->string('log_note');
            $table->integer('account_balance');
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
        Schema::dropIfExists('logs');
    }
};
