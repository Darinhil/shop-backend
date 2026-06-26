<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('full_name')->after('user_id');
            $table->string('email')->after('full_name');
            $table->string('phone')->after('email');
            $table->string('address')->after('phone');
            $table->string('city')->after('address');
            $table->string('state')->after('city');
            $table->string('postal_code')->after('state');
            $table->string('country')->after('postal_code');
            $table->text('notes')->nullable()->after('country');
            $table->decimal('shipping_cost', 10, 2)->default(0)->after('notes');
            $table->decimal('subtotal', 10, 2)->after('shipping_cost');
            $table->renameColumn('total', 'total_amount');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'full_name', 'email', 'phone', 'address', 
                'city', 'state', 'postal_code', 'country', 
                'notes', 'shipping_cost', 'subtotal'
            ]);
            $table->renameColumn('total_amount', 'total');
        });
    }
};
