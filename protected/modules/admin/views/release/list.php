<?php $this->renderPartial('application.modules.admin.views._layouts.sub_nav');?>
<div id="search">
  <p class="text">当前为 “<?php echo $release_info['title']?>” 内容版位所有内容</p>
  <div class="clear"></div>
</div>
<?php echo CHtml::beginForm(Yii::app()->createUrl('admin/release/listorder',array('release_id'=>$release_info['id']))); ?>
<table width="100%" class="table_list">
  <thead>
    <tr>
      <th width="80">排序</th>
      <th>所属栏目</th>
      <th>所属模型</th>
	  <th>标题</th>
	  <th>状态</th>
	  <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($models as $v){?>
    <tr>
      <td align="center" height="20"><input name="listorders[<?php echo $v->id?>]" type="text" size="2" value="<?php echo $v->listorder?>" class="input-text-c input-text"></td>
      <td align="center"><?php echo isset($column_data[$v->column_id])?$column_data[$v->column_id]['colname']:$v->column_id;?></td>
      <td align="center"><?php echo isset($model_data[$v->model_id])?$model_data[$v->model_id]['name']:$v->model_id;?></td>
      <td align="center"><?php echo $v->title?><?php if(!empty($v->thumb)){?><img alt="缩略图" src="<?php echo Yii::app()->baseUrl.'images/admin/small_img.gif'?>" /><?php }?></td>
      <td align="center"><?php echo !empty($v->status)?'发布':'为发布';?></td>
      <td align="center">
        <?php echo CHtml::link('删除',array('/admin/release/cdelete',array('release_id'=>$release_info['id'],'id'=>$v->id)),array('submit'=>array('/admin/release/cdelete','release_id'=>$release_info['id'],'id'=>$v->id), 'confirm'=>'确定要删除 『 '.$v->title.' 』 吗？'))?>
      </td>
    </tr>
    <?php }?>
  </tbody>
</table>
<div class="btn"><input type="submit" class="button" name="dosubmit" value="排序" /></div>
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