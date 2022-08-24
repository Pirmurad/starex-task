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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('tracking_code',50)->unique()->index();
            $table->double('shipping_price', 15, 2)->index();
            $table->double('price', 15, 2)->index();
            $table->string('category');
            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->string('email',50);
            $table->string('phone_number',20);
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
        Schema::dropIfExists('packages');
    }
};
