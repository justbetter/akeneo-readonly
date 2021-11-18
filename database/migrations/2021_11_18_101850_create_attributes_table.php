<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributesTable extends Migration
{
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Product::class);

            $table->string('code');
            $table->string('type');
            $table->string('group');
            $table->json('value');
        });
    }

    public function down()
    {
        Schema::dropIfExists('attributes');
    }
}
