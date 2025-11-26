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
        Schema::create('seller_applications', function (Blueprint $table) {
            $table->id();
            $table->string('store_name');
            $table->string('owner_name');
            $table->string('email');
            $table->string('phone', 30);
            $table->text('address');
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('product_category');
            $table->text('product_description')->nullable();
            $table->string('business_license_number')->nullable();
            $table->string('tax_id_number')->nullable();
            $table->string('bank_account_name');
            $table->string('bank_account_number', 50);
            $table->string('bank_name');
            $table->string('status')->default('pending');
            $table->text('verification_notes')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->string('activation_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_applications');
    }
};
