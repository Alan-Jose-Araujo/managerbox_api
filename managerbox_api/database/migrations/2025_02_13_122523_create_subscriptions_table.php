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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->char('status', 20);
            $table->date('start_date');
            $table->date('end_date');
            $table->char('duration', 20);
            $table->timestamp('payment_date')->nullable();
            $table->foreignId('company_id')->constrained('companies', 'id')
            ->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('plan_id')->constrained('plans', 'id')
                ->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
            $table->index([
                'status',
                'duration',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
