<div id="form_create">
  <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'changepass_form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions' => array(
		'validateOnSubmit'=>true,
		'afterValidateAttribute'=>'js:afterValidate',
	),
  )); ?>
  <div class="form_content">
    <table width="100%" class="table_form">
      <tbody>
        <tr>
          <td width="80" height="24">用户名</td>
          <td><?php echo $model->username;?> (真实姓名<?php echo ' '.$model->name?>)</td>
        </tr>
        <tr>
          <td height="24">创建时间</td>
          <td><?php echo $model->created;?></td>
        </tr>
        <tr>
          <td height="24">E-mail</td>
          <td><?php echo $model->email;?></td>
        </tr>
        <tr>
          <td height="24">旧密码</td>
          <td><?php echo $form->passwordField($model,'old_password',array('class'=>'input-text')); ?><span><?php echo $form->error($model,'old_password'); ?></span><span><div class="hint">不修改密码请留空。</div></span></td>
        </tr>
        <tr>
          <td height="24">新密码</td>
          <td><?php echo $form->passwordField($model,'password',array('class'=>'input-text')); ?><span><?php echo $form->error($model,'password'); ?></span><span><div class="hint">不修改密码请留空。</div></span></td>
        </tr>
        <tr>
          <td height="24">重复新密码</td>
          <td><?php echo $form->passwordField($model,'r_password',array('class'=>'input-text')); ?><span><?php echo $form->error($model,'r_password'); ?></span><span><div class="hint">不修改密码请留空。</div></td>
        </tr>
      </tbody>
    </table>    
  </div>
  <div class="btn m_top_20"><?php echo CHtml::submitButton('提交',array('class'=>'button'))?></div>
  <?php $this->endWidget(); ?>
</div>