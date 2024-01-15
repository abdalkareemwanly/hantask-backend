<?php

use App\Models\ManyEmployeess;
use App\Models\ProfessionalStatus;
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
        Schema::create('profile_verifies', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->foreignIdFor(ManyEmployeess::class,'many_employee_id');
            $table->foreignIdFor(ProfessionalStatus::class,'professional_status_id');
            $table->string('gisa')->nullable();
            $table->string('company_name');
            $table->string('address');
            $table->string('zip_code');
            $table->string('busines_license');
            $table->string('seller_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_verifies');
    }
};
