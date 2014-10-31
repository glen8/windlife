var dialog;
function dialog_show(title,url,width,height,form_name,is_form){
	if(is_form=='0'){
		dialog=art.dialog.open(url, {
		    title: title,
		    width:width,
		    height:height,
		    lock: true,
		    background: '#000', // 背景色
		    opacity: 0.4,	// 透明度
		    ok: true
		});
	}
	else{
		dialog=art.dialog.open(url, {
		    title: title,
		    width:width,
		    height:height,
		    lock: true,
		    background: '#000', // 背景色
		    opacity: 0.4,	// 透明度
		    ok: function () {
		    	var iframe = this.iframe.contentWindow;
		    	if (!iframe.document.body) {
		        	alert('iframe还没加载完毕呢');
		        	return false;
		        };
		    	iframe.document.getElementById("dosubmit").click();
		       	return false;
		    },
		    cancel: true
		});
	}	
}