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
        Schema::create('user_deleted', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->string('name');
            $table->string('email');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->string('profile_background')->nullable();
            $table->string('service_city')->nullable();
            $table->string('service_area')->nullable();
            $table->integer('user_type')->default(0)->comment('0=seller, 1=buyer');
            $table->integer('user_status')->default(1)->comment('0=inactive, 1=active');
            $table->integer('terms_condition')->default(1);
            $table->text('address')->nullable();
            $table->string('state')->nullable();
            $table->text('about')->nullable();
            $table->string('post_code')->nullable();
            $table->string('country_id')->nullable();
            $table->string('email_verified')->nullable();
            $table->text('email_verify_token')->nullable();
            $table->text('facebook_id')->nullable();
            $table->text('google_id')->nullable();
            $table->string('country_code')->nullable();
            $table->bigInteger('otp_code')->default(0);
            $table->bigInteger('otp_verified');

            $columns = [
                'fb_url',
                'tw_url',
                'go_url',
                'li_url',
                'in_url',
                'twi_url',
                'pi_url',
                'dr_url',
                're_url',
            ];
            foreach ($columns as $column){
                if(!Schema::hasColumn('users',$column)){
                    $table->string($column)->nullable();
                }
            }
            $table->rememberToken();
            $table->timestamp('last_seen')->nullable();
            $table->timestamp('otp_expire_at')->nullable();
            $table->string('latitude')->nullable();
            $table->string('seller_address')->nullable();
            $table->string('longitude')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_deleted');
    }
};
