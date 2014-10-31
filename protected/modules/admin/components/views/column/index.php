<?php $this->renderPartial('application.modules.admin.views._layouts.sub_nav');?>
<?php echo CHtml::beginForm(Yii::app()->createUrl('admin/column/listorder')); ?>
<table width="100%" class="table_list">
  <thead>
    <tr>
      <th width="80">排序</th>
      <th width="40">编号</th>
      <th>栏目名称</th>
      <th width="80" align="center">栏目类型</th>
      <th width="80" align="center">所属模型</th>
      <th width="84" align="center">数据调用</th>
      <th width="50" align="center">数据量</th>
      <th width="30">访问</th>
	  <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($columns as $column){?>
    <tr>
      <td align='center'><input name='listorders[<?php echo $column['id']?>]' type='text' size='3' value='<?php echo $column['listorder']?>' class='input-text input-text-c'></td>
      <td align='center'><?php echo $column['id'];?></td>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $column['colname'];?><?php echo $column['display_icon'];?></td>
      <td align='center'><?php echo $column['typename'];?></td>
	  <td align='center'><?php echo $column['modelname'];?></td>
	  <td align='center'><?php echo $column['dataway'];?></td>
	  <td align='center'><?php echo $column['items'];?></td>
	  <td align='center'><?php echo $column['url'];?></td>
	  <td align='center'>
	    <?php echo $column['str_manage'];?> |
	    <?php if($column['type']=='1'){?>
	    <?php $this->widget('application.extensions.wl_artDialog.WLArtDialog',array(
            'title'=>"栏目 “{$column['name']}” 参数设置",
            'content'=>'<em>参数设置</em>',
            'url'=>Yii::app()->createUrl('admin/column/param',array('column_id'=>$column['id'],'model_id'=>$column['model_id'])),
            'width'=>'400px',
            'height'=>'300px',
            'cssClass'=>'add',
	    ));
        ?>
	    <?php }else{?>
	    <span style="color:#ccc">参数设置</span>
	    <?php }?>
	  </td>
    </tr>
    <?php }?>
  </tbody>
</table>
<div class="btn"><input type="submit" class="button" name="dosubmit" value="排序" /></div>
<?php echo CHtml::endForm(); ?>