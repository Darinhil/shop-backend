<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('description')->nullable()->after('image');
            $table->integer('stock')->default(0)->after('description');
            $table->boolean('featured')->default(false)->after('stock');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['description', 'stock', 'featured']);
        });
    }
};
