<?php

namespace Database\Seeders;

use App\Models\Board;
use Illuminate\Database\Seeder;

class BoardSeeder extends Seeder
{
    public function run(): void
    {
        $boards = [
            [
                'slug' => 'notice',
                'name' => '공지',
                'description' => '제이커브인터렉티브의 공지사항입니다.',
                'is_anonymous' => false,
                'write_permission' => 'admin',
                'order' => 1,
            ],
            [
                'slug' => 'free',
                'name' => '자유게시판',
                'description' => '마케팅과 비즈니스에 관한 이야기를 자유롭게 나누는 공간입니다.',
                'is_anonymous' => false,
                'write_permission' => 'member',
                'order' => 2,
            ],
            [
                'slug' => 'qna',
                'name' => '질문답변',
                'description' => '마케팅 실무에 관한 질문과 답변을 나누는 공간입니다.',
                'is_anonymous' => false,
                'write_permission' => 'member',
                'order' => 3,
            ],
            [
                'slug' => 'tips',
                'name' => '정보공유',
                'description' => '검증된 마케팅 정보와 실무 팁을 공유하는 공간입니다.',
                'is_anonymous' => false,
                'write_permission' => 'member',
                'order' => 4,
            ],
        ];

        foreach ($boards as $board) {
            Board::query()->updateOrCreate(
                ['slug' => $board['slug']],
                $board,
            );
        }
    }
}
