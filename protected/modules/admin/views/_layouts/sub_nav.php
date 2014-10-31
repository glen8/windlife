  <div id="sub_nav">
    <?php if(!empty($this->menu_add)){?>
    <?php
    $params_add=Util::param2array($this->menu_add['data']);
   	$add_menu_url=!empty($params_add)?Yii::app()->createUrl($this->menu_add['m'].'/'.$this->menu_add['c'].'/'.$this->menu_add['a'],Util::param2array($this->menu_add['data'])):Yii::app()->createUrl($this->menu_add['m'].'/'.$this->menu_add['c'].'/'.$this->menu_add['a']);
    $show_size=explode('*', $this->menu_add['size']);
    if($this->menu_add['display']=='2'){
    $this->widget('application.extensions.wl_artDialog.WLArtDialog',array(
        'title'=>$this->menu_add['name'],
        'content'=>'<em>'.$this->menu_add['name'].'</em>',
        'url'=>$add_menu_url,
        'width'=>(isset($show_size[0])?$show_size[0]:'400').'px',
        'height'=>(isset($show_size[1])?$show_size[1]:'300').'px',
        'cssClass'=>'add',
	));
    ?>
    <?php }else{?>
    <a class="add" onclick="openFullScreen('<?php echo $add_menu_url;?>')"><em><?php echo $this->menu_add['name'];?></em></a>
    <?php }}?>
    <?php $n=1;?>
    <?php foreach ($this->sub_nav as $k=>$v){?>    
    <?php if($v['display']!=1&&$v['display']!=5&&$v['display']!=6&&$v['display']!=7)continue;?>    
    <?php 
    $params_sub=Util::param2array($v['data']);
    $sub_menu_url=!empty($params_sub)?Yii::app()->createUrl($v['m'].'/'.$v['c'].'/'.$v['a'],Util::param2array($v['data'])):$sub_menu_url=Yii::app()->createUrl($v['m'].'/'.$v['c'].'/'.$v['a']);
    ?>
    <?php if($n!=1){?><span>|</span><?php }?>
    <a <?php if($v['display']==5){?>rel="<?php echo $v['data'];?>"<?php }else{?>href="<?php echo $sub_menu_url; ?>" <?php if($v['a']==Yii::app()->controller->action->id&&$v['c']==Yii::app()->controller->id){?>class="on"<?php }}?>><em><?php echo $v['name']?></em></a>
    <?php $n++;?>
    <?php }?>
  </div>
  