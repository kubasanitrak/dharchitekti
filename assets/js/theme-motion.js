(function () {
	if (typeof gsap === "undefined" || typeof Flip === "undefined") {
		return;
	}

	gsap.registerPlugin(Flip);
	if (typeof ScrollToPlugin !== "undefined") {
		gsap.registerPlugin(ScrollToPlugin);
	}

	var siteHeader = document.getElementById("headerID");
	var teamOverlay = document.getElementById("overlayID");
	var menuBtn = document.getElementById("menuBtnID");
	var gridItems = document.querySelectorAll(".team-grid--item");
	var teamMemExpanded = false;
	var scrollLimit = 0;
	var initScroll = 0;
	var gridItemIds = [];
	var transT = 0.875;
	var lastScrollTop = 0;

	function toggleMenu(slideUp) {
		if (!menuBtn) {
			return;
		}
		menuBtn.checked = slideUp;
	}

	function scrollToElem(yCoord, timing) {
		gsap.to(window, {
			duration: timing,
			scrollTo: {
				y: yCoord,
				autoKill: false
			},
			ease: "power1.inOut"
		});
	}

	function toggleOverlay(toggle) {
		if (!teamOverlay) {
			if (!toggle) {
				teamMemExpanded = false;
			}
			return;
		}
		if (!toggle) {
			teamMemExpanded = false;
			teamOverlay.classList.remove("fscreen");
			return;
		}
		teamOverlay.classList.toggle("fscreen");
		teamMemExpanded = !teamMemExpanded;
	}

	function modifyState(passedID) {
		var uri = window.location.toString();
		if (uri.indexOf("#") > -1) {
			uri = uri.substring(0, uri.indexOf("#"));
		}
		window.history.replaceState({}, document.title, uri + "#" + passedID);
	}

	function removeHashFromUrl() {
		var uri = window.location.toString();
		var cleanUri = uri.substring(0, uri.indexOf("#"));
		if (uri.indexOf("#") > -1) {
			window.history.replaceState({}, document.title, cleanUri);
		}
	}

	function limitScroll(passedElem) {
		if (!passedElem || !siteHeader) {
			return;
		}
		var expandedHeight = passedElem.offsetHeight;
		if ((window.innerHeight - siteHeader.offsetHeight) > expandedHeight) {
			scrollLimit = 0;
		} else {
			scrollLimit = expandedHeight - window.innerHeight - siteHeader.offsetHeight;
		}
		initScroll = window.scrollY;
	}

	function headerOffset() {
		return siteHeader ? siteHeader.offsetHeight : 0;
	}

	document.querySelectorAll(".scrolllink").forEach(function (item) {
		var link = item.querySelector("a");
		if (!link) {
			return;
		}
		link.addEventListener("click", function (event) {
			var id = link.getAttribute("href");
			var target = id ? document.querySelector(id) : null;
			if (!target) {
				return;
			}
			event.preventDefault();
			var topY = target.getBoundingClientRect().top + window.scrollY - headerOffset();
			var timing = transT + (window.scrollY / window.innerHeight) * 0.15;
			document.querySelectorAll(".scrolllink a").forEach(function (anchor) {
				anchor.classList.remove("active");
			});
			link.classList.add("active");
			scrollToElem(topY, timing);
			gridItems.forEach(function (gridItem) {
				gridItem.classList.remove("view-expanded");
			});
			toggleOverlay(false);
			removeHashFromUrl();
			toggleMenu(false);
		});
	});

	document.querySelectorAll(".team-grid--item---toggle").forEach(function (toggle) {
		toggle.addEventListener("click", function (event) {
			var current = event.currentTarget;
			var parent = null;
			document.querySelectorAll(".scrolllink a").forEach(function (anchor) {
				anchor.classList.remove("active");
			});
			var teamLink = document.querySelector(".scrolllink a[href='#tym']");
			if (teamLink) {
				teamLink.classList.add("active");
			}

			if (current.classList.contains("inline-video-container")) {
				parent = current.parentNode.parentNode.parentNode.parentNode;
			} else if (current.classList.contains("team-grid--item---row_icon")) {
				parent = current.parentNode;
			}
			if (!parent) {
				return;
			}

			var state = Flip.getState(gridItems, ".team-grid");
			parent.classList.toggle("view-expanded");

			if (!parent.classList.contains("view-expanded")) {
				removeHashFromUrl();
			} else {
				modifyState(parent.id);
				var topY = parent.getBoundingClientRect().top + window.scrollY - headerOffset();
				scrollToElem(topY, transT);
				gsap.delayedCall(transT, limitScroll, [parent]);
			}

			toggleOverlay(true);
			Flip.from(state, {
				ease: "power4.inOut",
				duration: 1.1,
				absolute: true,
				targets: parent,
				toggleClass: "flipping"
			});
		});
	});

	window.addEventListener("scroll", function () {
		if (!teamMemExpanded) {
			return;
		}
		var scrollTop = window.pageYOffset;
		var direction = scrollTop > lastScrollTop ? "down" : "up";
		lastScrollTop = scrollTop;
		if (direction === "down" && scrollTop >= initScroll + Math.abs(scrollLimit)) {
			window.scrollTo(0, initScroll + Math.abs(scrollLimit));
		}
		if (direction === "up" && scrollTop <= initScroll) {
			window.scrollTo(0, initScroll);
		}
	});

	function collectTeamMemIds() {
		gridItems.forEach(function (item) {
			if (item.id) {
				gridItemIds.push(item.id);
			}
		});
	}

	function checkTeamMemHashInUrl() {
		if (!window.location.hash) {
			return;
		}
		var urlHash = window.location.hash.substring(1);
		if (gridItemIds.indexOf(urlHash) === -1) {
			return;
		}
		var expanded = document.getElementById(urlHash);
		if (!expanded) {
			return;
		}
		toggleOverlay(true);
		expanded.classList.add("view-expanded");
		var topY = expanded.getBoundingClientRect().top + window.scrollY - headerOffset();
		scrollToElem(topY, 0);
		limitScroll(expanded);
	}

	window.addEventListener("load", function () {
		collectTeamMemIds();
		checkTeamMemHashInUrl();
	});
})();
