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
        Schema::table('users', function (Blueprint $table) {
            $table->string('employee_number')->nullable()->after('id');
            $table->string('role')->nullable()->after('name');
            $table->string('created_by')->nullable()->after('remember_token');
            $table->string('updated_by')->nullable()->after('created_by');
            $table->boolean('is_active')->default(1)->after('updated_by');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('employee_number');
            $table->dropColumn('role');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
            $table->dropColumn('is_active');
            $table->dropSoftDeletes();
        });
    }
};
