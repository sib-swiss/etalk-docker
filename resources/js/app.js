import "./bootstrap";

import "tw-elements";

import Alpine from "alpinejs";
window.Alpine = Alpine;

Alpine.data("etalkShow", (audioFiles = []) => ({
    status: null,
    wait: true,
    showTranscript: true,
    audioFiles: audioFiles,
    currentSnd: 0,
    currentUrl: "",

    init() {
        this.currentUrl = location.href + "#0";
        // console.log("I am called automatically");
        // setTimeout(() => {
        //     //this.play();
        // }, 100);
    },

    play() {
        this.wait = false;
        this.status = "play";
        this.$refs.player.play();
    },
    stop() {
        this.wait = true;
        this.status = "pause";
        this.$refs.player.pause();
    },
    pause() {
        this.status = "pause";
        this.$refs.player.pause();
    },
    canplay() {
        this.status = "canplay";
    },
    loadstart() {
        // console.log("loadstart");
    },
    startedPlay() {
        // console.log("startedPlay");
    },
    endedPlay() {
        // console.log("endedPlay");
        this.next();
    },
    errorHandler() {
        // console.log("errorHandler");
        // alert('The sound file \''+this.src+'\' could not be loaded.')
    },
    toggleMute() {
        this.$refs.player.muted = !this.$refs.player.muted;
        this.$el.src =
            "/i/audio_" + (this.$refs.player.muted ? "on" : "mute") + ".png";
    },

    next() {
        if (this.currentSnd < this.audioFiles.length - 1) {
            this.setCurrentSnd(parseInt(this.currentSnd, 10) + 1);
            this.play();
            return;
        }

        alert("End of the track.");
    },

    prev() {
        if (this.currentSnd > 0) {
            this.setCurrentSnd(parseInt(this.currentSnd, 10) - 1);
            this.play();
            return;
        }

        alert("Start of the track.");
    },

    setCurrentSnd(soundIndex) {
        this.currentSnd = soundIndex;
        location.hash = soundIndex;
        this.currentUrl = location.href;
        this.$refs.player.src =
            "/storage/data/" + audioFiles[this.currentSnd].name;

        if (
            this.$refs.suondFigure.src !=
            "/storage/tmp/" +
                encodeURIComponent(audioFiles[this.currentSnd].file)
        ) {
            this.$refs.suondFigure.classList.add("opacity-0");
            setTimeout(() => {
                this.$refs.suondFigure.src =
                    "/storage/tmp/" +
                    encodeURIComponent(audioFiles[this.currentSnd].file);
                this.$refs.suondFigure.classList.remove("opacity-0");
            }, 500);
        }

        let top = this.$refs["sound_" + soundIndex].offsetTop - 48;
        window.scrollTo({ top: top, behavior: "smooth" });
    },

    toggleMode() {
        this.showTranscript = !this.showTranscript;
    },
}));

Alpine.start();
