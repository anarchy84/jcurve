<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('insights', function (Blueprint $table) {
            // 구버전(/v1/ 그누보드) 원본 글번호 — 리다이렉트·추적용
            $table->unsignedSmallInteger('legacy_wr_id')->nullable()->unique()->after('id');
            $table->string('source_url')->nullable()->after('meta_description');
        });
    }

    public function down(): void
    {
        Schema::table('insights', function (Blueprint $table) {
            $table->dropColumn(['legacy_wr_id', 'source_url']);
        });
    }
};
