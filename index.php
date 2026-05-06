<!DOCTYPE html>
<html lang="ru" data-theme="night">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://rafail1982.ru/ES/favicon.png" rel="icon" type="image/x-icon" />
    <title>Музыкальная галерея</title>
    <style>
        /* ─── CSS-переменные для тем ─── */
        :root {
            --bg-gradient:      linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --card-bg:          #ffffff;
            --card-shadow:      rgba(0,0,0,0.12);
            --card-shadow-h:    rgba(0,0,0,0.28);
            --card-active-bg:   rgba(40,44,52,0.95);
            --card-active-info: rgba(30,34,42,0.90);
            --track-info-bg:    rgba(255,255,255,0.82);
            --text-primary:     #333;
            --text-secondary:   #666;
            --text-muted:       #888;
            --player-bg:        rgba(255,255,255,0.96);
            --player-border:    #e0e0e0;
            --player-color:     #333;
            --progress-track:   #e0e0e0;
            --accent:           #667eea;
            --accent2:          #764ba2;
            --toggle-bg:        rgba(255,255,255,0.25);
            --toggle-icon:      "☀️";
        }

        [data-theme="night"] {
            --bg-gradient:      linear-gradient(135deg, #0f0c29 0%, #1a1a3e 50%, #24243e 100%);
            --card-bg:          #1c1f33;
            --card-shadow:      rgba(0,0,0,0.45);
            --card-shadow-h:    rgba(0,0,0,0.65);
            --card-active-bg:   rgba(15,18,35,0.97);
            --card-active-info: rgba(10,13,28,0.92);
            --track-info-bg:    rgba(18,21,40,0.88);
            --text-primary:     #dde2f5;
            --text-secondary:   #9aa0c0;
            --text-muted:       #6a718f;
            --player-bg:        rgba(10,12,28,0.97);
            --player-border:    #252a45;
            --player-color:     #dde2f5;
            --progress-track:   #252a45;
            --accent:           #7c8ff5;
            --accent2:          #9b6fd4;
            --toggle-bg:        rgba(255,255,255,0.1);
            --toggle-icon:      "🌙";
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: var(--bg-gradient);
            min-height: 100vh;
            padding-bottom: 120px;
            transition: background 0.4s ease;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* ─── Шапка ─── */
        .header {
            text-align: center;
            color: white;
            margin-bottom: 30px;
            position: relative;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        /* ─── Переключатель темы ─── */
        .theme-toggle {
            position: absolute;
            top: 0;
            right: 0;
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--toggle-bg);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 30px;
            padding: 6px 14px;
            cursor: pointer;
            color: white;
            font-size: 0.9em;
            transition: background 0.3s, transform 0.15s;
            user-select: none;
            backdrop-filter: blur(6px);
        }

        .theme-toggle:hover {
            background: rgba(255,255,255,0.22);
            transform: scale(1.04);
        }

        .theme-toggle:active {
            transform: scale(0.97);
        }

        .theme-toggle-icon {
            font-size: 1.2em;
            line-height: 1;
            transition: transform 0.4s ease;
        }

        /* ─── Сетка треков ─── */
        .tracks-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .track-card {
            background: var(--card-bg);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 25px var(--card-shadow);
            transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.3s ease;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
            overflow: hidden;
            will-change: transform;
        }

        .track-card-background {
            position: absolute;
            inset: -10px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(15px) brightness(0.6);
            z-index: 0;
            opacity: 0.55;
            transition: opacity 0.25s ease;
        }

        .track-card:hover .track-card-background { opacity: 0.75; }

        .track-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px var(--card-shadow-h);
        }

        .track-card.active {
            border: 3px solid var(--accent);
            background: var(--card-active-bg);
            box-shadow: 0 15px 35px var(--card-shadow-h);
        }

        .track-card.active .track-info {
            background: var(--card-active-info);
            color: white;
        }

        .track-card.active .track-title {
            color: #fff;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
        }

        .track-card.active .track-details,
        .track-card.active .track-date {
            color: #c8cce8;
        }

        .track-card-content {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .track-image-container {
            width: 100%;
            height: 200px;
            border-radius: 12px;
            margin-bottom: 15px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(8px);
            border: 2px solid rgba(255,255,255,0.15);
        }

        .track-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 10px;
        }

        .track-info {
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: var(--track-info-bg);
            backdrop-filter: blur(5px);
            border-radius: 10px;
            padding: 15px;
            margin: 0 -5px 10px;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .track-title {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 8px;
            color: var(--text-primary);
            word-break: break-word;
            line-height: 1.3;
        }

        .track-details {
            color: var(--text-secondary);
            font-size: 0.9em;
            margin-bottom: 5px;
        }

        .track-date {
            color: var(--text-muted);
            font-size: 0.8em;
        }

        .track-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 10px;
            position: relative;
            z-index: 3;
        }

        .track-btn {
            background: var(--accent);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.9em;
            transition: background 0.2s ease, transform 0.15s ease;
            display: flex;
            align-items: center;
            gap: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .track-btn:hover {
            background: var(--accent2);
            transform: scale(1.05);
        }

        .track-btn.copy-btn { background: #48bb78; }
        .track-btn.copy-btn:hover { background: #38a169; }

        /* ─── Плеер ─── */
        .player {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--player-bg);
            backdrop-filter: blur(12px);
            padding: 20px;
            box-shadow: 0 -5px 25px rgba(0,0,0,0.2);
            border-top: 1px solid var(--player-border);
            z-index: 1000;
            transition: background 0.3s ease, border-color 0.3s ease;
        }

        .player-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .player-info {
            flex: 1;
            min-width: 0;
        }

        .player-track-title {
            font-weight: bold;
            font-size: 1.1em;
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: var(--player-color);
        }

        .player-track-details {
            color: var(--text-secondary);
            font-size: 0.9em;
            margin-bottom: 5px;
        }

        .progress-container {
            flex: 2;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .time-display {
            font-size: 0.9em;
            color: var(--text-secondary);
            min-width: 50px;
            text-align: center;
        }

        .progress-bar {
            flex: 1;
            height: 6px;
            background: var(--progress-track);
            border-radius: 3px;
            cursor: pointer;
            position: relative;
        }

        .progress {
            height: 100%;
            background: var(--accent);
            border-radius: 3px;
            width: 0%;
            /* убрали transition — обновляется через rAF, плавно само по себе */
        }

        .controls {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .control-btn {
            background: none;
            border: none;
            font-size: 1.5em;
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: background 0.2s ease;
            color: var(--accent);
        }

        .control-btn:hover {
            background: rgba(102,126,234,0.12);
        }

        .play-btn { font-size: 2em; }

        .hidden { display: none; }

        .no-tracks {
            text-align: center;
            color: white;
            font-size: 1.2em;
            padding: 40px;
        }

        /* ─── Toast ─── */
        .toast {
            position: fixed;
            bottom: 150px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.82);
            color: white;
            padding: 12px 24px;
            border-radius: 30px;
            font-size: 0.9em;
            z-index: 2000;
            pointer-events: none;
            animation: fadeInOut 2s ease forwards;
        }

        @keyframes fadeInOut {
            0%   { opacity: 0; transform: translate(-50%, 20px); }
            15%  { opacity: 1; transform: translate(-50%, 0); }
            85%  { opacity: 1; transform: translate(-50%, 0); }
            100% { opacity: 0; transform: translate(-50%, -20px); }
        }

        /* ─── Адаптив ─── */
        @media (max-width: 768px) {
            .player-content   { flex-direction: column; gap: 15px; }
            .progress-container { width: 100%; }
            .tracks-grid      { grid-template-columns: 1fr; }
            .track-image-container { height: 180px; }
            .track-actions    { flex-direction: column; }
            .theme-toggle span.theme-label { display: none; }
        }

        @media (max-width: 480px) {
            .track-image-container { height: 160px; }
            .track-card       { padding: 15px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎵 Музыкальная галерея</h1>
            <p>Нажмите на трек для воспроизведения</p>

            <button class="theme-toggle" id="theme-toggle" title="Сменить тему" aria-label="Сменить тему">
                <span class="theme-toggle-icon" id="theme-icon">🌙</span>
                <span class="theme-label" id="theme-label">Дневная тема</span>
            </button>
        </div>

        <div class="tracks-grid" id="tracks-grid">
            <?php
            error_reporting(E_ALL & ~E_DEPRECATED);

            function formatFileSize($bytes) {
                if ($bytes == 0) return '0 B';
                $units = ['B', 'KB', 'MB', 'GB'];
                $pow   = min((int)floor(log(max($bytes, 1)) / log(1024)), count($units) - 1);
                return round($bytes / (1 << (10 * $pow)), 2) . ' ' . $units[$pow];
            }

            function getAudioDuration($filepath) {
                $size    = filesize($filepath);
                $bitrate = 128 * 1000;
                return round($size * 8 / $bitrate, 2);
            }

            function formatTime($seconds) {
                if ($seconds < 1) return '0:00';
                $m = (int)floor($seconds / 60);
                $s = (int)floor($seconds % 60);
                return $m . ':' . str_pad($s, 2, '0', STR_PAD_LEFT);
            }

            /* ── Сканируем директорию один раз ── */
            $musicFiles = [];
            if (is_dir('.')) {
                foreach (scandir('.') as $file) {
                    if ($file === '.' || $file === '..' || $file === 'index.php') continue;
                    if (strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'mp3') {
                        $musicFiles[] = $file;
                    }
                }
            }

            shuffle($musicFiles);

            if (empty($musicFiles)) {
                echo '<div class="no-tracks">Музыкальные файлы не найдены</div>';
            } else {
                /* ── Собираем данные о треках один раз ── */
                $tracksData = [];
                foreach ($musicFiles as $file) {
                    if (!file_exists($file)) continue;
                    $name     = pathinfo($file, PATHINFO_FILENAME);
                    $size     = filesize($file);
                    $filetime = filemtime($file);
                    $duration = getAudioDuration($file);
                    $img      = file_exists($name . '.png')
                                ? $name . '.png'
                                : 'https://rafail1982.ru/ES/favicon.png';

                    $tracksData[] = [
                        'name'     => $name,
                        'size'     => formatFileSize($size),
                        'date'     => date('d.m.Y H:i', $filetime),
                        'duration' => $duration,
                        'url'      => $file,
                        'img'      => $img,
                    ];
                }

                /* ── Рендерим карточки ── */
                foreach ($tracksData as $i => $t) {
                    $eName = htmlspecialchars($t['name']);
                    $eUrl  = htmlspecialchars($t['url']);
                    $eSize = htmlspecialchars($t['size']);
                    $eDate = htmlspecialchars($t['date']);
                    $eImg  = htmlspecialchars($t['img']);
                    echo <<<HTML
                    <div class="track-card" data-track-index="{$i}">
                        <div class="track-card-background" style="background-image:url('{$eImg}')"></div>
                        <div class="track-card-content">
                            <div class="track-image-container">
                                <img src="{$eImg}" alt="{$eName}" class="track-image" loading="lazy" decoding="async">
                            </div>
                            <div class="track-info">
                                <div class="track-title">{$eName}</div>
                                <div class="track-details">{$eSize}</div>
                                <div class="track-date">📅 {$eDate}</div>
                            </div>
                            <div class="track-actions">
                                <button class="track-btn download-btn" data-action="download" data-url="{$eUrl}" data-name="{$eName}.mp3">
                                    ⬇️ Скачать
                                </button>
                                <button class="track-btn copy-btn" data-action="copy" data-url="{$eUrl}">
                                    📋 Копировать
                                </button>
                            </div>
                        </div>
                    </div>
HTML;
                }

                /* ── Передаём данные в JS одним массивом ── */
                $jsData = array_map(function($t) {
                    return [
                        'name'     => $t['name'],
                        'size'     => $t['size'],
                        'date'     => $t['date'],
                        'duration' => $t['duration'],
                        'url'      => $t['url'],
                    ];
                }, $tracksData);

                echo '<script>window.tracks = ' . json_encode($jsData, JSON_UNESCAPED_UNICODE) . ';</script>';
            }
            ?>
        </div>
    </div>

    <!-- Плеер -->
    <div class="player hidden" id="player">
        <div class="player-content">
            <div class="player-info">
                <div class="player-track-title"  id="player-track-title">Выберите трек</div>
                <div class="player-track-details" id="player-track-details">-</div>
            </div>
            <div class="progress-container">
                <div class="time-display" id="current-time">0:00</div>
                <div class="progress-bar"  id="progress-bar">
                    <div class="progress"  id="progress"></div>
                </div>
                <div class="time-display" id="total-time">0:00</div>
            </div>
            <div class="controls">
                <button class="control-btn"       id="prev-btn">⏮</button>
                <button class="control-btn play-btn" id="play-btn">▶</button>
                <button class="control-btn"       id="next-btn">⏭</button>
            </div>
        </div>
    </div>

    <script>
    /* ═══════════════════════════════════════════
       Переключатель темы (ночная по умолчанию)
    ═══════════════════════════════════════════ */
    (function () {
        const root   = document.documentElement;
        const btn    = document.getElementById('theme-toggle');
        const icon   = document.getElementById('theme-icon');
        const label  = document.getElementById('theme-label');

        // Ночная тема по умолчанию; читаем сохранённое значение
        const saved = localStorage.getItem('theme') || 'night';
        applyTheme(saved);

        btn.addEventListener('click', function () {
            const next = root.dataset.theme === 'night' ? 'day' : 'night';
            applyTheme(next);
            localStorage.setItem('theme', next);
        });

        function applyTheme(theme) {
            root.dataset.theme = theme;
            if (theme === 'night') {
                icon.textContent  = '🌙';
                label.textContent = 'Дневная тема';
            } else {
                icon.textContent  = '☀️';
                label.textContent = 'Ночная тема';
            }
        }
    })();

    /* ═══════════════════════════════════════════
       Музыкальный плеер
    ═══════════════════════════════════════════ */
    class MusicPlayer {
        constructor() {
            this.audio             = new Audio();
            this.audio.preload     = 'metadata';
            this.isPlaying         = false;
            this.currentIndex      = -1;
            this.tracks            = window.tracks || [];
            this.activeCard        = null;   // ссылка на активную карточку
            this._rafId            = null;   // requestAnimationFrame id

            this.el = {
                player:      document.getElementById('player'),
                playBtn:     document.getElementById('play-btn'),
                prevBtn:     document.getElementById('prev-btn'),
                nextBtn:     document.getElementById('next-btn'),
                progress:    document.getElementById('progress'),
                progressBar: document.getElementById('progress-bar'),
                currentTime: document.getElementById('current-time'),
                totalTime:   document.getElementById('total-time'),
                trackTitle:  document.getElementById('player-track-title'),
                trackDetails:document.getElementById('player-track-details'),
                grid:        document.getElementById('tracks-grid'),
            };

            this._init();
        }

        _init() {
            const { el, audio } = this;

            /* Кнопки плеера */
            el.playBtn.addEventListener('click', () => this.togglePlay());
            el.prevBtn.addEventListener('click', () => this.previousTrack());
            el.nextBtn.addEventListener('click', () => this.nextTrack());

            /* Прогресс-бар */
            el.progressBar.addEventListener('click', e => this._seek(e));

            /* События аудио */
            audio.addEventListener('loadedmetadata', () => {
                if (isFinite(audio.duration)) {
                    el.totalTime.textContent = this._fmt(audio.duration);
                }
            });
            audio.addEventListener('ended', () => this.nextTrack());
            audio.addEventListener('error', () => this.showToast('Ошибка воспроизведения файла'));

            /* Делегирование событий на сетку треков */
            el.grid.addEventListener('click', e => {
                /* Кнопка скачать */
                const dlBtn = e.target.closest('[data-action="download"]');
                if (dlBtn) {
                    e.stopPropagation();
                    this._download(dlBtn.dataset.url, dlBtn.dataset.name);
                    return;
                }
                /* Кнопка копировать */
                const cpBtn = e.target.closest('[data-action="copy"]');
                if (cpBtn) {
                    e.stopPropagation();
                    this._copyUrl(cpBtn.dataset.url);
                    return;
                }
                /* Клик по карточке */
                const card = e.target.closest('.track-card');
                if (card) {
                    this.playTrack(parseInt(card.dataset.trackIndex, 10));
                }
            });
        }

        playTrack(index) {
            const tracks = this.tracks;
            if (index < 0 || index >= tracks.length) return;

            const track = tracks[index];
            if (!track) return;

            this.currentIndex = index;

            /* Обновляем плеер */
            this.el.trackTitle.textContent  = track.name;
            this.el.trackDetails.textContent = `${track.size} • ${track.date}`;
            this.el.totalTime.textContent   = this._fmt(track.duration);

            /* Меняем источник */
            this.audio.src = track.url;

            /* Показываем плеер */
            this.el.player.classList.remove('hidden');

            /* Активная карточка — только одна операция с DOM */
            this.activeCard?.classList.remove('active');
            const card = this.el.grid.querySelector(`.track-card[data-track-index="${index}"]`);
            if (card) {
                card.classList.add('active');
                this.activeCard = card;
                card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }

            this._play();
        }

        _play() {
            this.audio.play().then(() => {
                this.isPlaying = true;
                this.el.playBtn.textContent = '⏸';
                this._startRaf();
            }).catch(() => {
                this.showToast('Не удалось воспроизвести файл');
            });
        }

        _pause() {
            this.audio.pause();
            this.isPlaying = false;
            this.el.playBtn.textContent = '▶';
            this._stopRaf();
        }

        togglePlay() {
            if (!this.audio.src) {
                if (this.tracks.length > 0) this.playTrack(0);
                return;
            }
            this.isPlaying ? this._pause() : this._play();
        }

        previousTrack() {
            if (!this.tracks.length) return;
            const n = this.currentIndex <= 0 ? this.tracks.length - 1 : this.currentIndex - 1;
            this.playTrack(n);
        }

        nextTrack() {
            if (!this.tracks.length) return;
            const n = (this.currentIndex + 1) >= this.tracks.length ? 0 : this.currentIndex + 1;
            this.playTrack(n);
        }

        /* rAF-цикл для прогресс-бара (вместо timeupdate) */
        _startRaf() {
            if (this._rafId) return;
            const tick = () => {
                const { audio, el } = this;
                if (audio.duration && isFinite(audio.duration)) {
                    const pct = (audio.currentTime / audio.duration) * 100;
                    el.progress.style.width      = pct + '%';
                    el.currentTime.textContent   = this._fmt(audio.currentTime);
                }
                this._rafId = this.isPlaying ? requestAnimationFrame(tick) : null;
            };
            this._rafId = requestAnimationFrame(tick);
        }

        _stopRaf() {
            if (this._rafId) { cancelAnimationFrame(this._rafId); this._rafId = null; }
        }

        _seek(e) {
            if (!this.audio.duration || !isFinite(this.audio.duration)) return;
            const rect = this.el.progressBar.getBoundingClientRect();
            this.audio.currentTime = ((e.clientX - rect.left) / rect.width) * this.audio.duration;
        }

        _fmt(s) {
            if (isNaN(s) || !isFinite(s)) return '0:00';
            const m = Math.floor(s / 60);
            const sec = Math.floor(s % 60);
            return m + ':' + String(sec).padStart(2, '0');
        }

        _download(url, filename) {
            const a = document.createElement('a');
            a.href = url; a.download = filename;
            a.click();
            this.showToast(`Скачивание: ${filename}`);
        }

        _copyUrl(url) {
            navigator.clipboard.writeText(location.origin + '/' + url)
                .then(() => this.showToast('Адрес файла скопирован!'))
                .catch(()  => this.showToast('Ошибка копирования'));
        }

        showToast(msg) {
            const t = document.createElement('div');
            t.className = 'toast';
            t.textContent = msg;
            document.body.appendChild(t);
            setTimeout(() => t.remove(), 2100);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        window.musicPlayer = new MusicPlayer();
    });
    </script>

    <script src="/$off.js"></script>
</body>
</html>
