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
        Schema::create('kycs', function (Blueprint $table) {
            $table->id();
            $table->string('government_id_number')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('address_line')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('government_id_file')->nullable(); 
            $table->string('proof_of_address_file')->nullable();
            $table->string('live_selfie_file')->nullable();
            $table->string('partnership_agreement_file')->nullable();
            $table->string('contracts_file')->nullable();
            $table->string('nda_file')->nullable();
            // Status
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kycs');
    }
};
