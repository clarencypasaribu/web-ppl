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
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->string('store_name');
            $table->text('short_description')->nullable();
            $table->string('pic_name');
            $table->string('pic_phone', 20);
            $table->string('pic_email');
            $table->text('street_address');
            $table->string('rt', 10);
            $table->string('rw', 10);
            $table->string('ward_name'); // kelurahan
            $table->string('city');
            $table->string('province');
            $table->string('pic_identity_number', 32);
            $table->string('pic_identity_photo_path')->nullable();
            $table->string('pic_profile_photo_path')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('verification_notes')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();

            $table->index(['status']);
            $table->unique('pic_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
