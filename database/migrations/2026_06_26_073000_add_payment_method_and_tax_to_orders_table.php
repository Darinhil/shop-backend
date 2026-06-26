<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('orders', 'payment_method')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('payment_method')->nullable()->after('phone');
            });
        }

        if (!Schema::hasColumn('orders', 'tax')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->decimal('tax', 10, 2)->default(0)->after('shipping_cost');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('orders', 'payment_method')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('payment_method');
            });
        }

        if (Schema::hasColumn('orders', 'tax')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('tax');
            });
        }
    }
};
