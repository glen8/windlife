$(document).ready(function(){
	var wl_total_advert_url=$('input[name=wl_total_advert_url]').val();
	var YII_CSRF_TOKEN=$('input[name=YII_CSRF_TOKEN]').val();
	//广告访问统计代码
	$(document).on('click','a[rel=wl_advert_redirect]',function(){
		var object=$(this);
		var ad_id=parseInt($(this).attr('id-data'));
		if(ad_id>0){
			$.post(wl_total_advert_url,{ad_id:ad_id,YII_CSRF_TOKEN:YII_CSRF_TOKEN},function(){
				object.attr('target')=='_blank'?top.location.href=object.attr('url-data'):location.href=object.attr('url-data');
			});
		}
	});
});