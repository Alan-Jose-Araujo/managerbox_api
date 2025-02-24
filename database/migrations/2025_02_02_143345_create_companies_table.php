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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('fantasy_name', 255);
            $table->string('corporate_reason', 255);
            $table->string('email', 255)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->char('cnpj', 14)->unique();
            $table->char('state_registration', 9)->unique();
            $table->string('logo_image_path', 255)->nullable();
            $table->date('foundation_date')->nullable();
            $table->char('landline', 8)->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('timezone', 150)->nullable(); // TODO: Remove nullable, its just for tests.
            $table->char('currency_code', 3)->nullable(); // TODO: Remove nullable, its just for tests.
            $table->integer('currency_decimal_places')->default(2);
            $table->unsignedBigInteger('metier_id')->default(1)->change();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('users', function(Blueprint $table) {
            $table->foreignId('company_id')->after('is_active')
                ->nullable()->constrained('companies', 'id')
            ->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
