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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('street', 255);
            $table->char('building_number', 5);
            $table->text('complement')->nullable();
            $table->string('city', 255);
            $table->char('state', 2);
            $table->char('zipcode', 8);
            $table->char('country', 2)->comment('ISO 3166-1');
            $table->morphs('addressable');
            $table->index([
                'country',
                'state',
                'city'
            ]);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
