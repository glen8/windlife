<?php

class Movie extends CAction{
	
	public function run(){
		$key =htmlspecialchars($_POST["searchKey"]);
		$type = htmlspecialchars($_POST["videoType"]);
		$html = file_get_contents('http://api.tudou.com/v3/gw?method=item.search&appKey=myKey&format=json&kw='.$key.'&pageNo=1&pageSize=20&channelId='.$type.'&inDays=7&media=v&sort=s');
		echo $html;
	}
}

?>