<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Replace the old superadmin/admin+is_mentor model with the three actual
     * application roles: mahasiswa, admin, and mentor.
     */
    public function up(): void
    {
        if (Schema::hasColumn('users', 'is_mentor')) {
            DB::table('users')
                ->where('role', 'admin')
                ->where('is_mentor', true)
                ->update(['role' => 'mentor']);
        }

        // The former superadmin account becomes a regular company admin.
        DB::table('users')
            ->where('role', 'superadmin')
            ->update(['role' => 'admin']);

        if (Schema::hasColumn('users', 'is_mentor')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('is_mentor');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('users', 'is_mentor')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('is_mentor')->default(false)->after('role');
            });
        }

        DB::table('users')
            ->where('role', 'mentor')
            ->update(['role' => 'admin', 'is_mentor' => true]);

        // Admin accounts are intentionally not converted back to superadmin:
        // there is no reliable way to distinguish the old admin/superadmin rows.
    }
};
