<?php

namespace Database\Factories\Idea;

use App\Models\Idea\Idea;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class IdeaFactory extends Factory
{
    protected $model = Idea::class;

    public function definition()
    {
        $titles = [
            '用 AI 罵醒你的鬧鐘',
            '租借假面試官',
            '幫我假裝很忙的滑鼠指標',
            '自動幫人找藉口機',
            '專門用來逃避社交的隱形斗篷',
            '會自動回覆「我在忙」的機器人',
            '專門產生完美拖延理由的 App',
            '讓老闆以為你很認真的假裝加班器',
            '自動把會議轉成「我有急事」的翻譯機',
            '專門製造「網路不穩」假象的設備',
        ];

        $descriptions = [
            '用你朋友的語氣把你罵醒，保證比任何鬧鐘都有效。可以客製化髒話程度和親密度。',
            '媒合嚴格面試官，讓你在真正面試前先被電一遍，增強抗壓性。',
            '偶爾自己亂晃、點擊，讓老闆以為你在認真工作。內建「假裝思考」模式。',
            '一鍵產生請假理由，從「寵物生病」到「家裡淹水」應有盡有。',
            null,
            null,
            '結合心理學和拖延症研究，產生讓人無法反駁的完美藉口。',
            null,
            '自動偵測會議關鍵字，立刻轉換成緊急事件，讓你優雅脫身。',
            '模擬各種網路問題，從斷線到lag，讓線上會議變成「技術性困難」。',
        ];

        $titleIndex = array_rand($titles);

        return [
            'title' => $titles[$titleIndex],
            'description' => $descriptions[$titleIndex],
            'user_id' => User::factory(),
        ];
    }
}
