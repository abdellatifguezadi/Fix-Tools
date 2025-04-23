<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('material_purchases', function (Blueprint $table) {
            $table->string('transaction_id')->nullable()->after('status');
            $table->string('delivery_address')->nullable()->after('transaction_id');
            $table->string('delivery_phone')->nullable()->after('delivery_address');
            $table->string('delivery_city')->nullable()->after('delivery_phone');
            $table->string('delivery_postal_code')->nullable()->after('delivery_city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('material_purchases', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
            $table->dropColumn('delivery_address');
            $table->dropColumn('delivery_phone');
            $table->dropColumn('delivery_city');
            $table->dropColumn('delivery_postal_code');
        });
    }
}; 