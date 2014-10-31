<?php $this->renderPartial('application.modules.admin.views._layouts.sub_nav');?>
<?php echo CHtml::beginForm(); ?>
<table width="100%" class="table_list">
  <thead>
    <tr>
      <th width="80">编号</th>
      <th>位置描述</th>
      <th>栏目标题</th>
	  <th>最大数据</th>
	  <th>数据条数</th>
	  <th>所属模型</th>
	  <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($models as $v){?>
    <tr>
      <td align="center" height="20"><?php echo $v->id;?></td>
      <td align="center"><?php echo isset($position[$v->key_name])?$position[$v->key_name]:$v->key_name;?></td>
      <td align="center"><?php echo $v->title;?></td>
      <td align="center"><?php echo $v->max_num;?></td>
      <td align="center"><?php echo $v->num;?></td>
      <td align="center"><?php echo !empty($v->model_id)?$model[$v->model_id]['name']:'无模型';?></td>
      <td align="center">
        <a href="<?php echo Yii::app()->createUrl('admin/release/update',array('id'=>$v->id));?>">修改</a> |
        <?php echo CHtml::link('删除',array('/admin/release/delete',array('id'=>$v->id)),array('submit'=>array('/admin/release/delete','id'=>$v->id), 'confirm'=>'确定要删除 『 '.$v->title.' 』 吗？'))?> |
        <a href="<?php echo Yii::app()->createUrl('admin/release/list',array('release_id'=>$v->id));?>">查看内容</a>
      </td>
    </tr>
    <?php }?>
  </tbody>
</table>
<?php echo CHtml::endForm(); ?>
