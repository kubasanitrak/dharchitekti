(function () {
	var debounce = function (func, delay) {
		var timer;
		return function () {
			var context = this;
			var args = arguments;
			clearTimeout(timer);
			timer = setTimeout(function () {
				func.apply(context, args);
			}, delay);
		};
	};

	var throttle = function (func, limit) {
		var lastFunc;
		var lastRan;
		return function () {
			var context = this;
			var args = arguments;
			if (!lastRan) {
				func.apply(context, args);
				lastRan = Date.now();
			} else {
				clearTimeout(lastFunc);
				lastFunc = setTimeout(function () {
					if ((Date.now() - lastRan) >= limit) {
						func.apply(context, args);
						lastRan = Date.now();
					}
				}, limit - (Date.now() - lastRan));
			}
		};
	};

	var wrapper = document.getElementById("wrapper-id");
	var body = document.body;
	var observedItem = document.querySelectorAll(".scroll-trigger");

	window.addEventListener("load", function docLoaded() {
		window.removeEventListener("load", docLoaded);
		if (wrapper && wrapper.classList.contains("loading")) {
			wrapper.classList.remove("loading");
		}
		setUpIObserver();
		unifyLightboxItems();
	});

	function setUpIObserver() {
		if (!("IntersectionObserver" in window) || !observedItem.length) {
			return;
		}
		var observer = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.intersectionRatio > 0) {
					entry.target.classList.add("inView");
				}
			});
		}, {
			rootMargin: "-100px 0px -100px 0px",
			threshold: 0
		});
		observedItem.forEach(function (obs) {
			observer.observe(obs);
		});
	}

	window.addEventListener("scroll", throttle(function () {
		if (body) {
			body.classList.remove("firsttime-load");
		}
	}, 500));

	window.addEventListener("resize", debounce(function () {
		if (!wrapper) {
			return;
		}
		if ((window.innerWidth / window.innerHeight) <= 1) {
			wrapper.classList.add("has-intro");
		}
	}, 500));

	var filterBtn = document.getElementById("filter_btn_ID");
	var indexSwitch = document.getElementById("index_switch_ID");
	var allWorks = document.getElementById("allWorks_ID");
	var allWorksContent = document.getElementById("allWorksContent_ID");

	if (filterBtn) {
		filterBtn.addEventListener("click", function (event) {
			event.target.classList.toggle("active");
			if (allWorks) {
				allWorks.classList.toggle("filter-open");
			}
		});
	}

	if (indexSwitch) {
		indexSwitch.addEventListener("click", function (event) {
			var button = event.target;
			button.classList.toggle("grid-index");
			if (allWorksContent) {
				allWorksContent.classList.toggle("grid-view");
			}
			if (button.classList.contains("grid-index")) {
				button.textContent = (window.dhaTheme && dhaTheme.gridLabel) ? dhaTheme.gridLabel : "grid";
			} else {
				button.textContent = "index";
			}
		});
	}

	var mapswitch = document.getElementById("gmap-toggle");
	if (mapswitch) {
		mapswitch.addEventListener("click", function () {
			var gmap = document.querySelectorAll(".map-container");
			gmap.forEach(function (el) {
				el.classList.toggle("rolled-up");
			});
		});
	}

	var filterCategories = document.querySelectorAll(".filter-list--item");
	var list2filter = document.getElementById("proj-listID");
	var grid2filter = document.getElementById("proj-gridID");

	filterCategories.forEach(function (item) {
		item.addEventListener("click", function (event) {
			var current = event.currentTarget;
			var filterParam = current.getAttribute("data-filter-cat");
			var resetFilter = current.classList.contains("active");
			Array.prototype.forEach.call(current.parentNode.children, function (sibling) {
				if (sibling !== current) {
					sibling.classList.remove("active");
				}
			});
			if (filterParam) {
				filterListAndGrid(filterParam, resetFilter);
			}
			current.classList.toggle("active");
		});
	});

	function filterListAndGrid(param2show, resetFilter2All) {
		if (!list2filter || !grid2filter) {
			return;
		}
		[list2filter, grid2filter].forEach(function (list) {
			Array.prototype.forEach.call(list.children, function (child) {
				if (!child.classList.contains(param2show)) {
					child.classList.add("filter-out");
				}
				if (resetFilter2All || child.classList.contains(param2show)) {
					child.classList.remove("filter-out");
				}
			});
		});
	}

	function unifyLightboxItems() {
		var heroImgGalleryLink = document.getElementById("hero-img-gallery-linkID");
		var lightboxLinks = document.querySelectorAll("#proj-det-contentID .swipebox");
		if (!heroImgGalleryLink || !lightboxLinks.length) {
			return;
		}
		lightboxLinks.forEach(function (link) {
			link.dataset.rel = heroImgGalleryLink.dataset.rel;
		});
	}

	var searchField = document.getElementById("search-fieldID");
	var searchBtn = document.getElementById("search-btnID");
	if (searchField && searchBtn) {
		searchField.addEventListener("focusin", function () {
			searchBtn.classList.remove("visually-hidden");
		});
		searchField.addEventListener("focusout", function () {
			searchBtn.classList.add("visually-hidden");
		});
	}
})();
