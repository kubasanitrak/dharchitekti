(function () {
	var padB = 45;
	var isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
	var isAndroid = navigator.userAgent.toLowerCase().indexOf("android") > -1;

	function isPortrait() {
		return (window.innerWidth / window.innerHeight) < 1.15;
	}

	function isDesktop() {
		return !isPortrait() && !isIOS && !isAndroid;
	}

	document.querySelectorAll(".section-items--list .items-item").forEach(function (item) {
		item.addEventListener("mouseenter", function (event) {
			var src = item.getAttribute("data-thumb");
			if (!isDesktop() || !src) {
				return;
			}
			var existing = document.getElementById("preview");
			if (existing) {
				existing.remove();
			}
			var preview = document.createElement("div");
			preview.className = "thumb-preview";
			preview.id = "preview";
			var image = document.createElement("img");
			image.id = "thumb-img";
			image.alt = "Project preview";
			image.src = src;
			preview.appendChild(image);
			document.body.appendChild(preview);

			var previewH = image.height > 0 ? image.height : Math.round(preview.offsetWidth * 0.66625 * 100) / 100;
			var yCoord = (event.clientY + previewH + padB) > window.innerHeight
				? Math.round(window.innerHeight - previewH - padB)
				: event.clientY;
			preview.style.top = yCoord + "px";
		});

		item.addEventListener("mouseleave", function () {
			var preview = document.getElementById("preview");
			if (preview) {
				preview.remove();
			}
		});
	});
})();
