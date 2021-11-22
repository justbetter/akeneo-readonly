<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AttributeConfigSortOrder extends Migration
{
    public function up()
    {
        Schema::table('attribute_configs', function (Blueprint $table) {

            $table->integer('sort')->default(0);

        });
    }
}
