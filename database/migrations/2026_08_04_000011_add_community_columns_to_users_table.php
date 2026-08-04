<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nickname')->nullable()->unique()->after('name');
            $table->string('avatar')->nullable()->after('password');
            $table->enum('provider', ['kakao', 'naver', 'google'])->nullable()->after('avatar');
            $table->string('provider_id')->nullable()->after('provider');
            $table->enum('role', ['admin', 'member'])->default('member')->after('provider_id');
            $table->timestamp('last_login_at')->nullable()->after('email_verified_at');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['nickname']);
            $table->dropColumn([
                'nickname',
                'avatar',
                'provider',
                'provider_id',
                'role',
                'last_login_at',
                'deleted_at',
            ]);
        });
    }
};
