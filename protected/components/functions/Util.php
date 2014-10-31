<?php

class Util extends CController {
	
	// 截取字符串方法
	public static function substr($str, $cutleng) {
		$strleng = mb_strlen ( $str, 'utf-8' );
		if ($cutleng >= $strleng) {
			return $str;
		}
		$notchinanum = 0;
		for($i = 0; $i < $cutleng; $i ++) {
			if (ord ( mb_substr ( $str, $i, 1, 'utf-8' ) ) <= 128) {
				$notchinanum ++;
			}
		}
		if (($cutleng % 2 == 1) && ($notchinanum % 2 == 0)) {
			$cutleng ++;
		}
		if (($cutleng % 2 == 0) && ($notchinanum % 2 == 1)) {
			$cutleng ++;
		}
		$str = mb_substr ( $str, 0, $cutleng, 'utf-8' );
		return $str . "...";
	}
	// 删除html格式
	public static function delhtml($str) {
		$st = - 1;
		$et = - 1;
		$stmp = array ();
		$stmp [] = "&nbsp;";
		$len = strlen ( $str );
		for($i = 0; $i < $len; $i ++) {
			$ss = substr ( $str, $i, 1 );
			if (ord ( $ss ) == 60) {
				$st = $i;
			}
			if (ord ( $ss ) == 62) {
				$et = $i;
				if ($st != - 1) {
					$stmp [] = substr ( $str, $st, $et - $st + 1 );
				}
			}
		}
		$str = str_replace ( $stmp, "", $str );
		return $str;
	}
	// 删除html格式和样式
	public static function html2text($str) {
		$str = preg_replace ( "/<style .*?<\/style>/is", "", $str );
		$str = preg_replace ( "/<script .*?<\/script>/is", "", $str );
		$str = preg_replace ( "/<br \s*\/?\/>/i", "\n", $str );
		$str = preg_replace ( "/<\/?p>/i", "\n\n", $str );
		$str = preg_replace ( "/<\/?td>/i", "\n", $str );
		$str = preg_replace ( "/<\/?div>/i", "\n", $str );
		$str = preg_replace ( "/<\/?blockquote>/i", "\n", $str );
		$str = preg_replace ( "/<\/?li>/i", "\n", $str );
		$str = preg_replace ( "/\&nbsp\;/i", " ", $str );
		$str = preg_replace ( "/\&nbsp/i", " ", $str );
		$str = preg_replace ( "/\&amp\;/i", "&", $str );
		$str = preg_replace ( "/\&amp/i", "&", $str );
		$str = preg_replace ( "/\&lt\;/i", "<", $str );
		$str = preg_replace ( "/\&lt/i", "<", $str );
		$str = preg_replace ( "/\&ldquo\;/i", '"', $str );
		$str = preg_replace ( "/\&ldquo/i", '"', $str );
		$str = preg_replace ( "/\&lsquo\;/i", "'", $str );
		$str = preg_replace ( "/\&lsquo/i", "'", $str );
		$str = preg_replace ( "/\&rsquo\;/i", "'", $str );
		$str = preg_replace ( "/\&rsquo/i", "'", $str );
		$str = preg_replace ( "/\&gt\;/i", ">", $str );
		$str = preg_replace ( "/\&gt/i", ">", $str );
		$str = preg_replace ( "/\&rdquo\;/i", '"', $str );
		$str = preg_replace ( "/\&rdquo/i", '"', $str );
		$str = strip_tags ( $str );
		$str = html_entity_decode ( $str, ENT_QUOTES );
		$str = preg_replace ( "/\&\#.*?\;/i", "", $str );
		
		return $str;
	}
	// 判断字符串是否序列化
	public static function is_serialized($data) {
		// if it isn't a string, it isn't serialized
		if (! is_string ( $data ))
			return false;
		$data = trim ( $data );
		if ('N;' == $data)
			return true;
		$length = strlen ( $data );
		if ($length < 4)
			return false;
		if (':' !== $data [1])
			return false;
		$lastc = $data [$length - 1];
		if (';' !== $lastc && '}' !== $lastc)
			return false;
		$token = $data [0];
		switch ($token) {
			case 's' :
				if ('"' !== $data [$length - 2])
					return false;
			case 'a' :
			case 'O' :
				return ( bool ) preg_match ( "/^{$token}:[0-9]+:/s", $data );
			case 'b' :
			case 'i' :
			case 'd' :
				return ( bool ) preg_match ( "/^{$token}:[0-9.E-]+;\$/", $data );
		}
		return false;
	}
	
	
	/**
	 * 将get地址参数转化为数组
	 *
	 * @param array $data
	 * @param bool $isformdata
	 * @return string
	 */
     public static function param2array($data) {
		if (empty($data))return null;
		if(strstr($data,'&')){
			$a=explode('&',$data);
			$param_array=array();
			foreach ($a as $v){
				$b=explode('=',$v);
				$param_array[$b[0]]=$b[1];
			}
			return $param_array;
		}
		else{
			if(substr_count($data, '=')==1){
				$b=explode('=',$data);
				$param_array[$b[0]]=$b[1];
				return $param_array;
			}
			else{
				return null;
			}
		}
		return null;
	}
	

	public static function pinyin($_String, $_Code='UTF8'){ //GBK页面可改为gb2312，其他随意填写为UTF8
	    $_DataKey = "a|ai|an|ang|ao|ba|bai|ban|bang|bao|bei|ben|beng|bi|bian|biao|bie|bin|bing|bo|bu|ca|cai|can|cang|cao|ce|ceng|cha".
	        "|chai|chan|chang|chao|che|chen|cheng|chi|chong|chou|chu|chuai|chuan|chuang|chui|chun|chuo|ci|cong|cou|cu|".
	        "cuan|cui|cun|cuo|da|dai|dan|dang|dao|de|deng|di|dian|diao|die|ding|diu|dong|dou|du|duan|dui|dun|duo|e|en|er".
	        "|fa|fan|fang|fei|fen|feng|fo|fou|fu|ga|gai|gan|gang|gao|ge|gei|gen|geng|gong|gou|gu|gua|guai|guan|guang|gui".
	        "|gun|guo|ha|hai|han|hang|hao|he|hei|hen|heng|hong|hou|hu|hua|huai|huan|huang|hui|hun|huo|ji|jia|jian|jiang".
	        "|jiao|jie|jin|jing|jiong|jiu|ju|juan|jue|jun|ka|kai|kan|kang|kao|ke|ken|keng|kong|kou|ku|kua|kuai|kuan|kuang".
	        "|kui|kun|kuo|la|lai|lan|lang|lao|le|lei|leng|li|lia|lian|liang|liao|lie|lin|ling|liu|long|lou|lu|lv|luan|lue".
	        "|lun|luo|ma|mai|man|mang|mao|me|mei|men|meng|mi|mian|miao|mie|min|ming|miu|mo|mou|mu|na|nai|nan|nang|nao|ne".
	        "|nei|nen|neng|ni|nian|niang|niao|nie|nin|ning|niu|nong|nu|nv|nuan|nue|nuo|o|ou|pa|pai|pan|pang|pao|pei|pen".
	        "|peng|pi|pian|piao|pie|pin|ping|po|pu|qi|qia|qian|qiang|qiao|qie|qin|qing|qiong|qiu|qu|quan|que|qun|ran|rang".
	        "|rao|re|ren|reng|ri|rong|rou|ru|ruan|rui|run|ruo|sa|sai|san|sang|sao|se|sen|seng|sha|shai|shan|shang|shao|".
	        "she|shen|sheng|shi|shou|shu|shua|shuai|shuan|shuang|shui|shun|shuo|si|song|sou|su|suan|sui|sun|suo|ta|tai|".
	        "tan|tang|tao|te|teng|ti|tian|tiao|tie|ting|tong|tou|tu|tuan|tui|tun|tuo|wa|wai|wan|wang|wei|wen|weng|wo|wu".
	        "|xi|xia|xian|xiang|xiao|xie|xin|xing|xiong|xiu|xu|xuan|xue|xun|ya|yan|yang|yao|ye|yi|yin|ying|yo|yong|you".
	        "|yu|yuan|yue|yun|za|zai|zan|zang|zao|ze|zei|zen|zeng|zha|zhai|zhan|zhang|zhao|zhe|zhen|zheng|zhi|zhong|".
	        "zhou|zhu|zhua|zhuai|zhuan|zhuang|zhui|zhun|zhuo|zi|zong|zou|zu|zuan|zui|zun|zuo";
	    
	    $_DataValue = "-20319|-20317|-20304|-20295|-20292|-20283|-20265|-20257|-20242|-20230|-20051|-20036|-20032|-20026|-20002|-19990".  
            "|-19986|-19982|-19976|-19805|-19784|-19775|-19774|-19763|-19756|-19751|-19746|-19741|-19739|-19728|-19725".  
            "|-19715|-19540|-19531|-19525|-19515|-19500|-19484|-19479|-19467|-19289|-19288|-19281|-19275|-19270|-19263".  
            "|-19261|-19249|-19243|-19242|-19238|-19235|-19227|-19224|-19218|-19212|-19038|-19023|-19018|-19006|-19003".  
            "|-18996|-18977|-18961|-18952|-18783|-18774|-18773|-18763|-18756|-18741|-18735|-18731|-18722|-18710|-18697".  
            "|-18696|-18526|-18518|-18501|-18490|-18478|-18463|-18448|-18447|-18446|-18239|-18237|-18231|-18220|-18211".  
            "|-18201|-18184|-18183|-18181|-18012|-17997|-17988|-17970|-17964|-17961|-17950|-17947|-17931|-17928|-17922".  
            "|-17759|-17752|-17733|-17730|-17721|-17703|-17701|-17697|-17692|-17683|-17676|-17496|-17487|-17482|-17468".  
            "|-17454|-17433|-17427|-17417|-17202|-17185|-16983|-16970|-16942|-16915|-16733|-16708|-16706|-16689|-16664".  
            "|-16657|-16647|-16474|-16470|-16465|-16459|-16452|-16448|-16433|-16429|-16427|-16423|-16419|-16412|-16407".  
            "|-16403|-16401|-16393|-16220|-16216|-16212|-16205|-16202|-16187|-16180|-16171|-16169|-16158|-16155|-15959".  
            "|-15958|-15944|-15933|-15920|-15915|-15903|-15889|-15878|-15707|-15701|-15681|-15667|-15661|-15659|-15652".  
            "|-15640|-15631|-15625|-15454|-15448|-15436|-15435|-15419|-15416|-15408|-15394|-15385|-15377|-15375|-15369".  
            "|-15363|-15362|-15183|-15180|-15165|-15158|-15153|-15150|-15149|-15144|-15143|-15141|-15140|-15139|-15128".  
            "|-15121|-15119|-15117|-15110|-15109|-14941|-14937|-14933|-14930|-14929|-14928|-14926|-14922|-14921|-14914".  
            "|-14908|-14902|-14894|-14889|-14882|-14873|-14871|-14857|-14678|-14674|-14670|-14668|-14663|-14654|-14645".  
            "|-14630|-14594|-14429|-14407|-14399|-14384|-14379|-14368|-14355|-14353|-14345|-14170|-14159|-14151|-14149".  
            "|-14145|-14140|-14137|-14135|-14125|-14123|-14122|-14112|-14109|-14099|-14097|-14094|-14092|-14090|-14087".  
            "|-14083|-13917|-13914|-13910|-13907|-13906|-13905|-13896|-13894|-13878|-13870|-13859|-13847|-13831|-13658".  
            "|-13611|-13601|-13406|-13404|-13400|-13398|-13395|-13391|-13387|-13383|-13367|-13359|-13356|-13343|-13340".  
            "|-13329|-13326|-13318|-13147|-13138|-13120|-13107|-13096|-13095|-13091|-13076|-13068|-13063|-13060|-12888".  
            "|-12875|-12871|-12860|-12858|-12852|-12849|-12838|-12831|-12829|-12812|-12802|-12607|-12597|-12594|-12585".  
            "|-12556|-12359|-12346|-12320|-12300|-12120|-12099|-12089|-12074|-12067|-12058|-12039|-11867|-11861|-11847".  
            "|-11831|-11798|-11781|-11604|-11589|-11536|-11358|-11340|-11339|-11324|-11303|-11097|-11077|-11067|-11055".  
            "|-11052|-11045|-11041|-11038|-11024|-11020|-11019|-11018|-11014|-10838|-10832|-10815|-10800|-10790|-10780".  
            "|-10764|-10587|-10544|-10533|-10519|-10331|-10329|-10328|-10322|-10315|-10309|-10307|-10296|-10281|-10274".  
            "|-10270|-10262|-10260|-10256|-10254";  
	    
         $_TDataKey   = explode('|', $_DataKey);
         $_TDataValue = explode('|', $_DataValue);
	     $_Data = array_combine($_TDataKey, $_TDataValue);
	     arsort($_Data);
	     reset($_Data);
	     if($_Code!= 'gb2312') $_String = self::_U2_Utf8_Gb($_String);
	     $_Res = '';
	     for($i=0; $i<strlen($_String); $i++) {
	     	$_P = ord(substr($_String, $i, 1));
	     	if($_P>160) {
	     		$_Q = ord(substr($_String, ++$i, 1)); 
	     		$_P = $_P*256 + $_Q - 65536;
	        }
	        $_Res .= self::_Pinyin($_P, $_Data);
	     }
	     return preg_replace("/[^a-z0-9]*/", '', $_Res);
	 }
	 
	 private static function _Pinyin($_Num, $_Data){
	 	 if($_Num>0 && $_Num<160 ){
	 	 	return chr($_Num);
	 	 }
	 	 elseif($_Num<-20319 || $_Num>-10247){
	 	 	return '';
	 	 }
	 	 else{
	 	 	foreach($_Data as $k=>$v){ if($v<=$_Num) break; }
	 	 	return $k;
	     }
	}
	
	private static function _U2_Utf8_Gb($_C){
		$_String = '';
	    if($_C < 0x80){
	        $_String .= $_C;
	    }
	    elseif($_C < 0x800) {
	    	$_String .= chr(0xC0 | $_C>>6);
	    	$_String .= chr(0x80 | $_C & 0x3F);
	    }
	    elseif($_C < 0x10000){
	    	$_String .= chr(0xE0 | $_C>>12);
	    	$_String .= chr(0x80 | $_C>>6 & 0x3F);
	    	$_String .= chr(0x80 | $_C & 0x3F);
	    }elseif($_C < 0x200000) {
	    	$_String .= chr(0xF0 | $_C>>18);
	    	$_String .= chr(0x80 | $_C>>12 & 0x3F);
	    	$_String .= chr(0x80 | $_C>>6 & 0x3F);
	    	$_String .= chr(0x80 | $_C & 0x3F);
	    }
	    return iconv('UTF-8', 'GB2312', $_String);
	}
	
	public static function text2array($data){
		if(empty($data))return null;
		$str=preg_replace("/\s+/", ",", $data);
		$text_array=explode(',', $str);
	    $text_array=array_filter($text_array);
	    $result_array=array();
	    foreach ($text_array as $v){
	    	if(substr_count($v, '|')==1){
	    		$tmp_array=explode('|', $v);
	    		$result_array[$tmp_array[0]]=$tmp_array[1];
	    	}
	    }
	    return $result_array;
	}
	
	public static function array2text($data){
		if(!is_array($data))return null;
		$text='';
		foreach ($data as $k=>$v){
			if(empty($text)){
				$text.=$k.'|'.$v;
			}
			else{
				$text.="\r\n".$k.'|'.$v;
			}
		}
		return $text;
	}
	
	public static function formatBytes($size) {
		$units = array(' B', ' KB', ' MB', ' GB', ' TB');
		for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
		return round($size, 2).$units[$i];
	}
	
	public static function arrchild2array($arrchild_str){
	    if(strlen($arrchild_str)<2)return false;
	    $arrchild_array=explode(',', $arrchild_str);
	    return array_splice($arrchild_array,1);
	}
}
?>