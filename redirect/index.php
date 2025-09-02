<?php
$query  = $_SERVER['QUERY_STRING'];
$prefix = "url=";

function isMobile() {
    return preg_match("/Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i", $_SERVER['HTTP_USER_AGENT']);
}

function isKakaoInApp() {
    return strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'kakaotalk') !== false;
}

if (strpos($query, $prefix) === 0) {
    $raw_url = substr($query, strlen($prefix));
    $url = urldecode($raw_url);

    $url = preg_replace_callback('/[^\x20-\x7E]/u', fn($m) => rawurlencode($m[0]), $url);
    $url = str_replace(' ', '%20', $url);

    if (
        filter_var($url, FILTER_VALIDATE_URL) &&
        (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0)
    ) {
        header("Location: $url");
        exit();
    }

    if (strpos($url, 'kakao') === 0) {
        if (isMobile() && isKakaoInApp()) {
            ?>
            <!DOCTYPE html>
            <html lang="ko">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta name="color-scheme" content="light dark">
                <style>
                    body {
                        margin: 0;
                        padding: 0;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        font-family: sans-serif;
                        transition: background-color 0.3s, color 0.3s;
                    }
                    @media (prefers-color-scheme: dark) {
                        body { background-color: #000; color: #fff; }
                    }
                    @media (prefers-color-scheme: light) {
                        body { background-color: #fff; color: #000; }
                    }
                </style>
                <script>
                    function checkReturn() {
                        document.addEventListener("visibilitychange", function () {
                            if (document.hidden === false) {
                                closeBrowser();
                            }
                        });
                    }

                    function closeBrowser() {
                        var ua = navigator.userAgent.toLowerCase();
                        if (ua.includes('kakaotalk')) {
                            if (/iphone|ipad|ipod/.test(ua)) {
                                location.href = 'kakaoweb://closeBrowser';
                            } else {
                                location.href = 'kakaotalk://inappbrowser/close';
                            }
                        } else {
                            window.open('', '_self');
                            window.close();
                        }
                    }

                    (function () {
                        location.href = <?php echo json_encode($url); ?>;
                        checkReturn();
                    })();
                </script>
            </head>
            </html>
            <?php
        } else {
            header("Location: $url");
            exit();
        }
        exit();
    }
}
if (isset($_GET['ID'])) {
    $id = htmlspecialchars($_GET['ID'], ENT_QUOTES, 'UTF-8');
    ?>
    <script>
        var varUA = navigator.userAgent.toLowerCase();

        if (varUA.includes("kakaotalk")) {
            // 카톡 인앱 브라우저일 때만 실행
            location.href = "kakaotalk://melon?action=playmusic&type=song&menuid=1000000932&mediaid=<?= $id ?>";

            if (varUA.includes("android")) {
                setTimeout(() => {
                    location.href = "kakaotalk://inappbrowser/close";
                }, 300);
            } else {
                setTimeout(() => {
                    location.href = "kakaotalk://web/close";
                }, 300);
            }
        } else {
            // 일반 브라우저 (크롬, 사파리, PC 등)에서는 멜론 웹으로 이동
            setTimeout(() => {
                location.href = "https://www.melon.com/song/detail.htm?songId=<?= $id ?>";
            }, 500);
        }
    </script>
    <?php
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>PonyoBot 리다이렉트</title>
    <meta name="description" content="안전한 링크 이동을 경험해보세요.">

    <!-- Open Graph -->
    <meta property="og:title" content="PonyoBot" />
    <meta property="og:description" content="안전한 링크 이동을 경험해보세요." />
    <meta property="og:image" content="https://ponyobot.kr/images/banner.jpg" />
    <meta property="og:url" content="https://ponyobot.kr" />
    <meta property="og:type" content="website" />

    <!-- 파비콘 -->
    <link rel="icon" type="image/png" href="/images/icon.png" />

    <!-- 외부 리소스 -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet" />

<style>
    :root {
        --primary-color: #ff6b8a;
        --primary-hover: #ff5577;
        --secondary-color: #ff8fa3;
        --accent-color: #7dd3c0;
        --success-color: #4ecdc4;
        --warning-color: #ffb347;
        --error-color: #ff6b8a;

        /* Light theme */
        --bg-primary: #ffffff;
        --bg-secondary: #fef9f9;
        --bg-tertiary: #fff0f3;
        --bg-card: #ffffff;
        --text-primary: #2d3748;
        --text-secondary: #4a5568;
        --text-tertiary: #718096;
        --border-color: #e2e8f0;
        --shadow-sm: 0 1px 2px 0 rgba(255, 107, 138, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(255, 107, 138, 0.1), 0 2px 4px -1px rgba(255, 107, 138, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(255, 107, 138, 0.15), 0 4px 6px -2px rgba(255, 107, 138, 0.1);
        --gradient-bg: linear-gradient(135deg, #7dd3c0 0%, #a8e6cf 30%, #ffd3a5 70%, #ffaaa5 100%);

        --hover-bg: #fff0f3;
        --hover-text: #d6336c;
    }

    [data-theme="dark"] {
        --bg-primary: #1a202c;
        --bg-secondary: #2d3748;
        --bg-tertiary: #4a5568;
        --bg-card: #2d3748;
        --text-primary: #f7fafc;
        --text-secondary: #e2e8f0;
        --text-tertiary: #a0aec0;
        --border-color: #4a5568;
        --shadow-sm: 0 1px 2px 0 rgba(124, 58, 237, 0.1);
        --shadow-md: 0 4px 6px -1px rgba(124, 58, 237, 0.2), 0 2px 4px -1px rgba(124, 58, 237, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(124, 58, 237, 0.25), 0 4px 6px -2px rgba(124, 58, 237, 0.15);
        --gradient-bg: linear-gradient(135deg, #2d3748 0%, #4a5568 30%, #553c9a 70%, #7c3aed 100%);

        --hover-bg: #7c3aed;
        --hover-text: #ffffff;

        --primary-color: #a855f7;
        --primary-hover: #9333ea;
        --secondary-color: #c084fc;
        --accent-color: #8b5cf6;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: 'Noto Sans KR', sans-serif;
        background: var(--gradient-bg);
        color: var(--text-primary);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
        line-height: 1.6;
    }

    /* Header */
    .header {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid var(--border-color);
        border-radius: 0 0 1rem 1rem;
        max-width: 1200px;
        margin: 0 auto;
        box-shadow: var(--shadow-md);
        position: sticky;
        top: 0;
        z-index: 100;
        width: 100%;
    }
    [data-theme="dark"] .header { background: rgba(15, 23, 42, 0.9); }
    .nav { display: flex; justify-content: space-between; align-items: center; padding: 1rem 2rem; }
    .logo {
        font-size: 1.5rem; font-weight: 700; color: var(--primary-color);
        display: flex; align-items: center; gap: 0.5rem; text-decoration: none;
        padding: 0.3rem 0.6rem; border-radius: 0.5rem; transition: all 0.2s ease;
    }
    .logo:hover, .logo:active { background: var(--hover-bg); color: var(--hover-text); }
    .logo:hover .material-symbols-outlined, .logo:active .material-symbols-outlined { color: var(--hover-text);}
    [data-theme="dark"] .logo:hover, [data-theme="dark"] .logo:active { background: #9333ea; color: #ffffff; }
    [data-theme="dark"] .logo:hover .material-symbols-outlined, [data-theme="dark"] .logo:active .material-symbols-outlined { color: #ffffff; }

    .nav-controls { display: flex; align-items: center; gap: 0.5rem; }
    .theme-selector, .language-selector { position: relative; }
    .dropdown-btn {
        background: transparent;
        color: var(--text-primary); padding: 0.5rem; border-radius: 0.75rem;
        cursor: pointer; font-size: 0.875rem; transition: all 0.2s ease; display: inline-flex; align-items: center;
        justify-content: center; width: 50px; height: 50px; box-shadow: none; border: none !important; outline: none !important;
    }
    .dropdown-btn:hover { background: var(--bg-tertiary); transform: translateY(-1px); box-shadow: var(--shadow-md); }
    [data-theme="dark"] .dropdown-btn:hover { background: #7c3aed; color: white; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(124,58,237,0.3); }
    .dropdown-menu {
        position: absolute; top: calc(100% + 8px); right: 0; background: var(--bg-card);
        border: 1px solid var(--border-color); border-radius: 0.75rem; box-shadow: var(--shadow-lg);
        padding: 0.5rem; min-width: 170px; opacity: 0; visibility: hidden; transform: translateY(-10px);
        transition: all 0.2s ease;
    }
    .dropdown-menu.active { opacity: 1; visibility: visible; transform: translateY(0); }
    .dropdown-item { padding: 0.5rem; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s ease;
        font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem; }
    .dropdown-item:last-child { margin-bottom: 0; }
    .dropdown-item:hover { background: var(--bg-tertiary); }
    .dropdown-item .material-icons, .dropdown-item .material-symbols-outlined { font-size: 20px; }
    .dropdown-item.active, .dropdown-item:hover { background: var(--hover-bg) !important; color: var(--hover-text) !important; }
    .dropdown-item.active .material-icons, .dropdown-item.active .material-symbols-outlined,
    .dropdown-item:hover .material-icons, .dropdown-item:hover .material-symbols-outlined { color: var(--hover-text) !important; }
    [data-theme="light"] .dropdown-item:hover, [data-theme="light"] .dropdown-item.active { background: #fff0f3 !important; color: #d6336c !important; }
    [data-theme="light"] .dropdown-item:hover .material-icons, [data-theme="light"] .dropdown-item:hover .material-symbols-outlined,
    [data-theme="light"] .dropdown-item.active .material-icons, [data-theme="light"] .dropdown-item.active .material-symbols-outlined { color: #d6336c !important; }
    .theme-selector:hover .dropdown-menu, .language-selector:hover .dropdown-menu { opacity: 1 !important; visibility: visible !important; transform: translateY(0) !important; }

    /* Main Container */
    .main-container { flex: 1; display: flex; align-items: center; justify-content: center; padding: 20px; }
    .container {
        background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 20px;
        padding: 40px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); max-width: 500px; width: 100%;
        text-align: center; animation: slideUp 0.6s ease-out;
    }
    [data-theme="dark"] .container { background: rgba(45,55,72,0.95); }
    @keyframes slideUp { from { opacity: 0; transform: translateY(30px);} to { opacity: 1; transform: translateY(0);} }
    .header-icon { font-size: 48px; color: var(--primary-color); margin-bottom: 20px; }
    h1 { color: var(--text-primary); margin-bottom: 10px; font-size: 28px; font-weight: 700; }
    .subtitle { color: var(--text-tertiary); margin-bottom: 20px; font-size: 16px; }

    .input-group { margin: 20px 0; text-align: left; }
    .input-group label { display: block; margin-bottom: 8px; color: var(--text-primary); font-weight: 500; }
    .input-group input {
        width: 100%; padding: 15px; border: 2px solid var(--border-color); border-radius: 12px; font-size: 16px;
        transition: all 0.3s ease; background: var(--bg-card); color: var(--text-primary);
    }
    .input-group input:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(102,126,234,0.1); }
    .btn {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white; border: none;
        padding: 15px 30px; border-radius: 12px; font-size: 16px; font-weight: 500; cursor: pointer; transition: all 0.3s ease;
        margin: 10px; min-width: 120px;
    }
    .btn:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(102,126,234,0.3); }
    .warning {
        background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);
        padding: 15px; border-radius: 12px; margin: 20px 0; display: flex; align-items: center; gap: 10px; text-align: left;
    }

    .error-text { color: var(--error-color); font-size: 14px; margin-top: 8px; }

    @media (max-width: 600px) {
        .nav { padding: 1rem; }
        .container { padding: 30px 20px; }
        h1 { font-size: 24px; }
    }
</style>

<!-- Inserted by assistant: disable text selection and dragging for .icon elements -->
<style>
/* Disable selection and dragging for icon elements */
.icon, .icon * {
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  -webkit-user-drag: none;
}
img, svg {
  -webkit-user-drag: none;
  user-select: none;
  draggable: false;
}
</style>

<!-- Inserted by assistant: prevent copying of Material Icons text -->
<style>
.material-icons,
.material-symbols-outlined {
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    -webkit-user-drag: none;
    -khtml-user-drag: none;
    -moz-user-drag: none;
    -o-user-drag: none;
}

    /* Make dropdown buttons blend with header/banner by using transparent background */
    .dropdown-btn { background: transparent !important; box-shadow: none !important; border: none !important; }
    /* Keep icon color readable -- adjust as needed */
    .dropdown-btn .material-symbols-outlined, .dropdown-btn .material-icons { color: var(--text-primary); }
    /* On hover, give a subtle overlay that respects theme */
    .dropdown-btn:hover { background: rgba(255,255,255,0.06); transform: translateY(-1px); box-shadow: var(--shadow-md); }
    [data-theme="dark"] .dropdown-btn:hover { background: rgba(255,255,255,0.06); }
    [data-theme="light"] .dropdown-btn:hover { background: rgba(0,0,0,0.04); }
</style>
</head>
<body data-theme="system">
    <!-- Header -->
    <header class="header">
        <nav class="nav">
            <a class="logo" href="index.php">
                <span aria-hidden="true" class="material-symbols-outlined" translate="no">home</span>
                <span data-translate="logo">PonyoBot</span>
            </a>
            <div class="nav-controls">
                <!-- THEME -->
                <div class="theme-selector">
                    <button aria-label="테마" class="dropdown-btn" id="themeBtn">
                        <span aria-hidden="true" class="material-symbols-outlined" id="themeIcon" translate="no">radio_button_partial</span>
                    </button>
                    <div class="dropdown-menu" id="themeMenu">
                        <div class="dropdown-item" data-theme="system">
                            <span aria-hidden="true" class="material-symbols-outlined" translate="no">radio_button_partial</span>
                            <span data-translate="system">시스템</span>
                        </div>
                        <div class="dropdown-item" data-theme="light">
                            <span aria-hidden="true" class="material-icons" translate="no">light_mode</span>
                            <span data-translate="light">라이트</span>
                        </div>
                        <div class="dropdown-item" data-theme="dark">
                            <span aria-hidden="true" class="material-icons" translate="no">dark_mode</span>
                            <span data-translate="dark">다크</span>
                        </div>
                    </div>
                </div>
                <!-- LANGUAGE -->
               <!-- LANGUAGE -->
<div class="language-selector">
    <button aria-label="언어" class="dropdown-btn" id="langBtn">
        <span aria-hidden="true" class="material-symbols-outlined" id="langIcon" translate="no">language</span>
    </button>
    <div class="dropdown-menu" id="langMenu">
        <div class="dropdown-item" data-lang="ko">
            <span aria-hidden="true" class="material-symbols-outlined" translate="no">language</span>
            <span>한국어</span>
        </div>
        <div class="dropdown-item" data-lang="en">
            <span aria-hidden="true" class="material-symbols-outlined" translate="no">language</span>
            <span>English</span>
        </div>
        <div class="dropdown-item" data-lang="ja">
            <span aria-hidden="true" class="material-symbols-outlined" translate="no">language</span>
            <span>日本語</span>
        </div>
        <div class="dropdown-item" data-lang="zh-CN">
            <span aria-hidden="true" class="material-symbols-outlined" translate="no">language</span>
            <span>简体中文</span>
        </div>
        <div class="dropdown-item" data-lang="zh-TW">
            <span aria-hidden="true" class="material-symbols-outlined" translate="no">language</span>
            <span>繁體中文</span>
        </div>
        <div class="dropdown-item" data-lang="es">
            <span aria-hidden="true" class="material-symbols-outlined" translate="no">language</span>
            <span>Español</span>
        </div>
        <div class="dropdown-item" data-lang="fr">
            <span aria-hidden="true" class="material-symbols-outlined" translate="no">language</span>
            <span>Français</span>
        </div>
        <div class="dropdown-item" data-lang="de">
            <span aria-hidden="true" class="material-symbols-outlined" translate="no">language</span>
            <span>Deutsch</span>
        </div>
        <div class="dropdown-item" data-lang="ru">
            <span aria-hidden="true" class="material-symbols-outlined" translate="no">language</span>
            <span>Русский</span>
        </div>
        <div class="dropdown-item" data-lang="ar">
            <span aria-hidden="true" class="material-symbols-outlined" translate="no">language</span>
            <span>العربية</span>
        </div>
        <div class="dropdown-item" data-lang="pt">
            <span aria-hidden="true" class="material-symbols-outlined" translate="no">language</span>
            <span>Português</span>
        </div>
    </div>
</div>
            </div>
        </nav>
    </header>

    <!-- Main Container -->
    <main class="main-container">
        <section class="container" role="region" aria-labelledby="title">
            <span aria-hidden="true" class="header-icon material-symbols-outlined" translate="no">open_in_new</span>
            <h1 id="title" data-translate="page-title">PonyoBot 리다이렉트</h1>
            <p class="subtitle" id="subtitle" data-translate="input-subtitle">이동할 URL을 입력해주세요</p>
            <div class="warning">
                <span aria-hidden="true" class="material-symbols-outlined" translate="no">warning</span>
                <i class="fas fa-exclamation-triangle" data-translate="warning">신뢰되는 url만 입력하세요</i>
            </div>
            <form id="redirectForm" method="get" action="index.php" novalidate>
                <div class="input-group">
                    <label for="urlInput" data-translate="url-label">URL 주소</label>
                    <input type="text" name="url" id="urlInput" placeholder="https://example.com" autocomplete="off" />
        <div id="inlineInvalid" class="invalid-text" data-translate="invalidUrl" style="display:none; color:#e91e63; margin-top:8px;" style="color:#e91e63; margin-top:8px; display:<?php echo isset($invalid_url)&&$invalid_url ? 'block' : 'none'; ?>;"></div>

                </div>
                <button type="submit" class="btn" id="goBtn" data-translate="submit-btn">이동하기</button>
            </form>

            <div class="warning" id="hintBox" style="<?php echo isset($invalid_url)&&$invalid_url ? '' : 'display:none;'; ?>">
                <span aria-hidden="true" class="material-icons" translate="no">error_outline</span>
                <div>
                    <strong>URL 오류:</strong> 주소를 다시 확인해주세요.
                </div>
            </div>
        </section>
    </main>

<script>
// Translations
const translations = {
    ko: {
        "logo": "PonyoBot",
        "system": "시스템",
        "light": "라이트",
        "dark": "다크",
        "page-title": "PonyoBot 리다이렉트",
        "input-subtitle": "이동할 URL을 입력해주세요",
        "warning" : "신뢰되는 url만 입력하세요",
        "url-label": "URL 주소",
        "submit-btn": "이동하기"
    ,
                "invalidUrl": "잘못된 형식입니다"
            },
    en: {
        "logo": "PonyoBot",
        "system": "System",
        "light": "Light",
        "dark": "Dark",
        "page-title": "PonyoBot Redirect",
        "input-subtitle": "Please enter the URL you want to navigate to",
        "warning": "Enter only trusted URLs",
        "url-label": "URL Address",
        "submit-btn": "Go"
    ,
                "invalidUrl": "Invalid format"
            },
    ja: {
        "logo": "PonyoBot",
        "system": "システム",
        "light": "ライト",
        "dark": "ダーク",
        "page-title": "PonyoBot リダイレクト",
        "input-subtitle": "移動するURLを入力してください",
        "warning": "信頼できるURLのみ入力してください",
        "url-label": "URL アドレス",
        "submit-btn": "移動"
    ,
                "invalidUrl": "無効な形式です"
            },
    "zh-CN": {
        "logo": "PonyoBot",
        "system": "系统",
        "light": "浅色",
        "dark": "深色",
        "page-title": "PonyoBot 重定向",
        "input-subtitle": "请输入要跳转的 URL",
        "warning": "仅输入可信的 URL",
        "url-label": "URL 地址",
        "submit-btn": "前往"
    },
    "zh-TW": {
        "logo": "PonyoBot",
        "system": "系統",
        "light": "淺色",
        "dark": "深色",
        "page-title": "PonyoBot 重新導向",
        "input-subtitle": "請輸入要前往的 URL",
        "warning": "僅輸入您信任的 URL",
        "url-label": "URL 位址",
        "submit-btn": "前往"
    },
    es: {
        "logo": "PonyoBot",
        "system": "Sistema",
        "light": "Claro",
        "dark": "Oscuro",
        "page-title": "PonyoBot Redirección",
        "input-subtitle": "Ingrese la URL a la que desea ir",
        "warning": "Ingrese solo URLs de confianza",
        "url-label": "Dirección URL",
        "submit-btn": "Ir"
    ,
                "invalidUrl": "Formato no válido"
            },
    fr: {
        "logo": "PonyoBot",
        "system": "Système",
        "light": "Clair",
        "dark": "Sombre",
        "page-title": "PonyoBot Redirection",
        "input-subtitle": "Veuillez entrer l'URL vers laquelle vous souhaitez vous rendre",
        "warning": "Entrez uniquement des URL de confiance",
        "url-label": "Adresse URL",
        "submit-btn": "Aller"
    ,
                "invalidUrl": "Format invalide"
            },
    de: {
        "logo": "PonyoBot",
        "system": "System",
        "light": "Hell",
        "dark": "Dunkel",
        "page-title": "PonyoBot Weiterleitung",
        "input-subtitle": "Bitte geben Sie die URL ein, zu der Sie navigieren möchten",
        "warning": "Geben Sie nur vertrauenswürdige URLs ein",
        "url-label": "URL-Adresse",
        "submit-btn": "Los"
    ,
                "invalidUrl": "Ungültiges Format"
            },
    ru: {
        "logo": "PonyoBot",
        "system": "Система",
        "light": "Светлая",
        "dark": "Тёмная",
        "page-title": "PonyoBot Перенаправление",
        "input-subtitle": "Пожалуйста, введите URL, на который вы хотите перейти",
        "warning": "Вводите только доверенные URL",
        "url-label": "Адрес URL",
        "submit-btn": "Перейти"
    ,
                "invalidUrl": "Неверный формат"
            },
    ar: {
        "logo": "PonyoBot",
        "system": "النظام",
        "light": "فاتح",
        "dark": "داكن",
        "page-title": "PonyoBot إعادة توجيه",
        "input-subtitle": "الرجاء إدخال عنوان URL الذي تريد الانتقال إليه",
        "warning": "أدخل عناوين URL الموثوقة فقط",
        "url-label": "عنوان URL",
        "submit-btn": "اذهب"
    ,
                "invalidUrl": "تنسيق غير صالح"
            },
    pt: {
        "logo": "PonyoBot",
        "system": "Sistema",
        "light": "Claro",
        "dark": "Escuro",
        "page-title": "PonyoBot Redirecionamento",
        "input-subtitle": "Digite a URL para a qual deseja navegar",
        "warning": "Digite apenas URLs confiáveis",
        "url-label": "Endereço URL",
        "submit-btn": "Ir"
    ,
                "invalidUrl": "Formato inválido"
            }
};


// --- localization helpers ---
function getBrowserLang() {
    // prefer <html lang=""> if set; otherwise navigator.language
    const htmlLang = document.documentElement.lang;
    if (htmlLang && translations[htmlLang]) return htmlLang;
    const nav = navigator.language || navigator.userLanguage || 'en';
    const code = nav.split('-')[0];
    return translations[code] ? code : (translations[nav] ? nav : 'en');
}

function applyTranslations(lang) {
    // set global currentLang
    currentLang = lang;
    // translate elements with data-translate attributes
    document.querySelectorAll('[data-translate]').forEach(el => {
        const key = el.getAttribute('data-translate');
        if (translations[lang] && translations[lang][key]) {
            el.textContent = translations[lang][key];
        }
    });
    // set inline invalid message if present
    const inline = document.getElementById('inlineInvalid');
    if (inline) {
        inline.textContent = (translations[lang] && translations[lang].invalidUrl) ? translations[lang].invalidUrl : '';
    }
    // set hintBox strong/desc if present (already handled by data-translate)
}

// server-side invalid flag -> show inline message accordingly
var serverInvalid = <?php echo (isset($invalid_url) && $invalid_url) ? 'true' : 'false'; ?>;

// determine initial lang and apply translations on DOMContentLoaded
document.addEventListener('DOMContentLoaded', () => {
    const lang = getBrowserLang();
    applyTranslations(lang);
    // show server-side invalid message if needed
    if (serverInvalid) {
        const inline = document.getElementById('inlineInvalid');
        if (inline) inline.style.display = 'block';
        const hint = document.getElementById('hintBox');
        if (hint) hint.style.display = 'block';
    }
});
// client-side validation: check URL and show inline message
function checkUrl() {
    const inputEl = document.getElementById('urlInput') || document.querySelector('input[name="url"]');
    const input = inputEl ? inputEl.value.trim() : '';
    const lang = currentLang || getBrowserLang();
    const regex = /^https?:\/\//i;

    const inline = document.getElementById('inlineInvalid');
    if (!regex.test(input)) {
        if (inline) {
            inline.textContent = (translations[lang] && translations[lang].invalidUrl) ? translations[lang].invalidUrl : 'Invalid format';
            inline.style.display = 'block';
        } else {
            alert((translations[lang] && translations[lang].invalidUrl) ? translations[lang].invalidUrl : 'Invalid format');
        }
        return false;
    }
    // hide inline if valid
    if (inline) inline.style.display = 'none';
    return true;
}

// attach to form submit
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('redirectForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!checkUrl()) {
                e.preventDefault();
            }
        }, false);
    }
});


let currentTheme = 'system';
let currentLang = 'ko';

const themeBtn = document.getElementById('themeBtn');
const themeMenu = document.getElementById('themeMenu');
const themeIcon = document.getElementById('themeIcon');
const langBtn = document.getElementById('langBtn');
const langMenu = document.getElementById('langMenu');
const langIcon = document.getElementById('langIcon');

// Helpers
function applyTheme(theme) {
    currentTheme = theme;
    const body = document.body;
    if (theme === 'system') {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        body.setAttribute('data-theme', prefersDark ? 'dark' : 'light');
        themeIcon.textContent = 'radio_button_partial';
    } else {
        body.setAttribute('data-theme', theme);
        themeIcon.textContent = theme === 'dark' ? 'dark_mode' : 'light_mode';
    }
    document.querySelectorAll('#themeMenu [data-theme]').forEach(item => {
        item.classList.toggle('active', item.dataset.theme === theme);
    });
    localStorage.setItem('theme', theme);
}

function applyLanguage(lang) {
    currentLang = lang;
    document.documentElement.lang = lang;
    document.querySelectorAll('[data-translate]').forEach(el => {
        const key = el.getAttribute('data-translate');
        if (translations[lang] && translations[lang][key]) el.innerHTML = translations[lang][key];
    });
    document.querySelectorAll('#langMenu [data-lang]').forEach(item => {
        item.classList.toggle('active', item.dataset.lang === lang);
    });
    localStorage.setItem('language', lang);
}

function isValidUrl(u) {
    try {
        const parsed = new URL(u);
        return !!parsed.protocol && (parsed.protocol === 'http:' || parsed.protocol === 'https:');
    } catch (e) { return false; }
}

// Init
document.addEventListener('DOMContentLoaded', function() {
    // Load saved settings
    applyTheme(localStorage.getItem('theme') || 'system');
    applyLanguage(localStorage.getItem('language') || 'ko');

    // If page opened with ?url= and was invalid, focus input
    const urlInput = document.getElementById('urlInput');
    const err = document.getElementById('errorText');
    <?php if (isset($invalid_url) && $invalid_url): ?>
        err.style.display = 'block';
        urlInput.focus();
    <?php endif; ?>

    // Submit handler (client-side validation)
    const form = document.getElementById('redirectForm');
    form.addEventListener('submit', function(e) {
        const value = urlInput.value.trim();
        if (!isValidUrl(value)) {
            e.preventDefault();
            err.style.display = 'block';
            return false;
        }
        // Allow GET submit to index.php?url=...; server will redirect.
        err.style.display = 'none';
        return true;
    });
});

// Toggle via buttons
themeBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    const order = ['system', 'light', 'dark'];
    let nextIndex = (order.indexOf(currentTheme) + 1) % order.length;
    applyTheme(order[nextIndex]);
});
langBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    const langs = ['ko', 'en', 'ja', 'zh-CN', 'zh-TW', 'es', 'fr', 'de', 'ru', 'ar', 'pt'];
    let nextIndex = (langs.indexOf(currentLang) + 1) % langs.length;
    applyLanguage(langs[nextIndex]);
});
themeMenu.addEventListener('click', (e) => {
    const item = e.target.closest('[data-theme]');
    if (item) applyTheme(item.dataset.theme);
});
langMenu.addEventListener('click', (e) => {
    const item = e.target.closest('[data-lang]');
    if (item) applyLanguage(item.dataset.lang);
});
document.addEventListener('click', () => {
    themeMenu.classList.remove('active');
    langMenu.classList.remove('active');
});
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
    if (currentTheme === 'system') applyTheme('system');
});
</script>
</body>
</html>
