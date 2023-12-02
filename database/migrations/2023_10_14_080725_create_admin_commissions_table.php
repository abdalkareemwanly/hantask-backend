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
        Schema::create('admin_commissions', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->string('system_type');
            $table->string('commission_charge_from')->nullable();
            $table->string('commission_charge_type')->nullable();
            $table->double('commission_charge')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_commissions');
    }
};
