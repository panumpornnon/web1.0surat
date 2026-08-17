/**
 * Precaching client, this is the main application that interacts with server
 * side code for sitemap incremental generation and precaching process
 * 
 * @package JMAP::AJAXPRECACHING::administrator::components::com_jmap
 * @subpackage js
 * @author Joomla! Extensions Store
 * @copyright (C) 2021 Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
//'use strict';
(function($) {
	var SeoStats = function() {
		/**
		 * Add the loading waiter icon during asyncronous operations
		 * 
		 * @access private
		 * @param HTMLElement targetElement
		 * @return Void
		 */
		var addLoadingWaiter = function(targetElement) {
			var containerWidth = targetElement.width(); 

			// Append waiter and text fetching data in progress
			targetElement.append('<div class="waiterinfo"></div>')
				.children('div.waiterinfo')
				.text(COM_JMAP_SEOSTATS_LOADING)
				.css({
					'position': 'absolute',
		            'top': '125px',
		            'left': (containerWidth - (parseInt(containerWidth / 2) + 100) ) + 'px',
		            'width': '200px'
	        });
			
			targetElement.append('<img/>')
				.children('img')
				.attr({
					'src': jmap_baseURI + 'administrator/components/com_jmap/images/loading.gif',
					'class': 'waiterinfo'})
				.css({
		            'position': 'absolute',
		            'top': '50px',
		            'left': (containerWidth - (parseInt(containerWidth / 2) + 32) ) + 'px',
		            'width': '64px'
	        });
		};
		
		/**
		 * The first operation is get informations about published data sources
		 * and start cycle over all the records using promises and recursion
		 * 
		 * @access private
		 * @return Void
		 */
		var getSeoStatsData = function() {
			// Object to send to server
			var ajaxparams = {
				idtask : 'fetchSeoStats',
				template : 'json',
				param: {}
			};

			// Unique param 'data'
			var uniqueParam = JSON.stringify(ajaxparams);
			// Request JSON2JSON
			var seoStatsPromise = $.Deferred(function(defer) {
				$.ajax({
					type : "POST",
					url : "../administrator/index.php?option=com_jmap&task=ajaxserver.display&format=json",
					dataType : 'json',
					context : this,
					data : {
						data : uniqueParam
					}
				}).done(function(data, textStatus, jqXHR) {
					if(data === null) {
						// Error found
						defer.reject(COM_JMAP_NULL_RESPONSEDATA, 'notice');
						return false;
					}
					
					if(!data.result) {
						// Error found
						defer.reject(data.exception_message, data.errorlevel, data.seostats, textStatus);
						return false;
					}
					
					// Check response all went well
					if(data.result && data.seostats) {
						defer.resolve(data.seostats);
					}
				}).fail(function(jqXHR, textStatus, errorThrown) {
					// Error found
					var genericStatus = textStatus[0].toUpperCase() + textStatus.slice(1) + ': ' + jqXHR.status ;
					defer.reject(COM_JMAP_ERROR_HTTP + '-' + genericStatus + '- ' + errorThrown, 'error');
				});
			}).promise();

			seoStatsPromise.then(function(responseData) {
				// SEO stats correctly retrieved from the model layer, now updates the view accordingly
				formatSeoStats(responseData);
				
				// We have SEO stats, if sessionStorage is supported store data and avoid unuseful additional requests
				if( window.sessionStorage !== null ) {
					sessionStorage.setItem('seostats', JSON.stringify(responseData));
					sessionStorage.setItem('seostats_service', responseData.service);
					sessionStorage.setItem('seostats_targeturl', responseData.targeturl);
				}
			}, function(errorText, errorLevel, responseData, error) {
				// Do stuff and exit
				if(responseData) {
					formatSeoStats(responseData);
				}
				
				// Show little user error notification based on fatal php circumstances
				$('#seo_stats').append('<div class="alert alert-' + errorLevel + '">' + errorText + '</div>');
			}).always(function(){
				// Async request completed, now remove waiters info
				$('*.waiterinfo').remove();
			})
		};

		/**
		 * The first operation is get informations about published data sources
		 * and start cycle over all the records using promises and recursion
		 * 
		 * @access private
		 * @param String linkUrl
		 * @param HTMLElement clickedElement
		 * @param Object sessionStats
		 * @return Void
		 */
		var getCompetitorStatsData = function(linkUrl, clickedElement, sessionStats) {
			// Object to send to server
			var ajaxparams = {
				idtask : 'fetchCompetitorStats',
				template : 'json',
				param: linkUrl
			};

			// Add the loading waiter
			addLoadingWaiter($(clickedElement).parents('div.popover'));
			
			// Unique param 'data'
			var uniqueParam = JSON.stringify(ajaxparams);
			
			if(!sessionStats) {
				// Request JSON2JSON
				var competitorStatsPromise = $.Deferred(function(defer) {
					$.ajax({
						type : "POST",
						url : "../administrator/index.php?option=com_jmap&task=ajaxserver.display&format=json",
						dataType : 'json',
						context : this,
						data : {
							data : uniqueParam
						}
					}).done(function(data, textStatus, jqXHR) {
						if(data === null) {
							// Error found
							defer.reject(COM_JMAP_NULL_RESPONSEDATA, 'notice');
							return false;
						}
						
						if(!data.result) {
							// Error found
							defer.reject(data.exception_message, data.errorlevel, textStatus);
							return false;
						}
						
						// Check response all went well
						if(data.result && data.competitorstats) {
							defer.resolve(data.competitorstats);
						}
					}).fail(function(jqXHR, textStatus, errorThrown) {
						// Error found
						var genericStatus = textStatus[0].toUpperCase() + textStatus.slice(1) + ': ' + jqXHR.status ;
						defer.reject(COM_JMAP_ERROR_HTTP + '-' + genericStatus + '- ' + errorThrown, 'error');
					});
				}).promise();
			} else {
				// Found session stats, create and resolve the promise immediately
				var competitorStatsPromise = $.Deferred(function(defer) {
					defer.resolve(sessionStats, true);
				}).promise();
			}

			competitorStatsPromise.then(function(responseData, bySession) {
				// Competitor stats correctly retrieved from the model layer, now updates the view accordingly
				
				// Retrieve the Y position of the clicked competitor label
				var competitorLabelY = $(clickedElement).offset().top - $(window).scrollTop();
				var placementPopover = competitorLabelY > 250 ? 'top' : 'bottom';
				
				// Enables bootstrap popover
				$(clickedElement).popover({
					placement: placementPopover,
					title: COM_JMAP_COMPETITOR_STATS + linkUrl,
					html: 1,
					container: 'body',
					trigger: 'manual',
					content: function() {
						// Format data only if are not already formatted and stored by session
						if(!bySession) {
							if(!isNaN(parseInt(responseData.googlepages))) {
								responseData.googlepages = parseInt(responseData.googlepages).toLocaleString().replace(/,/g, '.');
							}
							
							if(!isNaN(parseInt(responseData.googlebacklinks))) {
								responseData.googlebacklinks = parseInt(responseData.googlebacklinks).toLocaleString().replace(/,/g, '.');
							}
							
							if(!isNaN(parseInt(responseData.googlerelated))) {
								responseData.googlerelated = parseInt(responseData.googlerelated).toLocaleString().replace(/,/g, '.');
							}
							
							if(!isNaN(parseInt(responseData.bingpages))) {
								responseData.bingpages = parseInt(responseData.bingpages).toLocaleString().replace(/,/g, '.');
							}
							
							if(!isNaN(parseInt(responseData.bingbacklinks))) {
								responseData.bingbacklinks = parseInt(responseData.bingbacklinks).toLocaleString().replace(/,/g, '.');
							}
						}
						
						return 	'<div class="competitor-stats-container">' +
									'<div class="competitor-stats-row">' +
										'<label class="label label-primary">' + COM_JMAP_COMPETITOR_GOOGLE_PAGES + '<span class="badge pull-right">' + responseData.googlepages + '</span></label>' +
										'<label class="label label-primary">' + COM_JMAP_COMPETITOR_GOOGLE_BACKLINKS + '<span class="badge pull-right">' + responseData.googlebacklinks + '</span></label>' +
										'<label class="label label-primary">' + COM_JMAP_COMPETITOR_GOOGLE_RELATED + '<span class="badge pull-right">' + responseData.googlerelated + '</span></label>' +
										'<label class="label label-primary">' + COM_JMAP_COMPETITOR_BING_PAGES + '<span class="badge pull-right">' + responseData.bingpages + '</span></label>' +
										'<label class="label label-primary">' + COM_JMAP_COMPETITOR_BING_BACKLINKS + '<span class="badge pull-right">' + responseData.bingbacklinks + '</span></label>' +
							        '</div>' +
								'</div>';
					}				
				}).popover('show');
				
				// We have SEO stats, if sessionStorage is supported store data and avoid unuseful additional requests
				if( window.sessionStorage !== null && !bySession) {
					sessionStorage.setItem('competitorstats.' + linkUrl, JSON.stringify(responseData));
				}
			}, function(errorText, errorLevel, error) {
				// Do stuff and exit
				$(clickedElement).popover({
					placement: 'top',
					title: COM_JMAP_COMPETITOR_STATS + linkUrl,
					html: 1,
					container: 'body',
					trigger: 'manual',
					content: function() {
						return '<div class="alert alert-' + errorLevel + '">' + errorText + '</div>';
					}				
				}).popover('show');
			}).always(function(){
				// Bind the popover closing
				$('body').on('click', function(jqEvent) {
					if($(jqEvent.target).parents('div.competitor-stats-container').length) {
						return false;
					}
					$(clickedElement).popover('destroy');
				});
				
				// Async request completed, now remove waiters info
				$('*.waiterinfo').remove();
			});
		};

		/**
		 * Format the Seo Stats
		 * 
		 * @access private
		 * @return Void
		 */
		var formatStatscropSeoStats = function(seoStats) {
			// Statscrop rank
			var statscropRankFontSize = '';
			var statscropRankFormatted = seoStats.globalrank;
			if(!isNaN(parseInt(statscropRankFormatted))) {
				statscropRankFormatted = parseInt(statscropRankFormatted).toLocaleString().replace(/,/g, '.');
				if(statscropRankFormatted.length > 7) {
					statscropRankFontSize = ' style="font-size:18px"';
				}
			}
			$('li[data-bind=\\{global_rank\\}]').html('<span' + statscropRankFontSize + '>' + statscropRankFormatted + '</span>');
			
			// Daily visitors
			var dailyVisitorsFontSize = '';
			var dailyVisitorsFormatted = seoStats.dailyvisitors;
			if(!isNaN(parseInt(dailyVisitorsFormatted))) {
				dailyVisitorsFormatted = parseInt(dailyVisitorsFormatted).toLocaleString().replace(/,/g, '.');
				if(dailyVisitorsFormatted.length > 7) {
					dailyVisitorsFontSize = ' style="font-size:18px"';
				}
			}
			$('li[data-bind=\\{daily_visitors\\}]').html('<span' + dailyVisitorsFontSize + '>' + dailyVisitorsFormatted + '</span>');
			

			// Daily Page Views
			// Daily visitors
			var dailyPageviewsFontSize = '';
			var dailyPageviewsFormatted = seoStats.dailypageviews;
			if(!isNaN(parseInt(dailyPageviewsFormatted))) {
				dailyPageviewsFormatted = parseInt(dailyPageviewsFormatted).toLocaleString().replace(/,/g, '.');
				if(dailyPageviewsFormatted.length > 7) {
					dailyPageviewsFontSize = ' style="font-size:18px"';
				}
			}
			$('li[data-bind=\\{daily_pageviews\\}]').html('<span' + dailyPageviewsFontSize + '>' + dailyPageviewsFormatted + '</span>');
			
			$('li[data-bind=\\{page_load_time\\}]').html(seoStats.pageloadtime);
			
			$('li[data-bind=\\{seoscore\\}]').html(seoStats.seoscore);
			
			$('li[data-bind=\\{rating\\}]').html(seoStats.rating);
			var starsNumericalChunk = seoStats.rating.split('/')[0];
			var intStars = parseInt(starsNumericalChunk);
			var floatTotal = parseFloat(starsNumericalChunk);
			var restEmptyStars = parseInt(5 - floatTotal);
			var fullStars = '';
			for (var i = 0; i < intStars; i++) {
				fullStars += '<span class="icon-star"></span>';
			}
			var halfStar = (floatTotal - intStars) > 0 ? '<span class="icon-star-2"></span>' : '';
			var emptyStars = '';
			for (var e = 0; e < restEmptyStars; e++) {
				emptyStars += '<span class="icon-star-empty"></span>';
			}
			$('li[data-bind=\\{rating_stars\\}]').html(fullStars + halfStar + emptyStars);
			
			// Open Page Rank
			$('li[data-bind=\\{openpagerank\\}]').html(seoStats.openpagerank);
			
			// Google SERP indexed links
			var indexedFontSize = '';
			if(seoStats.googleindexedlinks.length > 7) {
				indexedFontSize = ' style="font-size:18px"';
			}
			$('li[data-bind=\\{google_indexed_links\\}]').html('<span' + indexedFontSize + '>' + seoStats.googleindexedlinks + '</span>');
			
			// Website internal links
			var internalFontSize = '';
			if(seoStats.linksinternal.length > 7) {
				internalFontSize = ' style="font-size:18px"';
			}
			$('li[data-bind=\\{links_internal\\}]').html('<span' + internalFontSize + '>' + seoStats.linksinternal + '</span>');
			
			// Website external links
			var externalFontSize = '';
			if(seoStats.linksexternal.length > 7) {
				externalFontSize = ' style="font-size:18px"';
			}
			$('li[data-bind=\\{links_external\\}]').html('<span' + externalFontSize + '>' + seoStats.linksexternal + '</span>');

			// Keywords
			if(typeof(seoStats.keywords) === 'object' && seoStats.keywords) {
				var statsKeywords = '';
				$.each(seoStats.keywords.data, function(index, keywordObject){
					// Limit top 30 keywords
					if((index + 1) > 30) {
						return false;
					}
					
					if(typeof(keywordObject.Ph) !== 'undefined' && keywordObject.Ph != '(Other)') {
						statsKeywords += ('<div>' + keywordObject.Ph + '</div>');
					}
				});
				$('li[data-bind=\\{keywords\\}]')
							.attr('data-content', statsKeywords)
							.popover({trigger:'click', placement:'top', html:1})
							.addClass('clickable');
			}
			
			// Backlinkers
			if(typeof(seoStats.backlinkers) === 'object' && seoStats.backlinkers) {
				var statsBacklinkers = '';
				$.each(seoStats.backlinkers.data, function(index, domainObject){
					// Limit top 10 domains
					if((index + 1) > 10) {
						return false;
					}
					
					if(typeof(domainObject.Dn) !== 'undefined') {
						statsBacklinkers += ('<div class="backlinker">' + domainObject.Dn + '</div>');
					}
				});
				$('li[data-bind=\\{backlinkers\\}]')
							.attr('data-content', statsBacklinkers)
							.popover({trigger:'click', placement:'top', html:1})
							.addClass('clickable');
				$(document).on('click', 'li[data-bind=\\{backlinkers\\}] + div.popover div.backlinker', function(jqEvent){
					var linkUrl = $(this).text();
					var backlinkerStatsInSession = false;
					if( window.sessionStorage !== null ) {
						backlinkerStatsInSession = JSON.parse(sessionStorage.getItem('competitorstats.' + linkUrl));
					}
					getCompetitorStatsData(linkUrl, this, backlinkerStatsInSession);
					return false;
				});
			}
			
			// Tags
			if(typeof(seoStats.tags) === 'object' && seoStats.tags) {
				var statsTags = '';
				$.each(seoStats.tags.data, function(index, tagObject){
					// Limit top 30 keywords
					if((index + 1) > 30) {
						return false;
					}
					
					if(typeof(tagObject.Ph) !== 'undefined' && tagObject.Ph != '(Other)') {
						statsTags += ('<div>' + tagObject.Ph + '</div>');
					}
				});
				$('li[data-bind=\\{tags\\}]')
							.attr('data-content', statsTags)
							.popover({trigger:'click', placement:'top', html:1})
							.addClass('clickable');
			}
			
			// Google Page Rank icon
			$('li[data-bind=\\{google_page_rank\\}]').html(seoStats.pricon);
			
			// Build the traffic graph, get target canvas context 2d to render chart
        	if(!!document.createElement('canvas').getContext && $('#statscanvas').length) {
        		var generateStatsLineChart = function(animation) {
        			// Skip empty data
        			if(seoStats.trafficgraph && seoStats.trafficgraph.hasOwnProperty('length')) {
        				var arrayLength = seoStats.trafficgraph.length;
        				if(arrayLength == 0) {
        					$('div.seostatschart').remove();
        					return;
        				}
        			}
        			
        			if(seoStats.trafficgraph == null) {
        				$('div.seostatschart').remove();
    					return;
        			}
        			
        			// Get HTMLCanvasElement
                    var canvas = $('#statscanvas').get(0);
                    
                    var visiblityParent = $(canvas).parents('#seo_stats').css('display');
                    if(visiblityParent == 'none') {
                    	return;
                    }
                    // Get parent container width
                    var containerWidth = $(canvas).parent().width();
                    // Set dinamically canvas width
                    canvas.width = containerWidth;
                    $(canvas).css('min-width', canvas.width);
                    canvas.height = 170;
                    
        			var chartData = {};
                    var chartOptions = {animation:true, scaleFontSize: 10, scaleOverride: true, scaleSteps:1, scaleStepWidth: 50};
                    
                	// Instance Chart object lib
                    var canvasContext = canvas.getContext('2d');
                	var chartJS = new JMapChart(canvasContext);
                	
                	// Max value encountered
                	var maxValue = 10;
                	
                	// Normalize chart data to render
                	chartData.labels = new Array();
                	chartData.datasets = new Array();
                	var subDataSet = new Array();
                	var modulo = 14 - parseInt ( containerWidth / 100);
                	if($(window).width() > 2500) {
                		modulo = 18 - parseInt ( containerWidth / 100);
                	}
                	var counter = 0;
                	var lastValue = null;
                	var firstLabel = false;
                	var allValues = seoStats.trafficgraph.length < 14 ? true : false;
                    $.each(seoStats.trafficgraph, function(index, statObject){
                    	if(counter == 0) {
                    		counter++;
                    		return true;
                    	}
                    	var label = Object.keys(statObject)[0];
                    	var value = statObject[label];
                    	
                    	if((counter % modulo == 0 || allValues) && parseInt(value)) {
                    		if(!firstLabel) {
                        		label = '         ' + label;
                        		firstLabel = true;
                    		} else {
                    			label = '   ' + label;
                    		}
                			chartData.labels[chartData.labels.length] = label;
                    		subDataSet[subDataSet.length] = value = parseInt(value);
                    		if(value > maxValue) {
                    			maxValue = value;
                    		}
                    	}
                    	lastValue = parseInt(value);
                    	counter++;
                    });
                    
                    chartData.labels[chartData.labels.length] = COM_JMAP_STATSCROP_GRAPH_TODAY;
                    subDataSet[subDataSet.length] = lastValue;
                    if(lastValue > maxValue) {
            			maxValue = lastValue;
            		}
                    
                    // Override scale
                    chartOptions.scaleStepWidth = 10;
                    if((maxValue / 100) > 0) {
                    	var multiplier = parseInt(maxValue / 50);
                    	chartOptions.scaleStepWidth = 10 + (multiplier * 10);
                    }
                    chartOptions.scaleSteps = parseInt((maxValue / chartOptions.scaleStepWidth) + 1);
                    
                    chartData.datasets[0] = {
                    		fillColor : "rgba(151,187,205,0.5)",
        					strokeColor : "rgba(151,187,205,1)",
        					pointColor : "rgba(151,187,205,1)",
        					pointStrokeColor : "#fff",
        					data : subDataSet
                    };
                	
                    // Override options
                    chartOptions.animation = animation; 
                    
                    // Paint chart on canvas
                	chartJS.Line(chartData, chartOptions);
                }
        	
        		$(window).on('resize', {bind:this}, function(event){
        			generateStatsLineChart();
            	})
            	
            	// Start generation
            	setTimeout(function(){
            		generateStatsLineChart(true);
            	}, 0)
        	}
		};
		
		/**
		 * Format the Siterankdata Seo Stats
		 * 
		 * @access private
		 * @return Void
		 */
		var formatSiterankdataSeoStats = function(seoStats) {
			// Siterankdata rank
			var rankFontSize = '';
			var rankFormatted = seoStats.rank;
			if(!isNaN(parseInt(rankFormatted))) {
				rankFormatted = parseInt(rankFormatted).toLocaleString().replace(/,/g, '.');
				if(rankFormatted.length > 7) {
					rankFontSize = ' style="font-size:18px"';
				}
			}
			$('li[data-bind=\\{siterankdata_rank\\}]').html('<span' + rankFontSize + '>' + rankFormatted + '</span>');
			
			var dailyVisitorsFontSize = '';
			var dailyVisitorsFormatted = seoStats.dailyvisitors;
			if(!isNaN(parseInt(dailyVisitorsFormatted))) {
				dailyVisitorsFormatted = parseInt(dailyVisitorsFormatted).toLocaleString().replace(/,/g, '.');
				if(dailyVisitorsFormatted.length > 7) {
					dailyVisitorsFontSize = ' style="font-size:18px"';
				}
				if(dailyVisitorsFormatted.length > 9) {
					dailyVisitorsFontSize = ' style="font-size:14px"';
				}
			}
			$('li[data-bind=\\{daily_unique_visitors\\}]').html('<span' + dailyVisitorsFontSize + '>' + dailyVisitorsFormatted + '</span>');
			
			var monthlyVisitorsFontSize = '';
			var monthlyVisitorsFormatted = seoStats.monthlyvisitors;
			if(!isNaN(parseInt(monthlyVisitorsFormatted))) {
				monthlyVisitorsFormatted = parseInt(monthlyVisitorsFormatted).toLocaleString().replace(/,/g, '.');
				if(monthlyVisitorsFormatted.length > 7) {
					monthlyVisitorsFontSize = ' style="font-size:18px"';
				}
				if(monthlyVisitorsFormatted.length > 9) {
					monthlyVisitorsFontSize = ' style="font-size:14px"';
				}
			}
			$('li[data-bind=\\{monthly_visitors\\}]').html('<span' + monthlyVisitorsFontSize + '>' + monthlyVisitorsFormatted + '</span>');
			
			var yearlyVisitorsFontSize = '';
			var yearlyVisitorsFormatted = seoStats.yearlyvisitors;
			if(!isNaN(parseInt(yearlyVisitorsFormatted))) {
				yearlyVisitorsFormatted = parseInt(yearlyVisitorsFormatted).toLocaleString().replace(/,/g, '.');
				if(yearlyVisitorsFormatted.length > 7) {
					yearlyVisitorsFontSize = ' style="font-size:18px"';
				}
				if(yearlyVisitorsFormatted.length > 9) {
					yearlyVisitorsFontSize = ' style="font-size:14px"';
				}
			}
			$('li[data-bind=\\{yearly_visitors\\}]').html('<span' + yearlyVisitorsFontSize + '>' + yearlyVisitorsFormatted + '</span>');
			
			// Siterankdata competitors
			if(typeof(seoStats.siterankdatacompetitors) === 'object' && seoStats.siterankdatacompetitors) {
				var siterankdataCompetitors = '';
				$.each(seoStats.siterankdatacompetitors.data, function(index, domainObject){
					// Limit top 10 domains
					if((index + 1) > 15) {
						return false;
					}
					
					if(typeof(domainObject.competitor) !== 'undefined') {
						siterankdataCompetitors += ('<div class="competitor">' + domainObject.competitor + '</div>');
					}
				});
				$('li[data-bind=\\{siterankdata_competitors\\}]')
							.attr('data-content', siterankdataCompetitors)
							.popover({trigger:'click', placement:'top', html:1})
							.addClass('clickable');
				$(document).on('click', 'li[data-bind=\\{siterankdata_competitors\\}] + div.popover div.competitor', function(jqEvent){
					var linkUrl = $(this).text();
					var competitorStatsInSession = false;
					if( window.sessionStorage !== null ) {
						competitorStatsInSession = JSON.parse(sessionStorage.getItem('competitorstats.' + linkUrl));
					}
					getCompetitorStatsData(linkUrl, this, competitorStatsInSession);
					return false;
				});
			}
			
			// Website screen
			var imageLink = $(seoStats.websitescreen).attr('src');
			$('li[data-bind=\\{website_screen\\}]').html('<a class="siterankdata_website_screen" href="' + imageLink + '">' + seoStats.websitescreen + '</a>');
			
			// Now bind fancybox effect on the newly appended chart image
			$('li.fancybox-image a.siterankdata_website_screen')
				.attr('title', COM_JMAP_WEBSITE_SCREEN)
				.fancybox({
					type: 'image',
			    	openEffect	: 'elastic',
			    	closeEffect	: 'elastic'
			});
		};
		
		/**
		 * Format the Hypestat Seo Stats
		 * 
		 * @access private
		 * @return Void
		 */
		var formatHypestatSeoStats = function(seoStats) {
			// Siterankdata rank
			var rankFontSize = '';
			var rankFormatted = seoStats.rank;
			if(!isNaN(parseInt(rankFormatted))) {
				rankFormatted = parseInt(rankFormatted).toLocaleString().replace(/,/g, '.');
				if(rankFormatted.length > 7) {
					rankFontSize = ' style="font-size:18px"';
				}
			}
			$('li[data-bind=\\{hypestat_rank\\}]').html('<span' + rankFontSize + '>' + rankFormatted + '</span>');
			
			var dailyVisitorsFontSize = '';
			var dailyVisitorsFormatted = seoStats.dailyvisitors;
			if(!isNaN(parseInt(dailyVisitorsFormatted))) {
				dailyVisitorsFormatted = parseInt(dailyVisitorsFormatted).toLocaleString().replace(/,/g, '.');
				if(dailyVisitorsFormatted.length > 7) {
					dailyVisitorsFontSize = ' style="font-size:18px"';
				}
			}
			$('li[data-bind=\\{daily_unique_visitors\\}]').html('<span' + dailyVisitorsFontSize + '>' + dailyVisitorsFormatted + '</span>');
			
			var monthlyVisitorsFontSize = '';
			var monthlyVisitorsFormatted = seoStats.monthlyvisitors;
			if(!isNaN(parseInt(monthlyVisitorsFormatted))) {
				monthlyVisitorsFormatted = parseInt(monthlyVisitorsFormatted).toLocaleString().replace(/,/g, '.');
				if(monthlyVisitorsFormatted.length > 7) {
					monthlyVisitorsFontSize = ' style="font-size:18px"';
				}
				if(monthlyVisitorsFormatted.length > 9) {
					monthlyVisitorsFontSize = ' style="font-size:14px"';
				}
			}
			$('li[data-bind=\\{monthly_visitors\\}]').html('<span' + monthlyVisitorsFontSize + '>' + monthlyVisitorsFormatted + '</span>');
			
			$('li[data-bind=\\{pages_per_visit\\}]').html(seoStats.pagespervisit);
			
			var dailyPageviewsFontSize = '';
			var dailyPageviewsFormatted = seoStats.dailypageviews;
			if(!isNaN(parseInt(dailyPageviewsFormatted))) {
				dailyPageviewsFormatted = parseInt(dailyPageviewsFormatted).toLocaleString().replace(/,/g, '.');
				if(dailyPageviewsFormatted.length > 7) {
					dailyPageviewsFontSize = ' style="font-size:18px"';
				}
				if(dailyPageviewsFormatted.length > 9) {
					dailyPageviewsFontSize = ' style="font-size:14px"';
				}
			}
			$('li[data-bind=\\{daily_pageviews\\}]').html('<span' + dailyPageviewsFontSize + '>' + dailyPageviewsFormatted + '</span>');
			
			$('li[data-bind=\\{backlinks\\}]').html(seoStats.backlinks.toLocaleString().replace(/,/g, '.'));
			
			// Website screen
			var imageLink = $(seoStats.websitescreen).attr('src');
			$('li[data-bind=\\{website_screen\\}]').html('<a class="hypestat_website_screen" href="' + imageLink + '">' + seoStats.websitescreen + '</a>');
			
			// Now bind fancybox effect on the newly appended chart image
			$('li.fancybox-image a.hypestat_website_screen')
				.attr('title', COM_JMAP_WEBSITE_SCREEN)
				.fancybox({
					type: 'image',
			    	openEffect	: 'elastic',
			    	closeEffect	: 'elastic'
			});
			
			$('div[data-bind=\\{website_report_text\\}]').html(seoStats.reporttext).removeClass('well-hidden');
			if(!seoStats.reporttext){
				$('div[data-bind=\\{website_report_text\\}]').addClass('well-empty');
			}
		};
		
		/**
		 * Format the Website Informer Seo Stats
		 * 
		 * @access private
		 * @return Void
		 */
		var formatWebsiteinformerSeoStats = function(seoStats) {
			// Siterankdata rank
			var rankFontSize = '';
			var rankFormatted = seoStats.rank;
			if(!isNaN(parseInt(rankFormatted))) {
				rankFormatted = parseInt(rankFormatted).toLocaleString().replace(/,/g, '.');
				if(rankFormatted.length > 7) {
					rankFontSize = ' style="font-size:18px"';
				}
			}
			$('li[data-bind=\\{websiteinformer_rank\\}]').html('<span' + rankFontSize + '>' + rankFormatted + '</span>');
			
			var dailyVisitorsFontSize = '';
			var dailyVisitorsFormatted = seoStats.dailyvisitors;
			if(!isNaN(parseInt(dailyVisitorsFormatted))) {
				dailyVisitorsFormatted = parseInt(dailyVisitorsFormatted).toLocaleString().replace(/,/g, '.');
				if(dailyVisitorsFormatted.length > 7) {
					dailyVisitorsFontSize = ' style="font-size:18px"';
				}
			}
			$('li[data-bind=\\{daily_visitors\\}]').html('<span' + dailyVisitorsFontSize + '>' + dailyVisitorsFormatted + '</span>');
			
			var dailyPageviewsFontSize = '';
			var dailyPageviewsFormatted = seoStats.dailypageviews;
			if(!isNaN(parseInt(dailyPageviewsFormatted))) {
				dailyPageviewsFormatted = parseInt(dailyPageviewsFormatted).toLocaleString().replace(/,/g, '.');
				if(dailyPageviewsFormatted.length > 7) {
					dailyPageviewsFontSize = ' style="font-size:18px"';
				}
				if(dailyPageviewsFormatted.length > 9) {
					dailyPageviewsFontSize = ' style="font-size:14px"';
				}
			}
			$('li[data-bind=\\{daily_pageviews\\}]').html('<span' + dailyPageviewsFontSize + '>' + dailyPageviewsFormatted + '</span>');
			
			// Website screen
			var imageLink = $(seoStats.websitescreen).attr('src');
			$('li[data-bind=\\{website_screen\\}]').html('<a class="websiteinformer_website_screen" href="' + imageLink + '">' + seoStats.websitescreen + '</a>');
			
			// Now bind fancybox effect on the newly appended chart image
			$('li.fancybox-image a.websiteinformer_website_screen')
				.attr('title', COM_JMAP_WEBSITE_SCREEN)
				.fancybox({
					type: 'image',
			    	openEffect	: 'elastic',
			    	closeEffect	: 'elastic'
			});
			
			$('div[data-bind=\\{website_report_text\\}]').html(seoStats.reporttext).removeClass('well-hidden');
			if(!seoStats.reporttext){
				$('div[data-bind=\\{website_report_text\\}]').addClass('well-empty');
			}
		};
		
		/**
		 * Format the XRanks Seo Stats
		 * 
		 * @access private
		 * @return Void
		 */
		var formatXRanksSeoStats = function(seoStats) {
			// Siterankdata rank
			var rankFontSize = '';
			var rankFormatted = seoStats.globalrank;
			rankFormatted = rankFormatted.replace(/,/g, '.');
			if(rankFormatted.length > 7) {
				rankFontSize = ' style="font-size:18px"';
			}
			$('li[data-bind=\\{global_rank\\}]').html('<span' + rankFontSize + '>' + rankFormatted + '</span>');
			
			$('li[data-bind=\\{organic_visit\\}]').html(seoStats.organicvisit);
			
			$('li[data-bind=\\{domain_authority\\}]').html(seoStats.domainauthority);
			
			$('li[data-bind=\\{traffic\\}]').html(seoStats.traffic);
			
			$('li[data-bind=\\{backlinks\\}]').html(seoStats.backlinks);
			
			$('li[data-bind=\\{organic_search_traffic\\}]').html(seoStats.organicsearchtraffic);
			
			$('li[data-bind=\\{openpagerank\\}]').html(seoStats.openpagerank);
			
			$('li[data-bind=\\{semrushrank\\}]').html(seoStats.semrushrank);
			
			$('li[data-bind=\\{semrushkeywords\\}]').html(seoStats.semrushkeywords);
			
			// XRanks competitors
			if(typeof(seoStats.competitors) === 'object' && seoStats.competitors) {
				var xranksCompetitors = '';
				$.each(seoStats.competitors.data, function(index, domainObject){
					// Limit top 10 domains
					if((index + 1) > 15) {
						return false;
					}
					
					if(typeof(domainObject.Dn) !== 'undefined') {
						xranksCompetitors += ('<div class="competitor">' + domainObject.Dn + '</div>');
					}
				});
				$('li[data-bind=\\{xranks_competitors\\}]')
							.attr('data-content', xranksCompetitors)
							.popover({trigger:'click', placement:'top', html:1})
							.addClass('clickable');
				$(document).on('click', 'li[data-bind=\\{xranks_competitors\\}] + div.popover div.competitor', function(jqEvent){
					var linkUrl = $(this).text();
					var competitorStatsInSession = false;
					if( window.sessionStorage !== null ) {
						competitorStatsInSession = JSON.parse(sessionStorage.getItem('competitorstats.' + linkUrl));
					}
					getCompetitorStatsData(linkUrl, this, competitorStatsInSession);
					return false;
				});
			}
			
			// Website screen
			var imageLink = $(seoStats.websitescreen).attr('src');
			$('li[data-bind=\\{website_screen\\}]').html('<a class="websiteinformer_website_screen" href="' + imageLink + '">' + seoStats.websitescreen + '</a>');
			
			// Now bind fancybox effect on the newly appended chart image
			$('li.fancybox-image a.websiteinformer_website_screen')
				.attr('title', COM_JMAP_WEBSITE_SCREEN)
				.fancybox({
					type: 'image',
			    	openEffect	: 'elastic',
			    	closeEffect	: 'elastic'
			});
			
			$('div[data-bind=\\{website_report_text\\}]').html(seoStats.reporttext).removeClass('well-hidden');
			if(!seoStats.reporttext){
				$('div[data-bind=\\{website_report_text\\}]').addClass('well-empty');
			}
		};
		
		/**
		 * Format the Zigstat Seo Stats
		 * 
		 * @access private
		 * @return Void
		 */
		var formatZigstatSeoStats = function(seoStats) {
			// Siterankdata rank
			$('li[data-bind=\\{zigstat_mozrank\\}]').html(seoStats.mozrank);
			
			$('li[data-bind=\\{zigstat_mozdomainauth\\}]').html(seoStats.mozdomainauth);
			
			$('li[data-bind=\\{zigstat_mozpageauth\\}]').html(seoStats.mozpageauth);
			
			$('li[data-bind=\\{zigstat_pagespeed\\}]').html(seoStats.pagespeed);
			
			// Moz Backlinks
			var mozBackLinksFontSize = '';
			var mozBackLinksFormatted = seoStats.backlinks;
			if(!isNaN(parseInt(mozBackLinksFormatted))) {
				mozBackLinksFormatted = parseInt(mozBackLinksFormatted).toLocaleString().replace(/,/g, '.');
				if(mozBackLinksFormatted.length > 7) {
					mozBackLinksFontSize = ' style="font-size:18px"';
				}
			}
			$('li[data-bind=\\{zigstat_backlinks\\}]').html('<span' + mozBackLinksFontSize + '>' + mozBackLinksFormatted + '</span>');
			
			// Open Page Rank
			$('li[data-bind=\\{zigstat_openpagerank\\}]').html(seoStats.openpagerank);
			
			var dailyVisitorsFontSize = '';
			var dailyVisitorsFormatted = seoStats.dailyvisitors;
			if(!isNaN(parseInt(dailyVisitorsFormatted))) {
				dailyVisitorsFormatted = parseInt(dailyVisitorsFormatted).toLocaleString().replace(/,/g, '.');
				if(dailyVisitorsFormatted.length > 7) {
					dailyVisitorsFontSize = ' style="font-size:18px"';
				}
			}
			$('li[data-bind=\\{zigstat_dailyvisitor\\}]').html('<span' + dailyVisitorsFontSize + '>' + dailyVisitorsFormatted + '</span>');
			
			var dailyPageviewsFontSize = '';
			var dailyPageviewsFormatted = seoStats.dailypageviews;
			if(!isNaN(parseInt(dailyPageviewsFormatted))) {
				dailyPageviewsFormatted = parseInt(dailyPageviewsFormatted).toLocaleString().replace(/,/g, '.');
				if(dailyPageviewsFormatted.length > 7) {
					dailyPageviewsFontSize = ' style="font-size:18px"';
				}
				if(dailyPageviewsFormatted.length > 9) {
					dailyPageviewsFontSize = ' style="font-size:14px"';
				}
			}
			$('li[data-bind=\\{zigstat_dailypageviews\\}]').html('<span' + dailyPageviewsFontSize + '>' + dailyPageviewsFormatted + '</span>');
			
			// Backlinks list
			if(typeof(seoStats.backlinkslist) === 'object' && seoStats.backlinkslist) {
				var zigstatBacklinksList = '';
				$.each(seoStats.backlinkslist.data, function(index, domainObject){
					// Limit top 10 domains
					if((index + 1) > 20) {
						return false;
					}
					
					if(typeof(domainObject.backlink) !== 'undefined' && domainObject.backlink != 'Description') {
						zigstatBacklinksList += ('<div class="competitor">' + domainObject.backlink + '</div>');
					}
				});
				if(zigstatBacklinksList) {
					$('li[data-bind=\\{zigstat_backlinks_list\\}]')
								.attr('data-content', zigstatBacklinksList)
								.popover({trigger:'click', placement:'top', html:1})
								.addClass('clickable');
				}
				$(document).on('click', 'li[data-bind=\\{zigstat_backlinks_list\\}] + div.popover div.competitor', function(jqEvent){
					var linkUrl = $(this).text();
					var competitorStatsInSession = false;
					if( window.sessionStorage !== null ) {
						competitorStatsInSession = JSON.parse(sessionStorage.getItem('competitorstats.' + linkUrl));
					}
					getCompetitorStatsData(linkUrl, this, competitorStatsInSession);
					return false;
				});
			}
			
			$('div[data-bind=\\{website_report_text\\}]').html(seoStats.reporttext).removeClass('well-hidden');
			if(!seoStats.reporttext){
				$('div[data-bind=\\{website_report_text\\}]').addClass('well-empty');
			}
		};
		
		/**
		 * The first operation is get informations about published data sources
		 * and start cycle over all the records using promises and recursion
		 * 
		 * @access private
		 * @return Void
		 */
		var formatSeoStats = function(seoStats) {
			switch(jmap_seostats_service) {
				case 'zigstat':
					formatZigstatSeoStats(seoStats);
				break;
				
				case 'hypestat':
					formatHypestatSeoStats(seoStats);
				break;
				
				case 'siterankdata':
					formatSiterankdataSeoStats(seoStats);
				break;
				
				case 'websiteinformer':
					formatWebsiteinformerSeoStats(seoStats);
				break;
				
				case 'xranks':
					formatXRanksSeoStats(seoStats);
				break;
				
				case 'statscrop':
				default:
					formatStatscropSeoStats(seoStats);
				break;
			}
			
			// Show stats
			$('div.single_stat_rowseparator').fadeIn(200);
			$('#seo_stats div.single_stat_container').fadeIn(200);
		};
		
		/**
		 * Function dummy constructor
		 * 
		 * @access private
		 * @param String
		 *            contextSelector
		 * @method <<IIFE>>
		 * @return Void
		 */
		(function __construct() {
			// Add the initial loading waiter
			addLoadingWaiter($('#seo_stats'));
			
			// Check firstly if seostats are already in the sessionStorage
			if( window.sessionStorage !== null ) {
				var sessionSeoStats = sessionStorage.getItem('seostats');
				var sessionSeoStatsService = sessionStorage.getItem('seostats_service');
				var sessionSeoStatsTargeturl = sessionStorage.getItem('seostats_targeturl');
				
				// Check if there is no more matching between the session service and the current enabled service
				if((sessionSeoStatsService || (sessionSeoStats && !sessionSeoStatsService)) && (jmap_seostats_service != sessionSeoStatsService || jmap_seostats_targeturl != sessionSeoStatsTargeturl)) {
					// Reset all and reload
					sessionStorage.removeItem('seostats');
					sessionStorage.removeItem('seostats_service');
					sessionStorage.removeItem('seostats_targeturl');
					window.location.reload();
					return;
				}
				
				// Seo stats found in local session storage, go on to formatting data without a new request
				if(sessionSeoStats) {
					sessionSeoStats = JSON.parse(sessionSeoStats);
					
					// Format local data
					formatSeoStats(sessionSeoStats);
					
					// Remove waiter
					$('*.waiterinfo').remove();
					
					// Avoid to go on with a new async request
					return;
				}
			}
			
			// Get stats data from remote services using Promise, and populate user interface when resolved
			getSeoStatsData();

		}).call(this);
	}

	// On DOM Ready
	$(function() {
		window.JMapSeoStats = new SeoStats();
	});
})(jQuery);