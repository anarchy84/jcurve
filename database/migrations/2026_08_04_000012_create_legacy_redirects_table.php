<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('legacy_redirects', function (Blueprint $table) {
            $table->id();
            // 정규화된 원본 경로: 소문자 + rawurldecode + 양끝 슬래시 제거.
            // 쿼리 기반 매핑은 "path?key=val&key=val"(키 정렬) 형태로 저장.
            $table->string('from_path')->unique();
            $table->string('to_path');
            $table->unsignedSmallInteger('status_code')->default(301);
            $table->unsignedInteger('hit_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('legacy_redirects');
    }
};
