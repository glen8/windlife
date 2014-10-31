<?php $this->renderPartial('application.modules.admin.views._layouts.sub_nav');?>
<?php $this->widget('application.modules.admin.components.widgets.Tips',array('message'=>'请选择角色的任务和操作'));?>
<?php echo CHtml::beginForm(); ?>
<fieldset>
  <legend>绑定“<?php echo $role->getDescription();?>”的任务和操作</legend>  
  <?php foreach ($tasks as $task){?>
  <div id="role_access">
    <div class="tasks"> 
      <input type="checkbox" name="role_access[]" class="input-checkbox" value="<?php echo $task->getName();?>" <?php if(isset($role_childs[$task->getName()])){?>checked="checked"<?php }?> />   
      <span>&nbsp;&nbsp;&nbsp;任务：<?php echo $task->getDescription();?></span>
      <div class="clear"></div>
    </div>
    <?php if(count($task->getChildren())>0){?>
    <ul>
      <?php foreach ($task->getChildren() as $operation){?>
      <li>
        <input type="checkbox" name="role_access[]"  class="input-checkbox" value="<?php echo $operation->getName();?>" <?php if(isset($role_childs[$operation->getName()])){?>checked="checked"<?php }?> />
        <span>&nbsp;&nbsp;&nbsp;操作：<?php echo $operation->getDescription();?></span>
      </li>  
      <?php }?>
    </ul>
    <?php }?>
    <div class="clear"></div>
  </div>
  <?php }?>
</fieldset>
<div class="btn"><input type="submit" class="button" name="dosubmit" value="绑定" /></div>
<?php echo CHtml::endForm(); ?>
<script type="text/javascript">
<!--
$(document).ready(function(){
	$("input[type='checkbox']").click(function(){
		if($(this).parent().prop('tagName')=='DIV'&&!$(this).attr('checked')){
			$('input',$(this).parent().next()).attr('checked',false);
		}
		if($(this).parent().prop('tagName')=='LI'&&$(this).attr('checked')){
			$('input',$(this).parent().parent().prev()).attr('checked','checked');
		}
	});
});
//-->
</script>