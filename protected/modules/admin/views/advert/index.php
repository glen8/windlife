<?php $this->renderPartial('application.modules.admin.views._layouts.sub_nav');?>
<?php echo CHtml::beginForm(); ?>
<table width="100%" class="table_list">
  <thead>
    <tr>
      <th width="80"><input type="checkbox" name="ids[]" class="selectAll" id="checkboxClick" value="0" /></th>
      <th>版位名称</th>
      <th>版位模板</th>
	  <th>版位尺寸</th>
	  <th>广告数</th>
	  <th>版位描述</th>
	  <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($models as $v) {?>
    <tr>
      <td align="center" height="20"><input type="checkbox" name="ids[]" class="selectAll" value="<?php echo $v->id?>" /></td>
      <td align="center"><?php echo isset($position_cache['1'][$v->position_key])?$position_cache['1'][$v->position_key]:$v->position_key;?></td>
      <td align="center"><?php echo isset($ad_array[$v->ad_key])?$ad_array[$v->ad_key]['title']:$v->ad_key;?></td>
      <td align="center" width="80"><?php echo $v->width.'*'.$v->height;?></td>
      <td align="center" width="120"><?php echo $v->num;?></td>
      <td align="center" width="120"><?php echo $v->description;?></td>
      <td align="center">
      <?php
      $this->widget('application.extensions.wl_artDialog.WLArtDialog',array(
            'title'=>'调用代码',
            'content'=>'调用代码',
            'url'=>Yii::app()->createUrl('admin/advert/code',array('id'=>$v->id)),
            'width'=>'400px',
            'height'=>'100px',
            'is_form'=>'0',
	    ));
        ?> |
        <a href="<?php echo Yii::app()->createUrl('admin/advert/list',array('ad_id'=>$v->id)); ?>">广告列表</a> |
        <a href="<?php echo Yii::app()->createUrl('admin/advert/add',array('ad_id'=>$v->id)); ?>">添加广告</a> |
        <?php 
        $this->widget('application.extensions.wl_artDialog.WLartDialog',array(
        		'title'=>'修改 - 版位“'.isset($position_cache['1'])&&isset($position_cache['1'][$v->position_key])?$position_cache['1'][$v->position_key]:$v->position_key.'”',
        		'content'=>'修改',
        		'url'=>Yii::app()->createUrl('admin/advert/update',array('id'=>$v->id)),
        		'width'=>'600px',
        		'height'=>'300px',
        		'cssClass'=>'add',
        ));
        ?> |
        <?php echo CHtml::link('删除',array('/admin/advert/delete',array('id'=>$v->id)),array('submit'=>array('/admin/advert/delete','id'=>$v->id), 'confirm'=>'确定要删除 『 '.(isset($position_cache['1'])&&isset($position_cache['1'][$v->position_key])?$position_cache['1'][$v->position_key]:$v->position_key).' 』 吗？'))?>
      </td>                              
    </tr>
    <?php }?>
  </tbody>
</table>
<div class="btn">
  <p><a id="selectAllClick" class="cursor">全选</a>/<a id="selectEscClick" class="cursor">取消</a></p>
  <p><input type="button" class="button" id="deleteAllClick" value="删除选中" url="<?php echo Yii::app()->createUrl('admin/advert/deleteAll');?>" /></p>
</div>
<?php echo CHtml::endForm(); ?>