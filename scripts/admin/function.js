$(document).ready(function(){
	//初始化后台面包屑
	$("p[rel='breadcrumbs']",parent.document).html($('#breadcrumbs').val());
	
	//初始化快捷方式编号
	if($('#menu_name').length>0&&$('#menu_name').val()!=''){
		$('#paneladd',parent.document).show();
		$('#paneladd a',parent.document).attr('data-name',$('#menu_name').val());
		$('#paneladd a',parent.document).attr('data-url',$('#menu_url').val());
	}
	
	
	//锁屏
	$("a[rel='lock_screen']").click(function(){
		var lock_screen_url=$(this).attr('url');
		$.post(lock_screen_url,{YII_CSRF_TOKEN:$('#YII_CSRF_TOKEN').val()},function(data){
			if(data=='1'){
				$('#index_lock_screen').show();
			}
			else{
				alert('系统错误，锁屏失败，请联系管理员');
			}
		});
	});
	
	//锁屏登陆
	$("input[rel='locklogin']").click(function(){
		var lock_screen_login_url=$(this).attr('url');
		if($("#lock_password").val()==''){
			$('#index_lock_screen h5').html('<span style="color:red;">请输入密码</span>');
		}
		else{
			$.post(lock_screen_login_url,{password:$("#lock_password").val(),YII_CSRF_TOKEN:$('#YII_CSRF_TOKEN').val()},function(data){
			    if(data=='1'){
			    	$('#index_lock_screen h5').html('锁屏状态，请输入密码解锁');
			    	$('#index_lock_screen').hide();
			    }
			    else if(data=='-1'){
			    	$('#index_lock_screen h5').html('<span style="color:red;">密码错误，请重试</span>');
			    }
			    else{
			    	alert("锁屏失效，系统将自动跳转到登陆页面");
			    	location.reload();
			    }
			});
		}
	});
	
	//左侧栏开启关闭
	$("a[rel='openClose']").click(function(){
		if($(this).data('clicknum')=='1'){
			leftMenuShow();
		}
		else{
			leftMenuHide();
		}
	});
	
	
	//内容添加页面右侧栏开启关闭
	$("#content_create .close").click(function(){
		if($(this).data('clicknum')=='1'){
			$(this).removeClass('close_on');
			$('#content_create .right').show();
			$('#content_create .left').removeClass('left_on');
			$(this).data('clicknum','');
		}
		else{
			$(this).addClass('close_on');
			$('#content_create .right').hide();
			$('#content_create .left').addClass('left_on');
			$(this).data('clicknum','1');
		}
	});
	
	//左侧菜单栏收缩
	$(document).on('click','.left_main span',function(){
		if($(this).data('clicknum')=='1'){
			$(this).data('clicknum','');
			$(this).parent().next('ul').show();
			$(this).removeClass('on');
		}
		else{
			$(this).data('clicknum','1');
			$(this).parent().next('ul').hide();
			$(this).addClass('on');
		}
	});
	
	//头部导航点击后左侧菜单填充数据  隐藏底部快捷方式
	$('.top_menu_content li').click(function(){
		//显示左侧菜单
		leftMenuShow();
		$('.top_menu_content li').removeClass('on');		
		$(this).addClass('on');		
		$("p[rel='breadcrumbs']").html($(this).children().html()+' &gt;');
		$.get($(this).attr('rel'),{parent_id:$(this).attr('val')},function(data){			
			$('.left_main').html(data);			
		});
		$('#paneladd').hide();
		$('.center_menu').hide();
	});
	
	//左侧菜单选择状态切换 和 控制中间iframe显示隐藏 和 和iframe显示栏目搜索页面
	$(document).on('click','.left_main li',function(){
		$(document).find('.left_main li').removeClass('on');
		$(this).addClass('on');		
		if($(this).children('a').attr('rel')=='iframe_center'){
		    var content_type=$(this).children('a').attr('href');
			$('.center_menu').show();
			if(content_type.indexOf('content')){
			    $('#main').attr('src',$('#content_find_column_url').val());
			    setTimeout('leftMenuHide()',1000)
			}
			else{
				leftMenuShow();
			}
		}
		else{
			$('.center_menu').hide();
		}		
	});
	
	//更新全部缓存
	setTimeout(updateAllCache,150);
	
	
	//底部快捷方式删除操作
	$(document).on('click','.panel_delete',function(){
		var panel_id=parseInt($(this).attr('val'));
		var panel_del_url=$(this).attr('rel')
		var panel_this=$(this);
		if(panel_id>0&&panel_del_url!=''){
			$.post(panel_del_url,{panel_id:panel_id,YII_CSRF_TOKEN:$('#YII_CSRF_TOKEN').val()},function(data){
				if(data=='1'){
					panel_this.parent().remove();
				}
				else{
					alert('操作失败，请联系管理员！');
				}
			});
		}
	});
	
	//底部快捷方式添加
    $('.panel_add').click(function(){
    	var menu_name=$(this).attr('data-name');
    	var menu_url=$(this).attr('data-url');
    	var panel_create_url=$(this).attr('rel')
    	if(panel_create_url!=''&&menu_name!=''&&menu_url!=''){
    		$.post(panel_create_url,{menu_name:menu_name,menu_url:menu_url,YII_CSRF_TOKEN:$('#YII_CSRF_TOKEN').val()},function(data){
    			if(data!='0'){
    				$('#panellist').append(data);
    			}
    		});
    	}
    });
    
    //列表复选框控制全选
    if($('#checkboxClick').length>0){
    	$('#checkboxClick').click(function(){
    		if($(this).attr('checked')=='checked'){
    			$('input.selectAll').attr('checked','checked');
    		}
    		else{
    			$('input.selectAll').attr('checked', false);
    		}
    	});
    }
    
    //文字控制复选框全选取消
    if($('#selectAllClick').length>0){
    	$('#selectAllClick').click(function(){
    		$('input.selectAll').attr('checked','checked');
    	});
    	$('#selectEscClick').click(function(){
    		$('input.selectAll').attr('checked',false);
    	});
    }
    
    //复选框选中删除
    if($('#deleteAllClick').length>0){
    	$('#deleteAllClick').click(function(){
    		var i=1;
    		var str='';
    		$('input.selectAll:checked').each(function(){
    			if(parseInt($(this).val())>0){
    				if(i==1){
    					str=$(this).val();
    				}
    				else{
    					str+=','+$(this).val();
    				}
        			i++;
    			}
    		});   
    		if(str!=''){
    			if(confirm('确定要删除选中的信息吗？')) {
    				jQuery.yii.submitForm(this,$(this).attr('url'),{});
    				return false;
    			} 
    			else {
    				return false;
    			}
    		}
    		else{
    			alert('请选中要删除的信息');
    		}    	    
    	});
    }
    
    //显示搜索框
    $('a[rel=click_search]').click(function(){
    	$('#search').show();
    });
    
    //标签相关
    
    //添加标签
    $('#wl_tags_create_button').click(function(){
    	if($('#wl_tags_create_input').val()!=''){
    		$.post($(this).attr('data-url'),{tags_str:$('#wl_tags_create_input').val(),YII_CSRF_TOKEN:$('input[name=YII_CSRF_TOKEN]').val()},function(data){
    			if(data!='0'){
    				$.each(data,function(i,item){
    					if($('#tags_selected_list li[data='+item.id+']').length==0){
    						$('#tags_selected_list').append('<li data="'+item.id+'"><span>'+item.title+'</span><li>');
    					}
    				});
    				total_tags();
    			}
    			else{
    				alert('系统错误,请联系管理员')
    			}
    		},'json');
    	}
    	else{
    		alert('请输入您要添加的标签');
    	}
    });
    
    //删除标签
    $('body').on('click','#tags_selected_list li',function(){
    	$(this).remove();
    	total_tags();
    });

    //显示常用标签
    $('a[rel=tags_select_a]').click(function(){
        $('#tags_used_list').show();
    });

    //从常用标签里面选择标签
    $('#tags_used_list li').click(function(){
        var tags_id=$(this).attr('data');
        if(tags_id!=''&&$('#tags_selected_list li[data='+tags_id+']').length==0){
            $('#tags_selected_list').append('<li data="'+tags_id+'"><span>'+$(this).html()+'</span><li>');
            total_tags();
        }
    });

});

//表单验证后方法
function afterValidate(form, attribute, data, hasError){
	if(hasError){
		$('#'+attribute.errorID).removeClass('onSuccess');
	}
	else{
		if($("#"+attribute.id).val()!=''){
		    $('#'+attribute.errorID).show();
		    $('#'+attribute.errorID).addClass('onSuccess');
		    $('#'+attribute.errorID).html('输入正确');
		}
		else{
			$('#'+attribute.errorID).removeClass('onSuccess');
			$('#'+attribute.errorID).html('');
		}
	}
}

//删除确认
function confirmurl(url,message) {
	if(confirm(message)){
		window.location.href=url;
	}
}

//更新全部缓存
function updateAllCache(){
	if($('#updateCacheStep').length>0&&$('#updateCacheStep').val()!=''&&$('#updateCacheStep').val()!='0'){
		var step_url=$('#updateCacheStep').val();
		$.ajax({
			type: "GET",
			url: step_url,
			dataType: 'json',
			async:false,
			success: function(data){
				if(data.next_step_url!=undefined){
			        $('#updateCacheMessage').append('<li>'+data.message+'..........</li>');
			        $('#updateCacheStep').val(data.next_step_url);	
			        setTimeout(updateAllCache,150);
				}
				else{
					$('#updateCacheMessage').append('<li class="red">全站缓存更新成功..........</li>');
				}	
				document.getElementById('updateCacheMessage').scrollTop = document.getElementById('updateCacheMessage').scrollHeight;
			}
		});
	}
}

//表单面板切换
function formTypeTab(address,num,n){
    for(i=1;i<=num;i++){
	    document.getElementById(address+'_'+i).className=address+'_off';
		document.getElementById(address+'_content_'+i).style.display='none';
	}
	document.getElementById(address+'_'+n).className=address+'_on';
	document.getElementById(address+'_content_'+n).style.display='block';
	document.getElementById('form_type').value=document.getElementById(address+'_'+n).attributes['rel'].nodeValue;
}

//左侧菜单关闭
function leftMenuHide(){
	$('#index_content .left_main').hide();
	$('#index_content .left_menu').addClass('left_menu_on');
	$("a[rel='openClose']").removeClass('open');
	$("a[rel='openClose']").addClass('close');
	$("a[rel='openClose']").data('clicknum','1');
	$('body').addClass('on');
}
function leftMenuShow(){
	$('#index_content .left_menu').removeClass('left_menu_on');
	$('#index_content .left_main').show();
	$("a[rel='openClose']").removeClass('close');
	$("a[rel='openClose']").addClass('open');
	$("a[rel='openClose']").data('clicknum','');
	$('body').removeClass('on');
}

//全屏弹出添加内容页面
var windowObj;
function openFullScreen(url){
	if(windowObj!=null) windowObj.close();
	var width=window.screen.availWidth-20;
	var height=window.screen.availHeight-42;
	var top=window.screenY+8;
	windowObj=window.open(url,'window',"width="+width+",height="+height+",left=0,top="+top+",toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,status=no");
}

//上传图片后取消图片
function escImage(id){
	if(id!=''){
		$('#'+id).val('');
		$('#'+id).next('img').attr('src','/images/admin/upload_pic.png');
	}
}

//统计添加的标签
function total_tags(){
	var tags_str='';
	$.each($('#tags_selected_list li[data]'),function(i,item){
		tags_str+=(i==0)?$(item).attr('data'):','+$(item).attr('data');
	});	 
	$('.tags input[type=hidden]').val(tags_str);
}