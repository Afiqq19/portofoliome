<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Normalisasi urutan di database agar berurutan bersih 1, 2, 3...
        $experiences = DB::table('experiences')->orderBy('order')->orderBy('id')->get();
        $counter = 1;
        foreach ($experiences as $exp) {
            DB::table('experiences')->where('id', $exp->id)->update(['order' => $counter++]);
        }
    }

    public function down(): void
    {
        // Tidak perlu dibalikkan
    }
};
