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

    init() {
        // console.log("I am called automatically");
        setTimeout(() => {
         //   this.play();
        }, 300);
    },

    play() {
        this.wait = false;
        this.status = "play";

        this.$refs.player.play();
        // $("#bPlay").hide();
        // document.getElementById("bPause").style.display = "inline";
        // player.play();
        // $("body.viewer").removeClass("paused");
        // $("#wait").fadeOut(function () {
        // });
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
        console.log("canplay");
        this.status = "canplay";
        // document.getElementById('loading').style.display='none';"
    },
    loadstart() {
        console.log("loadstart");
        // document.getElementById('loading').style.display='inline';"
    },
    startedPlay() {
        console.log("startedPlay");
        //$("html, body").animate({scrollTop: $("#a" + currentSnd).offset().top - 50}, 1e3)
        // TODO: find top position of current transcript
        //window.scrollTo({top: this.currentSnd*50, behavior: 'smooth'});
    },
    endedPlay() {
        console.log("endedPlay");
        this.next();
    },
    errorHandler() {
        console.log("errorHandler");
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
        this.$refs.player.src =
            "/storage/data/" + audioFiles[this.currentSnd].name;

        // set current class in relative VIZ > div

        this.$refs.suondFigure.src =
            "/storage/tmp/" + audioFiles[this.currentSnd].file;

        // currentSnd = e;
        // location.hash = e;
        // player.src = "/data/" + audioFiles[currentSnd].snd;
        // $("#viz a").removeClass("current");
        // $("#a" + currentSnd).addClass("current");
        // "/tmp/" + audioFiles[currentSnd]["pict"] != $("#diaPict").attr("src") && $("#dia>figure").fadeOut(kFadeDuration, function () {
        //     var e;
        //     if (audioFiles[currentSnd].pict !== "") {
        //         $("#diaPict").attr("src", "/tmp/" + audioFiles[currentSnd].pict);
        //         e = "";
        //         audioFiles[currentSnd].pict_cred.length > 0 ? e += "© " + audioFiles[currentSnd].pict_cred : e += audioFiles[currentSnd].pict_cred;
        //         audioFiles[currentSnd]["pict_link"] != "" && (e += '<br/><a href="' + audioFiles[currentSnd].pict_link + '" target="_blank">' + audioFiles[currentSnd].pict_link + "</a>");
        //         $("#dia>figure>figcaption").html(e);
        //         $("#dia>figure").fadeIn()
        //     }
        // });
        // $("#links").fadeOut(kFadeDuration, function () {
        //     if (audioFiles[currentSnd].link !== "") {
        //         $("#links").html(audioFiles[currentSnd].link);
        //         $("#links").fadeIn()
        //     }
        // });
        // $("#links a.entity").bind("click touchstart", function (e) {
        //     e.preventDefault();
        //     e.stopPropagation();
        //     openLinkinTab($(this).attr("href"))
        // })
    },

    toggleMode() {
        this.showTranscript = !this.showTranscript;

        // if ($("#viz").offset().left < 0) {
        //     $("#bMode").attr("src", "/i/mode_full.png");
        //     $("#viz").animate({"margin-left": 0});
        //     $("#dia").animate({left: $("#viz").width() + 60})
        // } else {
        //     $("#bMode").attr("src", "/i/mode_list.png");
        //     $("#viz").animate({"margin-left": -($("#viz").width() + 60)});
        //     $("#dia").animate({left: 0})
        // }
        // return !1
    },
}));

Alpine.start();
