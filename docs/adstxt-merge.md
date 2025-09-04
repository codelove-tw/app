## controller: AdsTxtMergeController

## routing: prefix 用 '/adstxt-merge' 開頭

## ui

[Header]
  adstxt-merge · 去重工具 | Deduplicate Tool

[Intro]
  說明 / Instructions:
  - 中文：把舊版、新版或各廣告商提供的 ads.txt 片段一次貼上來，
           我們會自動移除重複行，輸出乾淨版。
  - English: Paste old versions, new versions, or multiple snippets of ads.txt here.
             We will automatically remove duplicate lines and give you a clean version.

[Input]
  標題：貼上 ads.txt / Paste ads.txt
  [Textarea (多行, 高度 40~60vh)]
    placeholder:
      # 在此貼上你的 ads.txt（可混貼多份）
      # Paste your ads.txt here (you can paste multiple versions together)

  [行數小計 / Line count: N]

[Action]
  [▶ 去重清理 / Deduplicate]
  [清空 / Clear]

[Result（點擊「去重清理」後顯示）]
  小結 / Summary:
    - 原始行數 / Original lines: N
    - 去重後行數 / Unique lines: U
    - 移除重複 / Duplicates removed: D

  [預覽 / Preview]
    [Textarea（唯讀, 顯示乾淨版 ads.txt, 可捲動, 行號）]

## file structure

project-root/
├─ app/
│  ├─ Http/
│  │  ├─ Controllers/
│  │  │  └─ AdsTxt/
│  │  │     └─ AdsTxtMergeController.php      # 控制器
│  └─ Services/
│     └─ AdsTxt/
│        └─ AdsTxtDeduplicator.php            # 去重邏輯
│
├─ resources/
│  ├─ views/
│  │  └─ adstxt/
│  │     └─ index.blade.php                   # 單頁 UI
