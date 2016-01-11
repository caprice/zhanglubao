function Lazyload(options){
	this.options = $.extend({},Lazyload.DEFAULTS,options||{});
	this.show();
}
(function($){
	$.extend(Lazyload,{
		DEFAULTS:{
			container:document,
			attr:'lazy-src',
			timeout:200
		},
		init:function(options){
			var options = options||{};
			new Lazyload(options);
		}
	});
	Lazyload.prototype = {
		getClient:function(){
			return{'top':document.documentElement.clientHeight+Math.max(document.documentElement.scrollTop,document.body.scrollTop),'left':document.documentElement.clientWidth+Math.max(document.documentElement.scrollLeft,document.body.scrollLeft)};
		},
		check:function(){
			this.container = $(this.options.container);
			this.imgNum = this.container.find('img['+ this.options.attr +']');
			var _this = this;
			if(this.imgNum.length){
				this.timer&&clearTimeout(this.timer);
				this.timer = setTimeout(function(){
					var arr = [],gc = _this.getClient();
					$.each(_this.imgNum,function(i,o){
						if($(o).offset().top <= gc.top && $(o).offset().left <= gc.left){
							var attrval = $(o).attr('lazy-src');attrval&&$(o).attr('src',attrval).removeAttr('lazy-src').hide().fadeIn();
						}else{
							arr.push(o);
						}
					});
					_this.imgNum = arr;
				},this.options.timeout);
			}else{
				$(window).unbind('scroll',this.check);
				$(window).unbind('resize',this.check);
			}
		},
		show:function(){
			var _this = this;
			$(window).bind('scroll',function(){_this.check()});
			$(window).bind('resize',function(){_this.check()});
			this.check();
		}
	}
	$.extend({
		Lazyload: Lazyload
	});
})(jQuery);
$(document).ready(function(){
	Lazyload.init({
		container:document,
		attr:'lazy-src',
		timeout:200
	});
});