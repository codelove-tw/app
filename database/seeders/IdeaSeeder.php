<?php

namespace Database\Seeders;

use App\Models\Idea\Comment;
use App\Models\Idea\Idea;
use App\Models\Idea\Vote;
use App\Models\User;
use Illuminate\Database\Seeder;

class IdeaSeeder extends Seeder
{
    public function run()
    {
        // 創建一些測試用戶
        $users = User::factory(10)->create();

        // 創建一些點子
        $ideas = [];

        // 手動創建一些有趣的點子
        $sampleIdeas = [
            [
                'title' => '用 AI 罵醒你的鬧鐘',
                'description' => '用你朋友的語氣把你罵醒，保證比任何鬧鐘都有效。可以客製化髒話程度和親密度。還能學習你的賴床模式，逐漸升級罵人強度。',
                'user_id' => $users->random()->id,
            ],
            [
                'title' => '租借假面試官',
                'description' => '媒合嚴格面試官，讓你在真正面試前先被電一遍，增強抗壓性。提供各種奇葩問題和刁難場景。',
                'user_id' => $users->random()->id,
            ],
            [
                'title' => '幫我假裝很忙的滑鼠指標',
                'description' => '偶爾自己亂晃、點擊，讓老闆以為你在認真工作。內建「假裝思考」模式，會故意停頓然後快速移動。',
                'user_id' => $users->random()->id,
            ],
            [
                'title' => '自動幫人找藉口機',
                'description' => '一鍵產生請假理由，從「寵物生病」到「家裡淹水」應有盡有。還會根據你的使用歷史避免重複。',
                'user_id' => $users->random()->id,
            ],
            [
                'title' => '專門用來逃避社交的隱形斗篷',
                'description' => '穿上後可以讓你在聚會中完全隱形，或是讓別人自動忽略你的存在。內建「我要回家了」自動偵測功能。',
                'user_id' => $users->random()->id,
            ],
            [
                'title' => '會自動回覆「我在忙」的機器人',
                'description' => '智能分析訊息緊急程度，自動產生不同等級的「忙碌」回覆。從「等等回你」到「明天再說」都有。',
                'user_id' => $users->random()->id,
            ],
            [
                'title' => '專門產生完美拖延理由的 App',
                'description' => '結合心理學和拖延症研究，產生讓人無法反駁的完美藉口。包含「等靈感來」、「需要更多資料」等經典理由。',
                'user_id' => $users->random()->id,
            ],
            [
                'title' => '讓老闆以為你很認真的假裝加班器',
                'description' => '定時發送工作相關郵件、在 Slack 上顯示「正在輸入」、隨機點亮辦公室燈光。讓你在家躺平也能營造加班假象。',
                'user_id' => $users->random()->id,
            ],
        ];

        foreach ($sampleIdeas as $ideaData) {
            $ideas[] = Idea::create($ideaData);
        }

        // 為每個點子隨機加入投票
        foreach ($ideas as $idea) {
            $voterCount = rand(0, 8);
            $voters = $users->random($voterCount);

            foreach ($voters as $voter) {
                Vote::create([
                    'idea_id' => $idea->id,
                    'user_id' => $voter->id,
                ]);
            }
        }

        // 為一些點子加入留言
        $commentsData = [
            '這個想法太有趣了！',
            '我想要投資這個專案',
            '已經有類似的產品了吧？',
            '技術上可行嗎？',
            '哈哈哈笑死我了',
            '認真考慮要不要做',
            '這不就是我每天在做的事嗎',
            '求開發！',
            '想法不錯，但實作會很困難',
            '有人要一起做嗎？',
        ];

        foreach ($ideas as $idea) {
            $commentCount = rand(0, 5);
            for ($i = 0; $i < $commentCount; $i++) {
                Comment::create([
                    'idea_id' => $idea->id,
                    'user_id' => $users->random()->id,
                    'content' => $commentsData[array_rand($commentsData)],
                ]);
            }
        }
    }
}
