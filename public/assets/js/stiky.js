$(document).ready((function(){var n,o=$(".sticky"),s="sticky-pin",i=o.offset().top;function t(){n=o.innerHeight(),o.css({"margin-bottom":"-"+n+"px"}),o.next().css({"padding-top":+n+"px"})}function e(){$(this).scrollTop()>=i?o.addClass(s):o.removeClass(s)}o.after('<div class="jumps-prevent"></div>'),t(),$(window).resize((function(){t()})),e(),$(window).scroll((function(){e()})),$(window).scroll((function(n){$(window).scrollTop()>=1?$("body").addClass("stiky-menu"):$("body").removeClass("stiky-menu")}))}));