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
        Schema::create('investment_distribution', function (Blueprint $table) {
            $table->uuid('investment_distribution_id')->primary();
            $table->uuid('investment_id')->index();
            $table->string('investor_name');
            $table->unsignedBigInteger('distributed_amount');
            $table->unsignedInteger('rounding_reminder');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_distribution');
    }
};
