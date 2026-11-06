<?php
/**
 * Displays index-list-thumb-hover
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
		//code goes here
	
/*/
// REVEAL THUMB ON HOVER
/*/

				const xDistance = 5,
						// yDistance = Math.ceil(window.innerWidth / 5),
						yDistance = Math.ceil(window.innerWidth / 5),
						$padB = 45;
				let yCoord,
					previewH;

					//*/ / / / / / / / / / / 
	// IOS and Android detection => ASUME MOBILE=TOUCH DEVICES
				const $isSafari = !!navigator.userAgent.match(/Version\/[\d\.]+.*Safari/);
				const $isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
				
				const ua = navigator.userAgent.toLowerCase();
				const $isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");


				// USAGE if(isDesktop())…
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
						
				$('.section-items--list .items-item').hover(function(e) {
					const $this = $(this),
						src = $this.data('thumb');
// console.log(src);
					let offset = $this.offset();

					if(!isDesktop() || !$this.data('thumb') ) return;

					
					$('body').append("<div class='thumb-preview' id='preview'><img id='thumb-img' src='"+ String(src) +"' alt='Project preview' />"+"</div>");

					previewH = ($("#thumb-img").height() > 0) ? $("#thumb-img").height() : Math.round($("#preview").width() * 0.66625 * 100) / 100;

// console.log(previewH);
// console.log("pageX: " + e.pageX + ", pageY: " + e.pageY );
// console.log( "offsetTop: " + offset.top + "\n" + "previewWidth: " + $("#preview").width() + "\n" + "windowHeight: " + window.innerHeight);
// console.log( "cursorY: " + e.clientY + "\n" + "previewWidth: " + $("#preview").width() + "\n" + "windowHeight: " + window.innerHeight);
// if((e.clientY + (Math.round(($("#preview").width() * 0.66625) * 100) / 100) - window.innerHeight) < 0 ) $("#preview").addClass('thumb-safe-pos');
// console.log(e.clientY + $("#preview").width() * 0.66625 - window.innerHeight);


						// IF #PREVIEW Y IS OFFSCREEN, SET ITS POSITION WITHIN SCREEN - TOP OR BOTTOM SAFE DISTANCE
						if((e.clientY + previewH + $padB) > window.innerHeight ) {
							yCoord = Math.round(window.innerHeight - previewH - $padB);
						} else {
							// yCoord = e.pageY - xDistance;
							yCoord = e.clientY;
						}
						$("#preview")
							.css("top", yCoord + "px");
							// .css("left",(e.pageX + yDistance) + "px");
							// .css("right",(e.pageX + yDistance) + "px");
					},
					//REMOVE #preview ON MOUSE OUT
					function(){
						$("#preview").remove();
				});	
				// UPDATE POS WHEN MOUSE MOVING
				/*
				$('.section-items--list .items-item').mousemove(function(e) {
						if((e.clientY + previewH + $padB) > window.innerHeight ) {
							yCoord = Math.round(window.innerHeight - previewH - $padB);
						} else {
							yCoord = e.clientY - xDistance;
						}
						$("#preview")
							.css("top", yCoord + "px")
							.css("left",(e.pageX + yDistance) + "px");
				})
				*/
	})();

</script>