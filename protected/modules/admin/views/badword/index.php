<?php $this->renderPartial('application.modules.admin.views._layouts.sub_nav');?>
<div id="search">
  <?php $form=$this->beginWidget('CActiveForm', array(
  'action'=>Yii::app()->createUrl($this->route),
  'method'=>'get',
  )); ?>
  <p class="text"><?php echo $form->label($search_model,'badword'); ?>：</p>
  <p class="input"><?php echo $form->textField($search_model,'badword',array('class'=>'input-text')); ?></p>
  <p class="text"><?php echo $form->label($search_model,'replaceword'); ?>：</p>
  <p class="input"><?php echo $form->textField($search_model,'replaceword',array('class'=>'input-text')); ?></p>
  <p class="button_p"><?php echo CHtml::submitButton('搜索',array('class'=>'button')); ?></p>
  <?php $this->endWidget(); ?>
  <div class="clear"></div>
</div>
<?php echo CHtml::beginForm(); ?>
<table width="100%" class="table_list">
  <thead>
    <tr>
      <th width="80"><input type="checkbox" name="ids[]" class="selectAll" id="checkboxClick" value="0" /></th>
      <th>敏感词</th>
      <th>替换词</th>
	  <th>敏感级别</th>
	  <th>创建时间</th>
	  <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($models as $v) {?>
    <tr>
      <td align="center" height="20"><input type="checkbox" name="ids[]" class="selectAll" value="<?php echo $v->id?>" /></td>
      <td align="center"><?php echo $v->badword;?></td>
      <td align="center"><?php echo $v->replaceword;?></td>
      <td align="center" width="80"><?php echo $v->level==1?'一般':'危险';?></td>
      <td align="center" width="120"><?php echo $v->lastusetime;?></td>
      <td align="center" width="120">
        <?php 
        $this->widget('application.extensions.wl_artDialog.WLartDialog',array(
        		'title'=>'修改 - 敏感词“'.$v->badword.'”',
        		'content'=>'修改',
        		'url'=>Yii::app()->createUrl('admin/badword/update',array('id'=>$v->id)),
        		'width'=>'500px',
        		'height'=>'200px',
        		'cssClass'=>'add',
        ));
        ?> |
        <?php echo CHtml::link('删除',array('/admin/badword/delete',array('id'=>$v->id)),array('submit'=>array('/admin/badword/delete','id'=>$v->id), 'confirm'=>'确定要删除 『 '.$v->badword.' 』 吗？'))?>
      </td>                              
    </tr>
    <?php }?>
  </tbody>
</table>
<div class="btn">
  <p><a id="selectAllClick" class="cursor">全选</a>/<a id="selectEscClick" class="cursor">取消</a></p>
  <p><input type="button" class="button" id="deleteAllClick" value="删除选中" url="<?php echo Yii::app()->createUrl('admin/badword/deleteAll');?>" /></p>
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
