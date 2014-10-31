<?php $this->renderPartial('application.modules.admin.views._layouts.sub_nav');?>
<table width="100%" class="table_list">
  <thead>
    <tr>
      <th width="80">编号</th>
      <th>模型名称</th>
      <th>模型访问模块</th>
	  <th>模型访问控制器</th>
	  <th>模型访问方法</th>
	  <th>模型访问参数</th>
	  <th>模型对象</th>
	  <th>模型数据量</th>
	  <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($model_list as $v){?>
    <tr>
      <td align="center" height="20"><?php echo $v->id;?></td>
      <td align="center"><?php echo $v->name;?></td>
      <td align="center"><?php echo !empty($v->module)?$v->module:'无';?></td>
      <td align="center"><?php echo $v->controller;?></td>
      <td align="center"><?php echo $v->action;?></td>
      <td align="center"><?php echo !empty($v->data)?$v->data:'无';?></td>
      <td align="center"><?php echo $v->object;?></td>
      <td align="center"><?php echo $v->items;?></td>
      <td align="center">
        <a href="<?php echo Yii::app()->createUrl('admin/mparam/index',array('model_id'=>$v->id));?>">可配参数管理</a> |
        <a href="<?php echo Yii::app()->createUrl('admin/model/update',array('id'=>$v->id));?>">修改</a> |
        <?php echo CHtml::link('删除',array('/admin/model/delete',array('id'=>$v->id)),array('submit'=>array('/admin/model/delete','id'=>$v->id), 'confirm'=>'确定要删除 『 '.$v->name.' 』 吗？'))?>
      </td>
    </tr>
    <?php }?>
  </tbody>
</table>