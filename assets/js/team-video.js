(function () {
	var videos = document.querySelectorAll(".inline-video-container");
	if (!videos.length) {
		return;
	}

	var isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
	var isAndroid = navigator.userAgent.toLowerCase().indexOf("android") > -1;

	function isPortrait() {
		return (window.innerWidth / window.innerHeight) < 1.15;
	}

	function isDesktop() {
		return !isPortrait() && !isIOS && !isAndroid;
	}

	function toggleVideoPlayback(object) {
		if (!object) {
			return;
		}
		var video = object;
		if (video.playing) {
			video.pause();
			return;
		}
		if (video.paused || video.ended) {
			video.play();
		}
	}

	if (!Object.prototype.hasOwnProperty.call(HTMLMediaElement.prototype, "playing")) {
		Object.defineProperty(HTMLMediaElement.prototype, "playing", {
			get: function () {
				return !!(this.currentTime > 0 && !this.paused && !this.ended && this.readyState > 2);
			}
		});
	}

	videos.forEach(function (video) {
		if (isDesktop()) {
			video.addEventListener("mouseover", function (event) {
				toggleVideoPlayback(event.target);
				event.target.classList.toggle("playing");
			});
			video.addEventListener("mouseout", function (event) {
				toggleVideoPlayback(event.target);
				event.target.classList.toggle("playing");
			});
		} else {
			video.addEventListener("click", function (event) {
				toggleVideoPlayback(event.target);
				event.target.classList.toggle("playing");
			});
		}
	});
})();
