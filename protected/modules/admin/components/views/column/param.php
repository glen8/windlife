<div id="form_create">
  <?php echo CHtml::beginForm(); ?>
  <div class="form_content">    
    <table class="table_form" width="100%">
      <?php foreach ($models as $v){?>
      <tr>
        <th align="right"><?php echo $v['name']?>：</th>
        <?php $value=isset($params[$v->position][$v->key])?$params[$v->position][$v->key]:$v->default_value;?>
        <?php $field_str=$v['type']=='text'?CHtml::textField('param['.$v['id'].']',$value,array('class'=>'input-text')):CHtml::dropDownList('param['.$v['id'].']', $value, unserialize(($v['value_items'])),array('class'=>'input-input')); ?>
        <td><?php echo $field_str;?></td>
      </tr>
      <?php }?>
    </table>    
  </div>
  <div class="form_button" style="display: none"><?php echo CHtml::button(null,array('id'=>'dosubmit','type'=>'submit'))?></div>
  <?php echo CHtml::endForm(); ?>
</div>