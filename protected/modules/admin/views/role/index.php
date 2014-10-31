<?php $this->renderPartial('application.modules.admin.views._layouts.sub_nav');?>
<?php echo CHtml::beginForm(); ?>
<table width="100%" class="table_list">
  <thead>
    <tr>
      <th>角色名称</th>
      <th>角色描述</th>
      <th>业务规则</th>
      <th>其他参数</th>
	  <th>管理操作</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($models as $v){?>
    <tr>
      <td align="center" height="20"><?php echo $v->name;?></td>
      <td align="center"><?php echo $v->description;?></td>
      <td align="center"><?php echo $v->bizrule;?></td>
      <td align="center"><?php echo $v->data=='is_super=1'?'':$v->data;?></td>
      <td align="center">
        <?php $data=Util::param2array($v->data);?>
        <?php if(isset($data['is_super'])){?>        
        <span style="color:#ccc">权限设置</span> |
        <span style="color:#ccc">修改</span> |
        <span style="color:#ccc">删除</span>
        <?php }else{?>
        <a href="<?php echo Yii::app()->createUrl('admin/role/setaccess',array('id'=>$v->name));?>">权限设置</a> |
        <?php 
        $this->widget('application.extensions.wl_artDialog.WLArtDialog',array(
        		'title'=>'修改 - 角色“'.$v->name.'”',
        		'content'=>'修改',
        		'url'=>Yii::app()->createUrl('admin/role/update',array('id'=>$v->name)),
        		'width'=>'560px',
        		'height'=>'220px',
        		'cssClass'=>'add',
        ));
        ?> |
        <?php echo CHtml::link('删除',array('/admin/role/delete',array('id'=>$v->name)),array('submit'=>array('/admin/role/delete','id'=>$v->name), 'confirm'=>'确定要删除 『 '.$v->name.' 』 吗？'))?>
        <?php }?>
      </td>
    </tr>
    <?php }?>
  </tbody>
</table>
<?php echo CHtml::endForm(); ?>