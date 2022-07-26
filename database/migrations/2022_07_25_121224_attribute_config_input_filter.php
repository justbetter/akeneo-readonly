<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AttributeConfigInputFilter extends Migration
{
    public function up()
    {
        Schema::table('attribute_configs', function (Blueprint $table) {
            $table->json('import_filter')->after('grid');
        });
    }

    public function down()
    {
        Schema::dropColumns('attribute_configs', ['import_filter']);
    }
}
