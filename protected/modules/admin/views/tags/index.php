<?php $this->renderPartial('application.modules.admin.views._layouts.sub_nav');?>
<?php echo CHtml::beginForm(Yii::app()->createUrl('admin/tags/listorder')); ?>
<table width="100%" class="table_list">
	<thead>
	<tr>
		<th width="80">排序</th>
		<th width="100">标题名称</th>
		<th>内容数量</th>
		<th>点击次数</th>
		<th>创建时间</th>
		<th>操作</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($models as $v){?>
		<tr>
			<td align="center"><input name="listorders[<?php echo $v->id?>]" type="text" size="2" value="<?php echo $v->listorder?>" class="input-text-c input-text"></td>
			<td align="center"><?php echo $v->title;?></td>
			<td align="center"><?php echo $v->num;?></td>
			<td align="center"><?php echo $v->hits;?></td>
			<td align="center"><?php echo $v->created;?></td>
			<td align="center">
				<?php echo CHtml::link('删除',array('/admin/tags/delete',array('id'=>$v->id)),array('submit'=>array('/admin/tags/delete','id'=>$v->id), 'confirm'=>'确定要删除 『 '.$v->title.' 』 吗？'))?>
			</td>
		</tr>
	<?php }?>
	</tbody>
</table>
<div class="btn"><input type="submit" class="button" name="dosubmit" value="排序" /></div>
<?php echo CHtml::endForm(); ?>
