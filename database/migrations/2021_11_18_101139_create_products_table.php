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

            $table->string('identifier');
            $table->string('type')->default('simple');
            $table->boolean('enabled')->default(false);
            $table->string('family')->nullable();
            $table->json('categories')->nullable();
            $table->json('groups')->nullable();
            $table->string('parent')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
