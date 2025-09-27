<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pomodoro Timer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h1 class="h4 mb-0">Pomodoro Timer</h1>
                            <span class="badge text-bg-success" id="badgeMode">Focus</span>
                        </div>

                        <ul class="nav nav-pills gap-2 mb-3" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" data-mode="focus" type="button">Focus</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-mode="short" type="button">Short Break</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-mode="long" type="button">Long Break</button>
                            </li>
                        </ul>

                        <div class="text-center my-3">
                            <div class="display-3 fw-bold font-monospace" id="time">25:00</div>
                            <div class="text-muted small">cycle <span id="cycleNow">0</span>/<span
                                    id="cycleMax">4</span></div>
                        </div>

                        <div class="mb-3">
                            <div class="progress" role="progressbar" aria-label="Progress" style="height:.75rem;">
                                <div class="progress-bar bg-success" id="progressBar" style="width:0%"></div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2 justify-content-center mb-3">
                            <button class="btn btn-primary d-inline-flex align-items-center" id="btnStart"
                                type="button">
                                <i class="bi bi-play-fill me-2"></i><span>Start</span>
                            </button>
                            <button class="btn btn-outline-secondary d-inline-flex align-items-center" id="btnReset"
                                type="button">
                                <i class="bi bi-arrow-counterclockwise me-2"></i>Reset
                            </button>
                            <button class="btn btn-outline-secondary d-inline-flex align-items-center" id="btnSkip"
                                type="button">
                                <i class="bi bi-skip-end-fill me-2"></i>Next
                            </button>
                            <button class="btn btn-outline-dark d-inline-flex align-items-center" id="btnSettings"
                                data-bs-toggle="collapse" data-bs-target="#settings" type="button">
                                <i class="bi bi-gear me-2"></i>Settings
                            </button>
                        </div>

                        <div class="collapse" id="settings">
                            <div class="bg-light rounded-3 border p-3">
                                <div class="row g-3">
                                    <div class="col-6 col-md-3">
                                        <label class="form-label small">Focus (min)</label>
                                        <input type="number" class="form-control" id="inputFocus" min="1"
                                            max="180" value="25">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label class="form-label small">Short (min)</label>
                                        <input type="number" class="form-control" id="inputShort" min="1"
                                            max="60" value="5">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label class="form-label small">Long (min)</label>
                                        <input type="number" class="form-control" id="inputLong" min="1"
                                            max="120" value="15">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label class="form-label small">Cycles → Long</label>
                                        <input type="number" class="form-control" id="inputCycles" min="2"
                                            max="12" value="4">
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="optAuto" checked>
                                            <label class="form-check-label" for="optAuto">Auto-start next</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="optBeep" checked>
                                            <label class="form-check-label" for="optBeep">Beep</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="optNotify">
                                            <label class="form-check-label" for="optNotify">Desktop
                                                notification</label>
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex gap-2">
                                        <button class="btn btn-success d-inline-flex align-items-center"
                                            id="btnSave">
                                            <i class="bi bi-check2-circle me-2"></i>Save Settings
                                        </button>
                                        <button class="btn btn-outline-secondary" id="btnDefaults">Defaults</button>
                                    </div>
                                </div>
                                <div class="text-muted small mt-2">Hotkeys: <kbd>Space</kbd> Start/Pause, <kbd>→</kbd>
                                    Skip</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div class="toast align-items-center text-bg-dark border-0" id="toastDone" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body" id="toastMsg">Done</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        (() => {
            const $ = s => document.querySelector(s);
            const $$ = s => [...document.querySelectorAll(s)];
            const timeEl = $('#time');
            const progressBar = $('#progressBar');
            const badgeMode = $('#badgeMode');
            const cycleNowEl = $('#cycleNow'),
                cycleMaxEl = $('#cycleMax');
            const modeBtns = $$('.nav-link[data-mode]');
            const btnStart = $('#btnStart'),
                btnReset = $('#btnReset'),
                btnSkip = $('#btnSkip');
            const inputFocus = $('#inputFocus'),
                inputShort = $('#inputShort'),
                inputLong = $('#inputLong'),
                inputCycles = $('#inputCycles');
            const optAuto = $('#optAuto'),
                optBeep = $('#optBeep'),
                optNotify = $('#optNotify');
            const btnSave = $('#btnSave'),
                btnDefaults = $('#btnDefaults');
            const toastEl = $('#toastDone'),
                toastMsg = $('#toastMsg');
            const STORAGE_KEY = 'pomodoro:v1';
            const MODES = {
                focus: 'focus',
                short: 'short',
                long: 'long'
            };
            const defaults = {
                focusMin: 25,
                shortMin: 5,
                longMin: 15,
                cyclesToLong: 4,
                autoNext: true,
                beep: true,
                notify: false
            };

            let settings = loadSettings();
            applySettingsUI();

            let state = {
                mode: MODES.focus,
                totalSec: settings.focusMin * 60,
                remainSec: settings.focusMin * 60,
                running: false,
                cycleDone: 0,
                ticker: null
            };

            cycleMaxEl.textContent = settings.cyclesToLong;
            applyTheme();
            render();

            modeBtns.forEach(b => b.addEventListener('click', () => switchMode(b.getAttribute('data-mode'), true)));
            btnStart.addEventListener('click', toggleStart);

            btnReset.addEventListener('click', (e) => {
                e.preventDefault();
                hardResetToStart();
            });

            btnSkip.addEventListener('click', finishSession);
            document.addEventListener('keydown', e => {
                if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
                if (e.code === 'Space') {
                    e.preventDefault();
                    toggleStart();
                }
                if (e.code === 'ArrowRight') {
                    e.preventDefault();
                    finishSession();
                }
            });

            btnSave.addEventListener('click', saveSettings);

            btnDefaults.addEventListener('click', () => {
                settings = {
                    ...defaults
                };
                applySettingsUI();
                saveSettings();
            });

            optNotify.addEventListener('change', async () => {
                if (optNotify.checked && 'Notification' in window) {
                    try {
                        await Notification.requestPermission();
                    } catch {}
                }
            });

            function toggleStart() {
                state.running ? pause() : start();
            }

            function start() {
                if (state.running) return;
                state.running = true;
                setStartBtnUI(true);
                state.ticker = setInterval(tick, 1000);
            }

            function pause() {
                state.running = false;
                setStartBtnUI(false);
                clearInterval(state.ticker);
                state.ticker = null;
                render();
            }

            function tick() {
                state.remainSec = Math.max(0, state.remainSec - 1);
                render();
                if (state.remainSec === 0) {
                    pause();
                    finishSession();
                }
            }

            function finishSession() {
                if (settings.beep) beep();
                if (settings.notify && 'Notification' in window && Notification.permission === 'granted') {
                    const msg = state.mode === MODES.focus ? 'Focus selesai! Waktu rehat.' :
                        'Istirahat selesai! Saatnya fokus.';
                    try {
                        new Notification('Pomodoro', {
                            body: msg
                        });
                    } catch {}
                }
                showToast(state.mode === MODES.focus ? 'Focus selesai — Short/Long Break dimulai.' :
                    'Break selesai — saatnya Focus.');

                if (state.mode === MODES.focus) {
                    state.cycleDone += 1;
                    if (state.cycleDone % settings.cyclesToLong === 0) switchMode(MODES.long);
                    else switchMode(MODES.short);
                } else {
                    switchMode(MODES.focus);
                }
                if (settings.autoNext) start();
            }

            function switchMode(mode, manual = false) {
                state.mode = mode;
                state.totalSec = (mode === MODES.focus ? settings.focusMin :
                    mode === MODES.short ? settings.shortMin :
                    settings.longMin) * 60;
                state.remainSec = state.totalSec;
                highlightPill();
                applyTheme();
                render();
            }

            function resetTo(mode) {
                pause();
                state.cycleDone = 0;
                switchMode(mode);
            }

            function hardResetToStart() {
                pause();
                state.cycleDone = 0;
                state.mode = MODES.focus;
                state.totalSec = settings.focusMin * 60;
                state.remainSec = state.totalSec;
                highlightPill();
                applyTheme();
                render();
            }


            function render() {
                timeEl.textContent = fmt(state.remainSec);
                document.title = `${fmt(state.remainSec)} • ${labelOf(state.mode)}${state.running ? ' ⏱️' : ''}`;

                const c = state.cycleDone;
                cycleNowEl.textContent = (c === 0) ? 0 : (c % settings.cyclesToLong || settings.cyclesToLong);
                cycleMaxEl.textContent = settings.cyclesToLong;

                const p = 1 - (state.remainSec / state.totalSec || 0);
                progressBar.style.width = `${(p*100).toFixed(2)}%`;
            }

            function applyTheme() {
                badgeMode.textContent = labelOf(state.mode);
                progressBar.classList.remove('bg-success', 'bg-info', 'bg-warning');
                if (state.mode === MODES.focus) {
                    badgeMode.className = 'badge text-bg-success';
                    progressBar.classList.add('bg-success');
                } else if (state.mode === MODES.short) {
                    badgeMode.className = 'badge text-bg-info';
                    progressBar.classList.add('bg-info');
                } else {
                    badgeMode.className = 'badge text-bg-warning';
                    progressBar.classList.add('bg-warning');
                }
            }

            function highlightPill() {
                modeBtns.forEach(b => b.classList.toggle('active', b.getAttribute('data-mode') === state.mode));
            }

            function setStartBtnUI(running) {
                const icon = btnStart.querySelector('i');
                const label = btnStart.querySelector('span');
                if (running) {
                    icon.className = 'bi bi-pause-fill me-2';
                    label.textContent = 'Pause';
                } else {
                    icon.className = 'bi bi-play-fill me-2';
                    label.textContent = 'Start';
                }
            }

            function labelOf(m) {
                return m === MODES.focus ? 'Focus' : (m === MODES.short ? 'Short Break' : 'Long Break');
            }

            function fmt(sec) {
                const m = Math.floor(sec / 60).toString().padStart(2, '0');
                const s = (sec % 60).toString().padStart(2, '0');
                return `${m}:${s}`;
            }

            function showToast(msg) {
                if (!toastEl) return;
                toastMsg.textContent = msg;
                try {
                    if (window.bootstrap?.Toast) {
                        const t = bootstrap.Toast.getOrCreateInstance(toastEl, {
                            delay: 2500
                        });
                        t.show();
                    } else {
                        console.log('Toast:', msg);
                    }
                } catch {}
            }

            let audioCtx;

            function beep() {
                try {
                    audioCtx = audioCtx || new(window.AudioContext || window.webkitAudioContext)();
                    const o = audioCtx.createOscillator();
                    const g = audioCtx.createGain();
                    o.type = 'sine';
                    o.frequency.value = 880;
                    o.connect(g);
                    g.connect(audioCtx.destination);
                    const t = audioCtx.currentTime;
                    g.gain.setValueAtTime(0.0001, t);
                    g.gain.exponentialRampToValueAtTime(0.25, t + 0.02);
                    g.gain.exponentialRampToValueAtTime(0.0001, t + 0.9);
                    o.start(t);
                    o.stop(t + 0.9);
                } catch {}
            }

            function loadSettings() {
                try {
                    return {
                        ...defaults,
                        ...(JSON.parse(localStorage.getItem(STORAGE_KEY)) || {})
                    };
                } catch {
                    return {
                        ...defaults
                    };
                }
            }

            function saveSettings() {
                const v = {
                    focusMin: toInt(inputFocus.value, defaults.focusMin),
                    shortMin: toInt(inputShort.value, defaults.shortMin),
                    longMin: toInt(inputLong.value, defaults.longMin),
                    cyclesToLong: toInt(inputCycles.value, defaults.cyclesToLong),
                    autoNext: !!optAuto.checked,
                    beep: !!optBeep.checked,
                    notify: !!optNotify.checked
                };
                settings = v;
                localStorage.setItem(STORAGE_KEY, JSON.stringify(v));
                switchMode(state.mode);
            }

            function applySettingsUI() {
                inputFocus.value = settings.focusMin;
                inputShort.value = settings.shortMin;
                inputLong.value = settings.longMin;
                inputCycles.value = settings.cyclesToLong;
                optAuto.checked = settings.autoNext;
                optBeep.checked = settings.beep;
                optNotify.checked = settings.notify;
            }

            function toInt(x, d) {
                const n = parseInt(x, 10);
                return Number.isFinite(n) && n > 0 ? n : d;
            }
        })();
    </script>
</body>

</html>
