<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('profiles', 'enable_ai_assistant')) {
            Schema::table('profiles', function (Blueprint $table) {
                $table->boolean('enable_ai_assistant')->default(true)->after('enable_landing_page');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('profiles', 'enable_ai_assistant')) {
            Schema::table('profiles', function (Blueprint $table) {
                $table->dropColumn('enable_ai_assistant');
            });
        }
    }
};
