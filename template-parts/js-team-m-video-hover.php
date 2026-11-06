<?php
/**
 * Displays team-m-video-hover
 *
 * @package WordPress
 * @subpackage dharchitekti
 * @since 1.0
 * * @version 1.0
 */

?>
<style>
</style>
<script>

(function(){
	let forcePause,
		videos = document.querySelectorAll(".inline-video-container");

	const $isSafari = !!navigator.userAgent.match(/Version\/[\d\.]+.*Safari/);
	const $isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
				
	const ua = navigator.userAgent.toLowerCase();
	const $isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");

	function isDesktop() {
//*/ PRODUCTION
		const notMobile = (!isPortrait() && !$isIOS && !$isAndroid) ? true : false;
/*/ // DEVELOPMENT
		var notMobile = (!isPortrait() && !$isSafari && !$isAndroid) ? true : false;
//*/
		return notMobile;
	}
	function isPortrait() {
		var ww = $(window).innerWidth(),
				wh = $(window).innerHeight();
		winRatio = ww / wh;
		let isPortr = winRatio < 1.15 ? true : false;
		return isPortr;
	}


	function addVideoListeners() {
		if(!videos) return;

		for (var a = 0; a < videos.length; ++a) {

			// DESKTOP ON MOUSE EVENTS
			if(isDesktop()) {
				videos[a].onmouseover = function(event) { 
					toggleVideoPlayback(event.target, false);
					event.target.classList.toggle('playing');
				}
				videos[a].onmouseout = function(event) { 
					toggleVideoPlayback(event.target, false);
					event.target.classList.toggle('playing');
				}
			// TOUCH ON TAP
			} else {

				videos[a].addEventListener("click", function (event) {
					toggleVideoPlayback(event.target, false);
					event.target.classList.toggle('playing');
				});
			}
		}
	}

	function toggleVideoPlayback(object, forcePause) {
		if (!object) return;
		var video = object;

		if (video.playing) {
			video.pause();
			return;
		}
		if (video.paused || video.ended) {
			video.play();
		}
	}

	Object.defineProperty(HTMLMediaElement.prototype, "playing", {
		get: function get() {
			return !!(
			this.currentTime > 0 &&
			!this.paused &&
			!this.ended &&
			this.readyState > 2
			);
		}
	});

	addVideoListeners();

})(); // end seaf

</script>