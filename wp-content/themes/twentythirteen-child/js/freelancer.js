$(function(){$("body").on("click",".page-scroll a",function(o){var l=$(this);$("html, body").stop().animate({scrollTop:$(l.attr("href")).offset().top},1500,"easeInOutExpo"),o.preventDefault()})}),$(function(){$("body").on("input propertychange",".floating-label-form-group",function(o){$(this).toggleClass("floating-label-form-group-with-value",!!$(o.target).val())}).on("focus",".floating-label-form-group",function(){$(this).addClass("floating-label-form-group-with-focus")}).on("blur",".floating-label-form-group",function(){$(this).removeClass("floating-label-form-group-with-focus")})}),$("body").scrollspy({target:".menu-menu-1-container"}),$(".navbar-collapse ul li a").click(function(){$(".navbar-toggle:visible").click()});