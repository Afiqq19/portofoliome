<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('profiles', 'enable_landing_page')) {
                $table->boolean('enable_landing_page')->default(true)->after('enable_architecture');
            }
            if (!Schema::hasColumn('profiles', 'maintenance_status')) {
                $table->string('maintenance_status')->default('maintenance')->after('enable_landing_page');
            }
            if (!Schema::hasColumn('profiles', 'maintenance_title')) {
                $table->string('maintenance_title')->nullable()->after('maintenance_status');
            }
            if (!Schema::hasColumn('profiles', 'maintenance_message')) {
                $table->text('maintenance_message')->nullable()->after('maintenance_title');
            }
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('profiles', 'enable_landing_page')) $columnsToDrop[] = 'enable_landing_page';
            if (Schema::hasColumn('profiles', 'maintenance_status')) $columnsToDrop[] = 'maintenance_status';
            if (Schema::hasColumn('profiles', 'maintenance_title')) $columnsToDrop[] = 'maintenance_title';
            if (Schema::hasColumn('profiles', 'maintenance_message')) $columnsToDrop[] = 'maintenance_message';

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
