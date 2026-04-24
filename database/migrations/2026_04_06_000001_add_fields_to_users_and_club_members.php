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
        // Thêm trường faculty vào bảng users
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'faculty')) {
                    $table->string('faculty')->nullable()->after('email');
                }
            });
        }

        // Thêm trường reason và department vào bảng club_members
        if (Schema::hasTable('club_members')) {
            Schema::table('club_members', function (Blueprint $table) {
                if (!Schema::hasColumn('club_members', 'reason')) {
                    $table->text('reason')->nullable()->after('user_id');
                }
                if (!Schema::hasColumn('club_members', 'department')) {
                    $table->string('department')->nullable()->after('reason');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['faculty']);
            });
        }

        if (Schema::hasTable('club_members')) {
            Schema::table('club_members', function (Blueprint $table) {
                $table->dropColumn(['reason', 'department']);
            });
        }
    }
};
