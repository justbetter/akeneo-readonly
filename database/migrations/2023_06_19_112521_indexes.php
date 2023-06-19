<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('attribute_configs', function (Blueprint $table) {
            $table->index('code');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->index('identifier');
        });

        Schema::table('attributes', function (Blueprint $table) {
            $table->index('product_id');
            $table->index('code');
        });

    }

    public function down(): void
    {
        Schema::table('attribute_configs', function (Blueprint $table) {
            $table->dropIndex('code');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('identifier');
        });

        Schema::table('attributes', function (Blueprint $table) {
            $table->dropIndex('product_id');
            $table->dropIndex('code');
        });
    }
};
