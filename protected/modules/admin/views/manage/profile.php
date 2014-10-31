<div id="form_create">
  <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'profile_form',
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
          <td><?php echo $model->username;?></td>
        </tr>
        <tr>
          <td height="24">创建时间</td>
          <td><?php echo $model->created;?></td>
        </tr>
        <tr>
          <td height="24">最后登录时间</td>
          <td><?php echo $model->last_login;?></td>
        </tr>
        <tr>
          <td height="24">最后登录IP</td>
          <td><?php echo $model->last_ip;?></td>
        </tr>
        <tr>
          <td height="24">真实姓名</td>
          <td><?php echo $form->textField($model,'name',array('class'=>'input-text')); ?><span><?php echo $form->error($model,'name'); ?></span><span><div class="hint">请输入真实姓名</div></span></td>
        </tr>
        <tr>
          <td height="24">E-mail</td>
          <td><?php echo $form->textField($model,'email',array('class'=>'input-text')); ?><span><?php echo $form->error($model,'email'); ?></span><span><div class="hint">请输入Email</div></td>
        </tr>
      </tbody>
    </table>    
  </div>
  <div class="btn m_top_20"><?php echo CHtml::submitButton('提交',array('class'=>'button'))?></div>
  <?php $this->endWidget(); ?>
</div>