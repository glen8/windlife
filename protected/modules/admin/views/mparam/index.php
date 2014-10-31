<?php $this->renderPartial('application.modules.admin.views._layouts.sub_nav');?>
<div id="search">
  <p class="text">当前为 “<?php echo $model_data['name']?>” 可配参数相关操作</p>
  <div class="clear"></div>
</div>
<?php echo CHtml::beginForm(Yii::app()->createUrl('admin/mparam/listorder',array('model_id'=>$model_data['id']))); ?>
<table width="100%" class="table_list">
  <thead>
    <tr>
      <th width="80">排序</th>
      <th>参数名称</th>
      <th>参数引用key</th>
	  <th>参数类型</th>
	  <th>参数默认值</th>
	  <th>参数位置</th>
	  <th>对应模型字段</th>
	  <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($models as $v){?>
    <tr>
      <td align="center" height="20"><input name="listorders[<?php echo $v->id?>]" type="text" size="2" value="<?php echo $v->listorder?>" class="input-text-c input-text"></td>
      <td align="center"><?php echo $v->name;?></td>
      <td align="center"><?php echo $v->key;?></td>
      <td align="center"><?php echo $v->type=='text'?'文本域':'下拉菜单';?></td>
      <td align="center"><?php echo $v->default_value;?></td>
      <td align="center"><?php echo !empty($v->position)?'前台':'后台';?></td>
      <td align="center"><?php echo !empty($v->model_field)?$v->model_field:'无';?></td>
      <td align="center">
        <a href="<?php echo Yii::app()->createUrl('admin/mparam/update',array('model_id'=>$model_data['id'],'id'=>$v->id));?>">修改</a> |
        <?php echo CHtml::link('删除',array('/admin/mparam/delete',array('model_id'=>$model_data['id'],'id'=>$v->id)),array('submit'=>array('/admin/mparam/delete','model_id'=>$model_data['id'],'id'=>$v->id), 'confirm'=>'确定要删除 『 '.$v->name.' 』 吗？'))?>
      </td>
    </tr>
    <?php }?>
  </tbody>
</table>
<div class="btn"><input type="submit" class="button" name="dosubmit" value="排序" /></div>
<?php echo CHtml::endForm(); ?>