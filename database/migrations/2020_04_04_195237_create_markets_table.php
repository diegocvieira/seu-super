<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('markets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->string('logo_image', 25);
            $table->string('cover_image_desktop', 255);
            $table->string('cover_image_mobile', 255);
            $table->boolean('orders_status')->default(1);
            $table->string('telephone', 15)->nullable();
            $table->char('cep', 8);
            $table->string('district', 50);
            $table->string('street', 150);
            $table->string('number', 20);
            $table->string('complement', 200)->nullable();
            $table->decimal('free_shipping_from', 8, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('markets');
    }
}
