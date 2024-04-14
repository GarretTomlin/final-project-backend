<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->string('orderId');
            $table->unsignedBigInteger('productId');
            $table->unsignedBigInteger('storeId');
            $table->timestamps();

            $table->foreign('orderId')->references('id')->on('orders');
            $table->foreign('productId')->references('id')->on('products');
            $table->foreign('storeId')->references('id')->on('stores');
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}

