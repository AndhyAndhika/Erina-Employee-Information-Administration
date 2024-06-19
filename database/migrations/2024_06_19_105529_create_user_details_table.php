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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->string('employee_number')->nullable();
            $table->string('position')->nullable();
            $table->string('section')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('join_date')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
