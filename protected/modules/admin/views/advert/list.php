<?php $this->renderPartial('application.modules.admin.views._layouts.sub_nav');?>
<div id="search">
  <p class="text">当前为版位 “<?php echo $position?>” 广告相关操作</p>
  <p class="button_p" style="float:right;"><?php echo CHtml::Button('添加广告',array('class'=>'button','onclick'=>'location.href="'.Yii::app()->createUrl('admin/advert/add',array('ad_id'=>$ad_id)).'"')); ?></p>
  <div class="clear"></div>
</div>
<?php echo CHtml::beginForm(Yii::app()->createUrl('admin/advert/listorder',array('ad_id'=>$ad_id))); ?>
<table width="100%" class="table_list">
  <thead>
    <tr>
      <th width="80">排序</th>
      <th width="100">编号</th>
      <th align="left">广告标题</th>
      <th>所属版位</th>
      <th>点击数</th>
      <th>添加时间</th>
	  <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($models as $v){?>
    <tr>
      <td align="center"><input name="listorders[<?php echo $v->id?>]" type="text" size="2" value="<?php echo $v->listorder?>" class="input-text-c input-text"></td>
      <td align="center"><?php echo $v->id;?></td>
      <td align="left"><?php echo $v->title;?></td>
      <td align="center"><?php echo isset($position_cache[1][$v->advert['position_key']])?$position_cache[1][$v->advert['position_key']]:$v->advert['position_key'];?></td>
      <td align="center"><?php echo $v->hits;?></td>
      <td align="center"><?php echo $v->created;?></td>
      <td align="center">
        <a href="<?php echo Yii::app()->createUrl('admin/advert/edit',array('ad_id'=>$ad_id,'id'=>$v->id));?>">修改</a> |
        <?php echo CHtml::link('删除',array('/admin/advert/del',array('ad_id'=>$ad_id,'id'=>$v->id)),array('submit'=>array('/admin/advert/del','ad_id'=>$ad_id,'id'=>$v->id), 'confirm'=>'确定要删除 『 '.$v->title.' 』 吗？'))?>
      </td>
    </tr>
    <?php }?>
  </tbody>
</table>
<div class="btn"><input type="submit" class="button" name="dosubmit" value="排序" /></div>
<?php echo CHtml::endForm(); ?>