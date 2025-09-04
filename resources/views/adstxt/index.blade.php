@extends('layout')

@section('content')
    <style>
        /* 主題配色和漸層 */
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --button-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* 標題樣式 */
        .fancy-title {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* 卡片樣式 */
        .fancy-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .fancy-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .fancy-card-header {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 1.5rem;
            border-radius: 20px 20px 0 0;
        }

        .fancy-card-body {
            padding: 2rem;
        }

        /* 說明區塊 */
        .fancy-alert {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }

        /* 文字區域 */
        .fancy-textarea {
            border: 2px solid transparent;
            border-radius: 15px;
            background: linear-gradient(white, white) padding-box,
                var(--primary-gradient) border-box;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            transition: all 0.3s ease;
            resize: vertical;
        }

        .fancy-textarea:focus {
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.4);
            transform: scale(1.02);
        }

        .input-textarea {
            height: 50vh;
        }

        .result-textarea {
            height: 40vh;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        /* 按鈕樣式 */
        .fancy-btn {
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .fancy-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .fancy-btn:hover::before {
            left: 100%;
        }

        .fancy-btn-primary {
            background: var(--primary-gradient);
            color: white;
            box-shadow: var(--button-shadow);
        }

        .fancy-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .fancy-btn-secondary {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #495057;
            box-shadow: var(--button-shadow);
        }

        .fancy-btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            color: #495057;
        }

        .fancy-btn-success {
            background: var(--success-gradient);
            color: white;
            box-shadow: var(--button-shadow);
        }

        .fancy-btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 172, 254, 0.4);
            color: white;
        }

        /* 統計區塊 */
        .fancy-stats {
            background: var(--success-gradient);
            color: white;
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(79, 172, 254, 0.3);
        }

        /* 行數計數器 */
        .line-counter {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            display: inline-block;
            box-shadow: 0 4px 10px rgba(102, 126, 234, 0.3);
        }

        /* 動畫效果 */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* 載入動畫 */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* 響應式調整 */
        @media (max-width: 768px) {
            .fancy-title {
                font-size: 2rem;
            }

            .container {
                padding: 1rem;
                margin-top: -1rem;
            }

            .fancy-card-body {
                padding: 1.5rem;
            }
        }
    </style>

    <div class="container">
        <!-- Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="fancy-title fade-in-up mt-4">✨ AdsTxt 去重工具 | Deduplicate Tool ✨</h1>
            </div>
        </div>

        <!-- Intro -->
        <div class="row mb-4 fade-in-up">
            <div class="col-12">
                <div class="alert fancy-alert">
                    <h5>📋 說明 / Instructions:</h5>
                    <p class="mb-2">
                        <strong>🇹🇼 中文：</strong>把舊版、新版或各廣告商提供的 ads.txt 片段一次貼上來，我們會自動移除重複行，輸出乾淨版。
                    </p>
                    <p class="mb-0">
                        <strong>🇺🇸 English:</strong> Paste old versions, new versions, or multiple snippets of ads.txt
                        here. We will automatically remove duplicate lines and give you a clean version.
                    </p>
                </div>
            </div>
        </div>

        <!-- Input Section -->
        <div class="row fade-in-up">
            <div class="col-12">
                <div class="card fancy-card">
                    <div class="card-header fancy-card-header">
                        <h5 class="mb-0">📝 貼上 ads.txt / Paste ads.txt</h5>
                    </div>
                    <div class="card-body fancy-card-body">
                        <form id="deduplicateForm" class="ajax-form">
                            @csrf
                            <div class="mb-4">
                                <textarea id="adstxtContent" name="content" class="form-control fancy-textarea input-textarea"
                                    placeholder="# 在此貼上你的 ads.txt（可混貼多份）&#10;# Paste your ads.txt here (you can paste multiple versions together)&#10;&#10;# 範例 / Example:&#10;# google.com, pub-1234567890123456, DIRECT, f08c47fec0942fa0&#10;# facebook.com, 1234567890, DIRECT"
                                    required></textarea>
                            </div>

                            <div class="row align-items-center mb-3">
                                <div class="col-md-6">
                                    <span class="line-counter">
                                        📊 行數小計 / Line count: <span id="lineCount">0</span>
                                    </span>
                                </div>
                                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                    <button type="button" id="clearBtn"
                                        class="btn fancy-btn fancy-btn-secondary me-2 mb-3 mb-md-0">
                                        🗑️ 清空 / Clear
                                    </button>
                                    <button type="submit" id="submitBtn" class="btn fancy-btn fancy-btn-primary">
                                        ✨ 去重清理 / Deduplicate
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Result Section -->
        <div class="row mt-4 fade-in-up" id="resultSection" style="display: none;">
            <div class="col-12">
                <div class="card fancy-card">
                    <div class="card-header fancy-card-header">
                        <h5 class="mb-0">🎯 結果 / Result</h5>
                    </div>
                    <div class="card-body fancy-card-body">
                        <!-- Summary -->
                        <div class="alert fancy-stats" id="summaryAlert">
                            <h6>📊 小結 / Summary:</h6>
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <i class="fas fa-file-alt fa-2x mb-2"></i>
                                        <h4 id="originalCount">0</h4>
                                        <small>原始行數 / Original lines</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <i class="fas fa-check-circle fa-2x mb-2"></i>
                                        <h4 id="uniqueCount">0</h4>
                                        <small>去重後行數 / Unique lines</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <i class="fas fa-trash-alt fa-2x mb-2"></i>
                                        <h4 id="duplicatesRemoved">0</h4>
                                        <small>移除重複 / Duplicates removed</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Preview -->
                        <div class="mb-4">
                            <label class="form-label"><strong>👁️ 預覽 / Preview</strong></label>
                            <textarea id="resultContent" class="form-control fancy-textarea result-textarea" readonly></textarea>
                        </div>

                        <div class="text-center">
                            <button type="button" id="copyBtn" class="btn fancy-btn fancy-btn-success">
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
        const submitBtn = document.getElementById('submitBtn');
        const resultSection = document.getElementById('resultSection');
        const copyBtn = document.getElementById('copyBtn');

        // 更新行數計數
        function updateLineCount() {
            const content = textarea.value.trim();
            const lines = content ? content.split('\n').length : 0;
            lineCountSpan.textContent = lines;
        }

        // 顯示載入狀態
        function showLoading() {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="loading-spinner"></span> 處理中...';
        }

        // 隱藏載入狀態
        function hideLoading() {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '✨ 去重清理 / Deduplicate';
        }

        // 綁定事件
        textarea.addEventListener('input', updateLineCount);

        clearBtn.addEventListener('click', function() {
            textarea.value = '';
            updateLineCount();
            resultSection.style.display = 'none';

            // 添加清空動畫
            textarea.style.transform = 'scale(0.98)';
            setTimeout(() => {
                textarea.style.transform = 'scale(1)';
            }, 150);
        });

        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            showLoading();
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

                // 顯示結果區域並添加動畫
                resultSection.style.display = 'block';
                resultSection.classList.add('fade-in-up');

                // 滾動到結果區域
                setTimeout(() => {
                    resultSection.scrollIntoView({
                        behavior: 'smooth'
                    });
                }, 100);

            } catch (error) {
                console.error('Error:', error);
                alert('❌ 處理過程中發生錯誤，請稍後再試。');
            } finally {
                hideLoading();
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

                // 暫時更改按鈕文字和樣式
                const originalText = copyBtn.innerHTML;
                copyBtn.innerHTML = '✅ 已複製 / Copied!';
                copyBtn.classList.remove('fancy-btn-success');
                copyBtn.classList.add('fancy-btn-primary');

                // 添加成功動畫
                copyBtn.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    copyBtn.style.transform = 'scale(1)';
                }, 150);

                setTimeout(() => {
                    copyBtn.innerHTML = originalText;
                    copyBtn.classList.remove('fancy-btn-primary');
                    copyBtn.classList.add('fancy-btn-success');
                }, 2000);

            } catch (err) {
                console.error('複製失敗:', err);

                // 如果都失敗了，提供手動複製的提示
                resultTextarea.select();
                resultTextarea.setSelectionRange(0, resultTextarea.value.length);
                alert('⚠️ 自動複製失敗，文字已選取，請按 Ctrl+C (或 Cmd+C) 手動複製。');
            }
        });

        // 初始化行數計數
        updateLineCount();

        // 添加輸入時的動畫效果
        textarea.addEventListener('focus', function() {
            this.style.transform = 'scale(1.02)';
        });

        textarea.addEventListener('blur', function() {
            this.style.transform = 'scale(1)';
        });
    </script>
@endsection
