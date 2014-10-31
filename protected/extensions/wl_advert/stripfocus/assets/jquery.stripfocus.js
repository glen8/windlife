(function($) {
	$.fn.stripfocus = function() {
		var object = this;
		var sWidth = object.width(); // 获取焦点图的宽度（显示面积）
		var len = $("ul li", object).length; // 获取焦点图个数
		var index = 0;
		var picTimer;
		var btn = "<div class='btn'>";
		for ( var i = 0; i < len; i++) {
			btn += "<span></span>";
		}

		this.append(btn);

		$('.btn', object).css('width', sWidth + 'px');

		$('.btn span', object).css('width',
				parseInt(parseInt(sWidth / 10) + 10) + 'px');

		$(".btn span", object).css("opacity", 0.4).mouseenter(function() {

			index = $(".btn span", object).index($(this));
			showPics(index, object);
		}).eq(0).trigger("mouseenter");

		$("ul", object).css("width", sWidth * (len));

		object.hover(function() {
			clearInterval(picTimer);
		}, function() {
			picTimer = setInterval(function() {
				showPics(index, object);
				index++;
				if (index == len) {
					index = 0;
				}
			}, 3000); // 此4000代表自动播放的间隔，单位：毫秒
		}).trigger("mouseleave");

		function showPics(index, obj) { // 普通切换
			var nowLeft = -index * sWidth; // 根据index值计算ul元素的left值
			$("ul", obj).stop(true, false).animate({
				"left" : nowLeft
			}, 300); // 通过animate()调整ul元素滚动到计算出的position
			// //为当前的按钮切换到选中的效果
			$(".btn span", obj).stop(true, false).animate({
				"opacity" : "0.4"
			}, 300).eq(index).stop(true, false).animate({
				"opacity" : "1"
			}, 300); // 为当前的按钮切换到选中的效果
		}

	};
})(jQuery);
