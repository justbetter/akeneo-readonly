<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPreferredLocale extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('preferred_locale')->nullable();
        });
    }
}
