<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeConfigsTable extends Migration
{
    public function up()
    {
        Schema::create('attribute_configs', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->json('data');

            $table->boolean('visible')->default(false);
            $table->boolean('grid')->default(false);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attribute_configs');
    }
}
