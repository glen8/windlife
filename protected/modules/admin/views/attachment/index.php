<?php $this->renderPartial('application.modules.admin.views._layouts.sub_nav');?>
<div id="search">
  <?php $form=$this->beginWidget('CActiveForm', array(
  'action'=>Yii::app()->createUrl($this->route),
  'method'=>'get',
  )); ?>
  <p class="text"><?php echo $form->label($search_model,'filename'); ?>：</p>
  <p class="input"><?php echo $form->textField($search_model,'filename',array('class'=>'input-text')); ?></p>
  <p class="text"><?php echo $form->label($search_model,'uploadtime'); ?>：</p>
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
  <p class="text"><?php echo $form->label($search_model,'status'); ?>：</p>
  <p class="input"><?php echo $form->dropDownList($search_model,'status',array('0'=>'未用','1'=>'已用'),array('class'=>'select')); ?></p>
  <p class="button_p"><?php echo CHtml::submitButton('搜索',array('class'=>'button')); ?></p>
  <?php $this->endWidget(); ?>
  <div class="clear"></div>
</div>
<?php echo CHtml::beginForm(); ?>
<table width="100%" class="table_list">
  <thead>
    <tr>
      <th width="80"><input type="checkbox" name="ids[]" class="selectAll" id="checkboxClick" value="0" /></th>
      <th>编号</th>
      <th>文件名称</th>
	  <th>文件路径</th>
	  <th>文件大小</th>
	  <th>上传时间</th>
	  <th>是否已用</th>
	  <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($models as $v) {?>
    <tr>
      <td align="center" height="20"><input type="checkbox" name="ids[]" class="selectAll" value="<?php echo $v->id?>" /></td>
      <td align="center"><?php echo $v->id;?></td>
      <td align="center"><?php echo $v->filename;?></td>
      <td align="center"><?php echo $v->filepath;?></td>
      <td align="center" width="80"><?php echo Util::formatBytes($v->filesize);?></td>
      <td align="center" width="120"><?php echo date('Y-m-d h:i:s',$v->uploadtime);?></td>
      <td align="center" width="120"><?php echo $v->status==1?'已用':'未用';?></td>
      <td align="center" width="120">
        <?php if($v->fileext=='.jpg'||$v->fileext=='.jpeg'||$v->fileext=='.gif'||$v->fileext=='.bmp'||$v->fileext=='.png'){?>
        <?php echo CHtml::link('预览', '#', array('onclick'=>'$("#mydialog_'.$v->id.'").dialog("open"); return false;')); ?> |
        <?php }else{?>
        <span style="color:#ccc">预览</span> |
        <?php }?>
        <?php echo CHtml::link('删除',array('/admin/attachment/delete',array('id'=>$v->id)),array('submit'=>array('/admin/attachment/delete','id'=>$v->id), 'confirm'=>'确定要删除 『 '.$v->filename.' 』 吗？'))?>
      </td>      
      <td style="display: none">
        <?php 
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        	'id'=>'mydialog_'.$v->id,
        	'options'=>array(
        	    'title'=>'预览-“'.$v->filename.'”',
        		'autoOpen'=>false,
        		'width'=>'auto',
        		'height'=>'auto',
            ),
        ));
        echo "<img src=\"{$v->filepath}\" style=\"max-width: 300px;max-height:300px;\"";
        $this->endWidget('zii.widgets.jui.CJuiDialog');      
        ?>
      </td>                        
    </tr>
    <?php }?>
  </tbody>
</table>
<div class="btn">
  <p><a id="selectAllClick" class="cursor">全选</a>/<a id="selectEscClick" class="cursor">取消</a></p>
  <p><input type="button" class="button" id="deleteAllClick" value="删除选中" url="<?php echo Yii::app()->createUrl('admin/attachment/deleteAll');?>" /></p>
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