<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->decimal('price');
            $table->string('images');
            $table->unsignedBigInteger('storeId');
            $table->string('categoryId');
            $table->timestamps();

            $table->foreign('storeId')->references('id')->on('stores');
            $table->foreign('categoryId')->references('slug')->on('categories');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
