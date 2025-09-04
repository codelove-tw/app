@extends('layout')

@section('content')
    <style>
        .line-numbers {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            line-height: 1.5;
            white-space: pre-wrap;
            overflow-y: auto;
            position: relative;
        }

        .line-numbers::before {
            content: counter(line);
            counter-increment: line;
            position: absolute;
            left: 10px;
            color: #6c757d;
            width: 40px;
            text-align: right;
        }

        .line-numbers {
            counter-reset: line;
            padding-left: 60px;
        }

        .input-textarea {
            height: 50vh;
            font-family: 'Courier New', monospace;
            font-size: 14px;
        }

        .result-textarea {
            height: 40vh;
            font-family: 'Courier New', monospace;
            font-size: 14px;
        }
    </style>

    <div class="container">
        <!-- Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="h2 mb-4">adstxt-merge · 去重工具 | Deduplicate Tool</h1>
            </div>
        </div>

        <!-- Intro -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-info">
                    <h5>說明 / Instructions:</h5>
                    <p class="mb-2">
                        <strong>中文：</strong>把舊版、新版或各廣告商提供的 ads.txt 片段一次貼上來，我們會自動移除重複行，輸出乾淨版。
                    </p>
                    <p class="mb-0">
                        <strong>English:</strong> Paste old versions, new versions, or multiple snippets of ads.txt
                        here. We will automatically remove duplicate lines and give you a clean version.
                    </p>
                </div>
            </div>
        </div>

        <!-- Input Section -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">貼上 ads.txt / Paste ads.txt</h5>
                    </div>
                    <div class="card-body">
                        <form id="deduplicateForm">
                            @csrf
                            <div class="mb-3">
                                <textarea id="adstxtContent" name="content" class="form-control input-textarea"
                                    placeholder="# 在此貼上你的 ads.txt（可混貼多份）&#10;# Paste your ads.txt here (you can paste multiple versions together)"
                                    required></textarea>
                            </div>

                            <div class="row align-items-center mb-3">
                                <div class="col-md-6">
                                    <small class="text-muted">行數小計 / Line count: <span id="lineCount">0</span></small>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <button type="button" id="clearBtn" class="btn btn-outline-secondary me-2">
                                        清空 / Clear
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        ▶ 去重清理 / Deduplicate
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Result Section -->
        <div class="row mt-4" id="resultSection" style="display: none;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">結果 / Result</h5>
                    </div>
                    <div class="card-body">
                        <!-- Summary -->
                        <div class="alert alert-success" id="summaryAlert">
                            <h6>小結 / Summary:</h6>
                            <ul class="mb-0">
                                <li>原始行數 / Original lines: <span id="originalCount">0</span></li>
                                <li>去重後行數 / Unique lines: <span id="uniqueCount">0</span></li>
                                <li>移除重複 / Duplicates removed: <span id="duplicatesRemoved">0</span></li>
                            </ul>
                        </div>

                        <!-- Preview -->
                        <div class="mb-3">
                            <label class="form-label"><strong>預覽 / Preview</strong></label>
                            <textarea id="resultContent" class="form-control result-textarea" readonly></textarea>
                        </div>

                        <div class="text-end">
                            <button type="button" id="copyBtn" class="btn btn-outline-primary">
                                📋 複製結果 / Copy Result
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // 設置 CSRF token
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // DOM 元素
        const form = document.getElementById('deduplicateForm');
        const textarea = document.getElementById('adstxtContent');
        const lineCountSpan = document.getElementById('lineCount');
        const clearBtn = document.getElementById('clearBtn');
        const resultSection = document.getElementById('resultSection');
        const copyBtn = document.getElementById('copyBtn');

        // 更新行數計數
        function updateLineCount() {
            const content = textarea.value.trim();
            const lines = content ? content.split('\n').length : 0;
            lineCountSpan.textContent = lines;
        }

        // 綁定事件
        textarea.addEventListener('input', updateLineCount);

        clearBtn.addEventListener('click', function() {
            textarea.value = '';
            updateLineCount();
            resultSection.style.display = 'none';
        });

        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(form);

            try {
                const response = await fetch('{{ route('adstxt-merge.deduplicate') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const result = await response.json();

                // 更新結果顯示
                document.getElementById('originalCount').textContent = result.original_count;
                document.getElementById('uniqueCount').textContent = result.unique_count;
                document.getElementById('duplicatesRemoved').textContent = result.duplicates_removed;
                document.getElementById('resultContent').value = result.clean_content;

                // 顯示結果區域
                resultSection.style.display = 'block';

                // 滾動到結果區域
                resultSection.scrollIntoView({
                    behavior: 'smooth'
                });

            } catch (error) {
                console.error('Error:', error);
                alert('處理過程中發生錯誤，請稍後再試。');
            }
        });

        copyBtn.addEventListener('click', async function() {
            const resultTextarea = document.getElementById('resultContent');
            const textToCopy = resultTextarea.value;

            try {
                // 使用現代的 Clipboard API
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    await navigator.clipboard.writeText(textToCopy);
                } else {
                    // 備用方案：使用傳統方法
                    resultTextarea.select();
                    resultTextarea.setSelectionRange(0, resultTextarea.value.length);
                    document.execCommand('copy');
                }

                // 暫時更改按鈕文字
                const originalText = copyBtn.textContent;
                copyBtn.textContent = '✅ 已複製 / Copied!';
                copyBtn.classList.remove('btn-outline-primary');
                copyBtn.classList.add('btn-success');

                setTimeout(() => {
                    copyBtn.textContent = originalText;
                    copyBtn.classList.remove('btn-success');
                    copyBtn.classList.add('btn-outline-primary');
                }, 2000);

            } catch (err) {
                console.error('複製失敗:', err);
                
                // 如果都失敗了，提供手動複製的提示
                resultTextarea.select();
                resultTextarea.setSelectionRange(0, resultTextarea.value.length);
                alert('自動複製失敗，文字已選取，請按 Ctrl+C (或 Cmd+C) 手動複製。');
            }
        });

        // 初始化行數計數
        updateLineCount();
    </script>
    </div>
@endsection
