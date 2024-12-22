
<div id="music-player" class="fixed-bottom bg-dark text-white p-3 border-top border-secondary border-1">
    <div class="container">
        <div class="row align-items-center">
            <!-- Info musique en cours -->
            <div class="col-3">
                <div class="d-flex align-items-center">
                    <img id="current-song-img" src="" alt="" class="rounded" style="width: 56px; height: 56px;">
                    <div class="ms-2">
                        <div id="current-song-title" class="fw-bold"></div>
                        <div id="current-song-artist" class="text-muted small"></div>
                    </div>
                </div>
            </div>

            <!-- Contrôles -->
            <div class="col-6 text-center">
                <audio id="global-audio-player"></audio>
                <div class="mb-2">
                    <button class="btn btn-link text-white" onclick="player.togglePlayPause()" id="playPauseBtn">
                        <i class="bi bi-play"></i>
                    </button>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span id="currentTime">0:00</span>
                    <input type="range" class="form-range flex-grow-1" id="seekBar" value="0">
                    <span id="duration">0:00</span>
                </div>
            </div>

            <!-- Volume -->
            <div class="col-3 text-end">
                <input type="range" class="form-range w-50" id="volumeControl" min="0" max="1" step="0.1" value="1">
            </div>
        </div>
    </div>
</div>

<script>
const player = {
    audio: document.getElementById('global-audio-player'),
    playPauseBtn: document.getElementById('playPauseBtn'),
    seekBar: document.getElementById('seekBar'),
    volumeControl: document.getElementById('volumeControl'),
    currentTimeEl: document.getElementById('currentTime'),
    durationEl: document.getElementById('duration'),
    currentSongImg: document.getElementById('current-song-img'),
    currentSongTitle: document.getElementById('current-song-title'),
    currentSongArtist: document.getElementById('current-song-artist'),

    init() {
        this.audio.addEventListener('timeupdate', () => this.updateSeekBar());
        this.audio.addEventListener('loadedmetadata', () => this.updateDuration());
        this.seekBar.addEventListener('change', () => this.seek());
        this.volumeControl.addEventListener('input', (e) => this.setVolume(e.target.value));
    },

    playSong(src, title, artist, imgSrc) {
        this.audio.src = src;
        this.audio.play();
        this.playPauseBtn.innerHTML = '<i class="bi bi-pause"></i>';
        this.currentSongTitle.textContent = title;
        this.currentSongArtist.textContent = artist;
        this.currentSongImg.src = imgSrc;
    },

    togglePlayPause() {
        if (this.audio.paused) {
            this.audio.play();
            this.playPauseBtn.innerHTML = '<i class="bi bi-pause"></i>';
        } else {
            this.audio.pause();
            this.playPauseBtn.innerHTML = '<i class="bi bi-play"></i>';
        }
    },

    updateSeekBar() {
        const percent = (this.audio.currentTime / this.audio.duration) * 100;
        this.seekBar.value = percent;
        this.currentTimeEl.textContent = this.formatTime(this.audio.currentTime);
    },

    seek() {
        const time = (this.seekBar.value / 100) * this.audio.duration;
        this.audio.currentTime = time;
    },

    setVolume(value) {
        this.audio.volume = value;
    },

    updateDuration() {
        this.durationEl.textContent = this.formatTime(this.audio.duration);
    },

    formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${mins}:${secs.toString().padStart(2, '0')}`;
    }
};

player.init();
</script>
