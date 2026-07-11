<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->boolean('enable_skills')->default(true)->after('trakteer_url');
            $table->boolean('enable_projects')->default(true)->after('enable_skills');
            $table->boolean('enable_certificates')->default(true)->after('enable_projects');
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['enable_skills', 'enable_projects', 'enable_certificates']);
        });
    }
};
