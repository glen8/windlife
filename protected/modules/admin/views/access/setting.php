<?php $this->renderPartial('application.modules.admin.views._layouts.sub_nav');?>
<?php $this->widget('application.modules.admin.components.widgets.Tips',array('message'=>'请设置任务和操作的，业务规则和其他数据'));?>
<?php echo CHtml::beginForm(); ?>
<fieldset>
  <legend>任务和操作参数设置</legend>  
  <?php foreach ($tasks as $task){?>
  <div id="access_list">
    <div class="tasks">
      <p class="red width_130">任务：<?php echo $task->getDescription();?></p>
      <p>业务规则：<input type="text" name="access[<?php echo $task->getName(); ?>][bizrule]" value="<?php echo $task->getBizrule(); ?>" class="input-text" /></p>
      <p>其他参数：<input type="text" name="access[<?php echo $task->getName(); ?>][data]" value="<?php echo $task->getData(); ?>" class="input-text" /></p>
    </div>
    <?php if(count($task->getChildren())>0){?>
    <ul>
      <?php foreach ($task->getChildren() as $operation){?>
      <li>
        <p class="red width_130">操作：<?php echo $operation->getDescription();?></p>
        <p>业务规则：<input type="text" name="access[<?php echo $operation->getName(); ?>][bizrule]" value="<?php echo $operation->getData(); ?>" class="input-text" /></p>
        <p>其他参数：<input type="text" name="access[<?php echo $operation->getName(); ?>][data]" value="<?php echo $operation->getData(); ?>" class="input-text" /></p>
      </li>  
    <?php }}?>
    </ul>
  </div>
  <?php }?>
</fieldset>
<div class="btn"><input type="submit" class="button" name="dosubmit" value="设置参数" /></div>
<?php echo CHtml::endForm(); ?>