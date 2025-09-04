<?php

namespace App\Services\AdsTxt;

class AdsTxtDeduplicator
{
    /**
     * 去重 ads.txt 內容
     *
     * @param  string  $content 原始 ads.txt 內容
     * @return array 包含統計資訊和清理後內容的陣列
     */
    public function deduplicate(string $content): array
    {
        // 分割成行
        $lines = explode("\n", $content);

        // 計算原始行數
        $originalCount = count($lines);

        // 清理並去重
        $uniqueLines = [];
        $seenLines = [];

        foreach ($lines as $line) {
            // 移除行首行尾空白
            $trimmedLine = trim($line);

            // 跳過空行
            if (empty($trimmedLine)) {
                continue;
            }

            // 正規化行內容（統一小寫比較，但保留原始格式）
            $normalizedLine = strtolower($trimmedLine);

            // 如果這行還沒見過，就加入結果
            if (!in_array($normalizedLine, $seenLines)) {
                $seenLines[] = $normalizedLine;
                $uniqueLines[] = $trimmedLine;
            }
        }

        // 計算去重後行數
        $uniqueCount = count($uniqueLines);

        // 計算移除的重複行數
        $duplicatesRemoved = $originalCount - $uniqueCount;

        // 組合清理後的內容
        $cleanContent = implode("\n", $uniqueLines);

        return [
            'original_count' => $originalCount,
            'unique_count' => $uniqueCount,
            'duplicates_removed' => $duplicatesRemoved,
            'clean_content' => $cleanContent,
        ];
    }
}
