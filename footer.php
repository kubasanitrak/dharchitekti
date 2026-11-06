<?php
/**
 * Displays footer
 *
 * @package WordPress
 * @subpackage dharchitekti
 * @since 1.0
 * * @version 1.0
 */

?>

<?php include('template-parts/page-post-foot.php'); ?>

</div> <!-- END WRAPPER -->

<!-- Javascript at the bottom for fast page loading -->
<script src="<?php echo  get_template_directory_uri(); ?>/assets/js/libs/jquery-3.6.1.min.js"></script>
<script src="<?php echo  get_template_directory_uri(); ?>/assets/js/libs/ls.unveilhooks.min.js"></script>

<script src="<?php echo  get_template_directory_uri(); ?>/assets/js/libs/gsap.min.js"></script>
<script src="<?php echo  get_template_directory_uri(); ?>/assets/js/libs/ScrollToPlugin.min.js"></script>
<script src="<?php echo  get_template_directory_uri(); ?>/assets/js/libs/Flip.min.js"></script>

<!-- <script src="<?php #echo  get_template_directory_uri(); ?>/assets/js/balancetext.min.js"></script> -->


<!-- CDN LINKS UNCOMMENT FOR PRODUCTION -->
<!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script> -->
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script> -->
<!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.3/TweenMax.min.js'></script> -->
<!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.3/plugins/TextPlugin.min.js'></script> -->
	<script>
		(function() {

						const debounce = function(func, delay){
							let timer;
							return function () {     //anonymous function
							const context = this; 
							const args = arguments;
							clearTimeout(timer); 
							timer = setTimeout(()=> {
									func.apply(context, args)
								},delay);
							}
						}
						// THROTTLE
						const throttle = (func, limit) => {
							let lastFunc;
							let lastRan;
							return function() {
								const context = this;
								const args = arguments;
								if (!lastRan) {
									func.apply(context, args)
									lastRan = Date.now();
								} else {
									clearTimeout(lastFunc);
									lastFunc = setTimeout(function() {
										if ((Date.now() - lastRan) >= limit) {
											func.apply(context, args);
											lastRan = Date.now();
										}
									}, limit - (Date.now() - lastRan));
								}
							}
						}

						const	wrapper = document.getElementById('wrapper-id'),
								content = document.getElementById("contentID"),
								body = document.body,
								_siteHEADER = document.getElementById("headerID"),
								_siteLOGO = document.getElementById("logoID"),
								_teamOvrlay = document.getElementById("overlayID"),
								_menuBTN = document.getElementById("menuBtnID");
								// _subMenuPEl = document.querySelectorAll('.menu-item-has-children');
								// observedItem = document.querySelectorAll('.scrollbased-reveal');
						let $scrollDir = "down",
							lastScrollTop,
							iOis_supp = false,
							offsetY,
							_len,
							$sT,
							transT = 0.875,
							observedItem = document.querySelectorAll(".scroll-trigger"),
							_gridItems = gsap.utils.toArray(".team-grid--item"),
							_urlHash = gsap.utils.toArray(".team-grid--item"),
							_teamMemExpanded = false,
							_scrollLimit,
							_initScroll,
							_gridItemsIdArr = [];

						gsap.registerPlugin(Flip);

						window.addEventListener('load', docLoaded);

						function docLoaded() {
							window.removeEventListener('load', docLoaded);  
							if(wrapper.classList.contains('loading') ) {
								wrapper.classList.remove('loading');
							}
							setUpIObserver();
							unifyLightboxItems();
							collectTeamMemIds();
							checkTeamMemHashInUrl();
						}

						function toggleMenu(slideUp) {
							_menuBTN.checked = slideUp;
						}

						function setUpIObserver() {

							var observer = new IntersectionObserver(
								function (entries, observer) {
									entries.forEach(function (entry) {
										if (entry.intersectionRatio > 0) {
											entry.target.classList.add("inView");
											// markMenuItemOnScroll(entry.target.id);
										} else {
											// entry.target.classList.remove("inView");
										}
									});
								},
								{
									// rootMargin: "0px 0px -100px 0px",
									rootMargin: "-100px 0px -100px 0px",
									threshold: 0
								}
							);
							observedItem.forEach(function (obs) {
								// console.log("tick");
								observer.observe(obs);
							});
						}

						window.addEventListener('scroll', 
							// throttle(function () {
							function() {
								if(!_teamMemExpanded) return;

								$sT = window.pageYOffset;
								$scrollDir = $sT > lastScrollTop ? "down" : "up";
								lastScrollTop = $sT;

								if($scrollDir == "down" && $sT >= _initScroll + Math.abs(_scrollLimit)) {
									window.scrollTo(0, _initScroll + Math.abs(_scrollLimit));
								}
								if($scrollDir=="up" && $sT <= _initScroll) {
									window.scrollTo(0, _initScroll);
								}
							// }, 100)
							}
						);
						
						window.addEventListener('scroll', 
							throttle(function () {
								body.classList.remove("firsttime-load");

								$sT = window.pageYOffset;
								$scrollDir = $sT > lastScrollTop ? "down" : "up";
								lastScrollTop = $sT;
								
								if($scrollDir=="up" && $sT < 150) {
									return;
								}

							}, 500)
						);

						window.addEventListener('resize', 
							debounce(function () {
								if ( (window.innerWidth / window.innerHeight) <= 1) {
									document.getElementById("wrapper-id").classList.add("has-intro");
								}
							}, 500)
						);

						$(".scrolllink").on("click", "a", function (event) {

							event.preventDefault();

							let id2scroll,
								$this = $(this),
								_headerH = _siteHEADER.offsetHeight;
							id2scroll = $this.attr("href");

							topY = $(id2scroll).offset().top - _headerH;

							_len = transT + ($(window).scrollTop() / $(window).innerHeight()) * 0.15;

							$this.toggleClass('active');
							$this.parent('li').siblings().find('a').removeClass('active');

							scrollToElem(topY, _len);

							for(let a = 0; a < _gridItems.length; ++a) {
								if(_gridItems[a].classList.contains('view-expanded'));
								_gridItems[a].classList.remove('view-expanded');
							}

							toggleOverlay(false);
							removeHashFromUrl();

						});

						function scrollToElem(yCoord, timing) {
							TweenMax.to(window, timing, {
								scrollTo: {
									y: yCoord,
									autoKill: false
								},
								ease: Power1.easeInOut
							});
						}

						
						let	_filterBtn = document.getElementById("filter_btn_ID"),
							_indexSwitch = document.getElementById("index_switch_ID"),
							_allWorks = document.getElementById("allWorks_ID"),
							_allWorksContent = document.getElementById("allWorksContent_ID");

						if(_filterBtn) _filterBtn.addEventListener("click", toggleWorksFilter);
						if(_indexSwitch) _indexSwitch.addEventListener("click", toggleIndexView);

						function toggleWorksFilter(event) {
							let _this = event.target;
							_this.classList.toggle('active');
							_allWorks.classList.toggle('filter-open');
						}
						function toggleIndexView(event) {
							let _this = event.target;
							_this.classList.toggle('grid-index');
							_allWorksContent.classList.toggle('grid-view');
							if(_this.classList.contains('grid-index')) {
								// _this.textContent = "grid";
								_this.textContent = "<?php _e( 'grid', 'dharchitekti'); ?>";
							} else {
								_this.textContent = "index";
							}
						}

						let _teamMViewSwitch = document.querySelectorAll(".team-grid--item---toggle");

						for(let i=0; i<_teamMViewSwitch.length; ++i) {
							_teamMViewSwitch[i].addEventListener('click', toggleTeamMView);
						}

						function toggleTeamMView(event) {

							$(".scrolllink").siblings().find('a').removeClass('active');
							$(".scrolllink").siblings().find("a[href='#tym']").addClass('active');
							// $("a[href$='.tym']").addClass('active');

							let _this = event.currentTarget;
							if (_this.classList.contains("inline-video-container")) {
// console.log("click on video");
								_parent = _this.parentNode.parentNode.parentNode.parentNode;
							} else if ( _this.classList.contains("team-grid--item---row_icon") ) {
// console.log("click on icon");
								_parent = _this.parentNode;
							}
							
							const state = Flip.getState(_gridItems, '.team-grid');
							
							_parent.classList.toggle('view-expanded');

							if(!_parent.classList.contains('view-expanded')) {
								removeHashFromUrl();
							} else {
								modifyState(_parent.id);
								topY = _parent.getBoundingClientRect().top + window.scrollY - _siteHEADER.offsetHeight;
								scrollToElem(topY, transT);
								
								// SET SCROLL LIMIT AFTER ELEM ANIMATION IS FINISHED
								TweenMax.delayedCall(transT, limitScroll, [_parent]);
							}

							toggleOverlay(true);

							Flip.from(state, {
    							ease: "power4.inOut",
								duration: 1.1,
    							absolute: true,
    							// scale: true,
    							targets: _parent,
    							toggleClass: "flipping",
    							// zIndex: 100
							} );
						}

						const mapswitch = document.getElementById("gmap-toggle");
						let gmap = document.querySelectorAll('.map-container');
						
						if(mapswitch) mapswitch.addEventListener('click', toggleGmap);

						function toggleGmap() {
							// USE ARRAY FUNCTION FOR LEXICAL THIS
							if(!gmap) return;
							[].forEach.call(gmap, el => {
						    	el.classList.toggle('rolled-up');
							});
						}

						function toggleOverlay(toggle) {
							if(!_teamOvrlay) return;
							if(!toggle) {
								_teamMemExpanded = false;
								_teamOvrlay.classList.remove('fscreen');
								return;
							}
							_teamOvrlay.classList.toggle('fscreen');
							_teamMemExpanded = !_teamMemExpanded;
						}

						let _filterCategories = document.querySelectorAll(".filter-list--item");
						const	_list2filter = document.getElementById("proj-listID"),
								_grid2filter = document.getElementById("proj-gridID");						

						for(let i=0; i<_filterCategories.length; ++i) {
							_filterCategories[i].addEventListener('click', toggleCategoryItems);
						}

						function toggleCategoryItems(event) {

							// let _this = event.target;
							let _this = event.currentTarget,
								_filterParam = _this.getAttribute('data-filter-cat'),
								// _filterParam = [],
								_resetFilter2All = false,
								_showAll = false;

							if( _this.classList.contains('active') ) {
								_resetFilter2All = true;
							} 
							for (let sibling of _this.parentNode.children) {
								if (sibling !== _this) sibling.classList.remove('active');
							}

							if(_filterParam) filterListAndGrid(_filterParam, _resetFilter2All);

							_this.classList.toggle('active');
						}

						function filterListAndGrid(param2show, resetFilter2All) {

							_list2filterChildren = _list2filter.children;
							_grid2filterChildren = _grid2filter.children;
							for(let a = 0; a < _list2filterChildren.length; ++a) {
								if( !_list2filterChildren[a].classList.contains(param2show) ) {
									_list2filterChildren[a].classList.add('filter-out');
								} 
								if( resetFilter2All || _list2filterChildren[a].classList.contains(param2show) ) {
									_list2filterChildren[a].classList.remove('filter-out');
								}
							}
							for(let a = 0; a < _grid2filterChildren.length; ++a) {
								if( !_grid2filterChildren[a].classList.contains(param2show) ) {
									_grid2filterChildren[a].classList.add('filter-out');
								} 
								if( resetFilter2All || _grid2filterChildren[a].classList.contains(param2show) ) {
									_grid2filterChildren[a].classList.remove('filter-out');
								}
							}
						}

						function unifyLightboxItems() {
							let _heroImgGalleryLink = document.getElementById("hero-img-gallery-linkID");
							let _lightboxLinks = gsap.utils.toArray('#proj-det-contentID .swipebox');
							if(!_heroImgGalleryLink || !_lightboxLinks) return false;
							for(let i = 0; i < _lightboxLinks.length; ++i) {
								_lightboxLinks[i].dataset.rel = _heroImgGalleryLink.dataset.rel;
							}
						}

						function checkTeamMemHashInUrl() {
							if(window.location.hash) {
								_urlHash = window.location.hash.substring(1);
							} else {
								// No hash found
								return;
							}
							if (_gridItemsIdArr.indexOf(_urlHash) != -1) {
								toggleOverlay(true);
								// document.getElementById(_urlHash).classList.add('view-expanded');
								_expanded = document.getElementById(_urlHash);
								_expanded.classList.add('view-expanded');
								
								// topY = $(window.location.hash).offset().top - _siteHEADER.offsetHeight;
								topY = _expanded.getBoundingClientRect().top + window.scrollY - _siteHEADER.offsetHeight;

								scrollToElem(topY, 0);
							}

							limitScroll(_expanded);
						}
						function collectTeamMemIds() {
							if(_gridItems.length <= 0 ) return;
							for(let a = 0; a < _gridItems.length; ++a) {
								_gridItemsIdArr.push(_gridItems[a].id);
							}
						}
						function limitScroll(passedElem) {
// console.log("fired");
							_expanded = passedElem;
							_winHeight = window.innerHeight;
							_expandedHeight = _expanded.offsetHeight;

							if((_winHeight - _siteHEADER.offsetHeight) > _expandedHeight) {
								_scrollLimit = 0;
							} else {
								_scrollLimit = _expandedHeight * 1.0 - _winHeight - _siteHEADER.offsetHeight;
							}

							_initScroll = window.scrollY;
						}

						function modifyState(passedID) {
							// let stateObj = { id: "100" };
							let uri = window.location.toString();
								uri += "#" + passedID;
							window.history.replaceState({}, document.title, uri);
						}

						function removeHashFromUrl() {
							let uri = window.location.toString();

							// if (uri.indexOf("#") > 0) {
							// 	let clean_uri = uri.substring(0, uri.indexOf("#"));

							// 	window.history.replaceState({}, document.title, clean_uri);
							// 	return;
							// }
							let clean_uri = uri.substring(0, uri.indexOf("#"));
							window.history.replaceState({}, document.title, clean_uri);
						}


						const	_searchField = document.getElementById("search-fieldID"),
								_searchBtn = document.getElementById("search-btnID");

								if(_searchField) {

									_searchField.addEventListener('focusin', function (event) {
// console.log("focus left");
										_searchBtn.classList.remove('visually-hidden');
									});
									_searchField.addEventListener('focusout', function (event) {
										_searchBtn.classList.add('visually-hidden');
// console.log("focus left");
									});
								}

		})();
	</script>
						<?php include('template-parts/js-index-list-thumb-hover.php'); ?>	
						<?php include('template-parts/js-team-m-video-hover.php'); ?>	

						
<!-- START WP_FOOTER() -->
	<?php wp_footer(); ?>
<!-- END WP_FOOTER() -->

<!-- <script src="<?php #echo  get_template_directory_uri(); ?>/assets/js/libs/adopt-words.bundle.js"></script>  
<script>
    AdoptWords.init('.flow *', {
    	minWords: 4
    })
</script> -->




<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/css/dha-simple-lightbox-override.css?v13-10-2023.01" />

<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/css/wp-block-fix-style.css?v13-10-2023.01" />
</body>
</html>