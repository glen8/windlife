<?php $this->renderPartial('application.modules.admin.views._layouts.sub_nav');?>
<div id="search">
  <?php $form=$this->beginWidget('CActiveForm', array(
  'action'=>Yii::app()->createUrl($this->route,array('column_id'=>$column_info['id'])),
  'method'=>'get',
  )); ?>
  <p class="text"><?php echo $form->label($search_model,'inputtime'); ?>：</p>
    <p class="input">
  <?php 
  $this->widget('zii.widgets.jui.CJuiDatePicker', array(  
        'model'=>$search_model,  
        'attribute'=>'search_begintime', 
        'value'=>$search_model->search_begintime, 
        'options' => array(  
           'dateFormat'=>'yy-mm-dd',
        ),  
        'htmlOptions'=>array('class'=>'input-text','readonly'=>'readonly')  
  ));   
  ?>
  </p>
  <p class="text">-&nbsp;&nbsp;&nbsp;&nbsp;</p>
  <p class="input">
  <?php 
  $this->widget('zii.widgets.jui.CJuiDatePicker', array(  
        'model'=>$search_model,  
        'attribute'=>'search_endtime',  
        'value'=>$search_model->search_endtime,
        'options' => array(  
           'dateFormat'=>'yy-mm-dd',
        ),  
        'htmlOptions'=>array('class'=>'input-text','readonly'=>'readonly')  
  ));   
  ?>
  </p>
  <p class="input"><?php echo $form->dropDownList($search_model,'search_field',array('title'=>'标题','description'=>'简介','id'=>'编号'),array('class'=>'select')); ?></p>
  <p class="input"><?php echo $form->textField($search_model,'search_value',array('class'=>'input-text')); ?></p>
  <p class="button_p"><?php echo CHtml::submitButton('搜索',array('class'=>'button')); ?></p>
  <?php $this->endWidget(); ?>
  <div class="clear"></div>
</div>
<?php echo CHtml::beginForm(Yii::app()->createUrl('admin/article/listorder',array('column_id'=>$column_info['id']))); ?>
<table width="100%" class="table_list">
  <thead>
    <tr>
      <th><input type="checkbox" name="ids[]" class="selectAll" id="checkboxClick" value="0" /></th>
      <th>排序</th>
      <th>编号</th>
	  <th>标题</th>
	  <th>点击量</th>
	  <th>发布人</th>
	  <th>更新时间</th>
	  <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($models as $v) {?>
    <tr>
      <td align="center" height="20"><input type="checkbox" name="ids[]" class="selectAll" value="<?php echo $v->id?>" /></td>
      <td align="center"><input name="listorders[<?php echo $v->id?>]" type="text" size="2" value="<?php echo $v->listorder?>" class="input-text-c input-text"></td>
      <td align="center"><?php echo $v->id;?></td>
      <td align="left"><?php echo $v->title;?>
        <?php if(!empty($v->thumb)){?><img alt="缩略图" src="<?php echo Yii::app()->baseUrl.'images/admin/small_img.gif'?>" /><?php }?>
        <?php if($v->islink){?><img alt="转向链接" src="<?php echo Yii::app()->baseUrl.'images/admin/link.png'?>" /><?php }?>
      </td>
      <td align="center" width="80"><?php echo $v->hits;?></td>
      <td align="center" width="120"><?php echo $v->poster['username'];?></td>      
      <td align="center" width="120"><?php echo ($v->updatetime==null)?date('Y-m-d H:i:s',strtotime($v->inputtime)):date('Y-m-d H:i:s',strtotime($v->updatetime));?></td>
      <td align="center" width="120">
        <a class="cursor" onClick="openFullScreen('<?php echo Yii::app()->createUrl('admin/article/update',array('column_id'=>$v->column_id,'id'=>$v->id));?>')">修改</a> |
        <?php echo CHtml::link('删除',array('/admin/article/delete',array('column_id'=>$column_info['id'],'id'=>$v->id)),array('submit'=>array('/admin/article/delete','column_id'=>$v->column_id,'id'=>$v->id), 'confirm'=>'确定要删除 『 '.$v->title.' 』 吗？'))?>
      </td>                        
    </tr>
    <?php }?>
  </tbody>
</table>
<div class="btn">
  <p><a id="selectAllClick" class="cursor">全选</a>/<a id="selectEscClick" class="cursor">取消</a></p>
  <p><input type="submit" class="button" name="dosubmit" value="排序" /></p>
  <p><input type="button" class="button" id="deleteAllClick" value="删除" url="<?php echo Yii::app()->createUrl('admin/article/deleteAll',array('column_id'=>$column_info['id']));?>" /></p>
</div>
<?php echo CHtml::endForm(); ?>
<div id="pages">
<div class="content">
<?php 
$this->widget('CLinkPager',array(
    'header'=>'<span class="count">'.$pages->itemCount.'条</span>',
    'prevPageLabel'=>'上一页',
    'nextPageLabel'=>'下一页',
	'pages'=>$pages,
	'maxButtonCount'=>12,
    'nextPageCssClass'=>'next_news',
    'internalPageCssClass'=>'page_news',
    'selectedPageCssClass'=>'selected_news',
    'hiddenPageCssClass'=>'hidden_news',
    'previousPageCssClass'=>'prev_news'
));
?>
</div>
</div>