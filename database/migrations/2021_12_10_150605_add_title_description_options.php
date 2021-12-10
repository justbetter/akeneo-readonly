<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleDescriptionOptions extends Migration
{
    public function up()
    {
        Schema::table('attribute_configs', function (Blueprint $table) {
            $table->boolean('title')->default(false);
            $table->boolean('description')->default(false);
        });
    }
}
