<?php $this->renderPartial('application.modules.admin.views._layouts.sub_nav');?>
<table width="100%" class="table_list">
  <thead>
    <tr>
      <th align="left">模板名称</th>
      <th>模板key</th>
      <th>描述</th>
	  <th>最大数量</th>
	  <th>类型</th>
	  <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($ad_array as $v) {?>
    <tr>
      <td align="left" height="20"><?php echo $v['title']?></td>
      <td align="center"><?php echo $v['key']?></td>
      <td align="center"><?php echo $v['description']?></td>
      <td align="center"><?php echo $v['max_num']?></td>
      <td align="center" width="80"><?php echo $v['type']?></td>
      <td align="center" width="120">
        <?php echo CHtml::link('预览', '#', array('onclick'=>'$("#mydialog_'.$v['key'].'").dialog("open"); return false;')); ?>
      </td> 
      <td style="display: none">
        <?php 
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        	'id'=>'mydialog_'.$v['key'],
        	'options'=>array(
        	    'title'=>'预览-“'.$v['title'].'”',
        		'autoOpen'=>false,
        		'width'=>'auto',
        		'height'=>'auto',
            ),
        ));
        $path=Yii::app()->baseUrl.'/protected/extensions/wl_advert/'.$v['key'].'/'.$v['preview'];
        echo "<img src=\"{$path}\" style=\"max-width: 300px;max-height:300px;\"";
        $this->endWidget('zii.widgets.jui.CJuiDialog');      
        ?>
      </td>                      
    </tr>
    <?php }?>
  </tbody>
</table>