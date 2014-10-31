<?php $this->renderPartial('application.modules.admin.views._layouts.sub_nav');?>
<?php $this->widget('application.modules.admin.components.widgets.Tips',array('message'=>'请在添加、修改、删除规则后，更新缓存'));?>
<?php echo CHtml::beginForm(Yii::app()->createUrl('admin/urlmanage/listorder')); ?>
<table width="100%" class="table_list">
  <thead>
    <tr>
      <th>排序</th>
      <th>规则名称</th>
      <th>所属模块</th>
      <th>规则</th>
      <th>规则对应地址</th>
      <th>分页规则</th>
	  <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($urlrules as $v){?>
    <tr>
      <td align="center"><input name="listorders[<?php echo $v->id?>]" type="text" size="2" value="<?php echo $v->listorder?>" class="input-text-c input-text"></td>
      <td align="center"><?php echo $v->name;?></td>
      <td align="center"><?php echo $v->module;?></td>
      <td align="center"><?php echo empty($v->rule)?'空地址':htmlspecialchars($v->rule);?></td>
      <td align="center"><?php echo $v->rule_url;?></td>
      <td align="center"><?php echo empty($v->page_rule)?'无':htmlspecialchars($v->page_rule);?></td>
      <td align="center">
        <a href="<?php echo Yii::app()->createUrl('admin/urlmanage/update',array('id'=>$v->id));?>">修改</a> | 
        <?php echo CHtml::link('删除',array('/admin/urlmanage/delete',array('id'=>$v->id)),array('submit'=>array('/admin/urlmanage/delete','id'=>$v->id), 'confirm'=>'确定要删除 『 '.$v->name.' 』 吗？'))?>
      </td>
    </tr>
    <?php }?>
  </tbody>
</table>
<div class="btn"><input type="submit" class="button" name="dosubmit" value="排序" /></div>
<?php echo CHtml::endForm(); ?>