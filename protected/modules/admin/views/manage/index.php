<?php $this->renderPartial('application.modules.admin.views._layouts.sub_nav');?>
<?php echo CHtml::beginForm(); ?>
<table width="100%" class="table_list">
  <thead>
    <tr>
      <th width="80">序号</th>
      <th width="100">用户名</th>
      <th>所属角色</th>
      <th>最后登录IP</th>
      <th>最后登录时间</th>
      <th>Email</th>
      <th>真实姓名</th>
	  <th>管理操作</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($models as $v){?>
    <tr>
      <td align="center" height="20"><?php echo $v->id?></td>
      <td align="center"><?php echo $v->username;?></td>
      <td align="center"><?php echo Yii::app()->user->getAdminRoleDescription($v->id)!=null?Yii::app()->user->getAdminRoleDescription($v->id):'最小权限管理员';?></td>
      <td align="center"><?php echo empty($v->last_ip)?'尚未登录':$v->last_ip; ?></td>
      <td align="center"><?php echo empty($v->last_login)?'尚未登录':$v->last_login; ?></td>
      <td align="center"><?php echo $v->email;?></td>
      <td align="center"><?php echo $v->name;?></td>
      <td align="center">
        <?php 
        $this->widget('application.extensions.wl_artDialog.WLArtDialog',array(
        		'title'=>'修改 - 管理员“'.$v->username.'”',
        		'content'=>'修改',
        		'url'=>Yii::app()->createUrl('admin/manage/update',array('id'=>$v->id)),
        		'width'=>'600px',
        		'height'=>'300px',
        		'cssClass'=>'add',
        ));
        ?> |
        <?php if($v->is_default==1){?>
        <span style="color:#ccc">删除</span>
        <?php }else{?>
        <?php echo CHtml::link('删除',array('/admin/manage/delete',array('id'=>$v->id)),array('submit'=>array('/admin/manage/delete','id'=>$v->id), 'confirm'=>'确定要删除 『 '.$v->username.' 』 吗？'))?>
        <?php }?>
      </td>
    </tr>
    <?php }?>
  </tbody>
</table>
<?php echo CHtml::endForm(); ?>