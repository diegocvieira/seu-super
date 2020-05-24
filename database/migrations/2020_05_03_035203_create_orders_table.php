<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('status');
            $table->string('code', 20)->unique();
            $table->unsignedBigInteger('market_id');
            $table->foreign('market_id')->references('id')->on('markets')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('payment', 50);
            $table->decimal('money_change', 8, 2)->nullable();
            $table->decimal('freight_price', 8, 2);
            $table->decimal('separation_price', 8, 2);
            $table->string('instructions', 1000)->nullable();
            $table->date('delivery_date');
            $table->string('delivery_hour', 50);
            $table->char('cep', 8);
            $table->string('district', 50);
            $table->string('street', 150);
            $table->string('number', 20);
            $table->string('complement', 200)->nullable();
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
        Schema::dropIfExists('orders');
    }
}
