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
        Schema::create('provider_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('order_id')->nullable();
            $table->text('url');
            $table->text('method');
            $table->text('header');
            $table->text('body')->nullable();
            $table->text('disclosure')->nullable();
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
        Schema::dropIfExists('provider_logs');
    }
};
