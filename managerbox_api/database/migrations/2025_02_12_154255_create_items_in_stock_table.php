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
        Schema::create('items_in_stock', function (Blueprint $table) {
            $table->id();
            $table->string('sku_code', 20)->unique();
            $table->string('barcode', 50)->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->char('unity_type');
            $table->decimal('current_quantity', 12, 2);
            $table->decimal('maximum_quantity', 12, 2)->nullable();
            $table->decimal('cost_price', 12, 2)->nullable();
            $table->decimal('sell_price', 12, 2)->nullable();
            $table->string('picture')->nullable();
            $table->text('location')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('company_id')->constrained('companies', 'id')
            ->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
            $table->index([
                'sku_code',
                'barcode',
                'name',
                'unity_type'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_in_stocks');
    }
};
