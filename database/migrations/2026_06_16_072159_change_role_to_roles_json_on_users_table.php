<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->json('roles')->nullable()->after('is_eligible_cert');
        });

        // Migrate existing roles to JSON array
        DB::statement('UPDATE users SET roles = JSON_ARRAY(role) WHERE role IS NOT NULL');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['peserta', 'jawatankuasa', 'admin'])->default('peserta')->after('is_eligible_cert');
        });

        // Attempt reverse migration (best effort, take first role)
        DB::statement('UPDATE users SET role = JSON_UNQUOTE(JSON_EXTRACT(roles, "$[0]")) WHERE roles IS NOT NULL AND JSON_LENGTH(roles) > 0');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('roles');
        });
    }
};
