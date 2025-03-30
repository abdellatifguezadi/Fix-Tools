<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('specialty')->nullable()->after('phone');
            $table->integer('experience')->nullable()->after('specialty');
            $table->decimal('hourly_rate', 8, 2)->nullable()->after('experience');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['specialty', 'experience', 'hourly_rate']);
        });
    }
}; 