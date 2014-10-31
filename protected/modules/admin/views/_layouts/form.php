    <div id="form_create">
      <?php echo $form->renderBegin(); ?>
      <?php $m=1;?>
      <?php foreach($form->getElements() as $element){ ?>
      <div class="form_content m_top_10" id="form_menu_1_content_<?php echo $m;?>" <?php echo ($m!=1?'style="display:none"':'');?>>
        <table width="100%" class="table_form">
        <tbody>
        <?php foreach($element->getElements() as $e) {?>
        <tr <?php if($e->type=='hidden') echo 'style="display:none"';?>>
          <th width="<?php echo isset($label_width)?$label_width:'200';?>"><?php echo $e->label ?>：</th>
          <td><?php echo $e->renderInput();?><span><?php echo $e->renderError();?></span><span><?php echo $e->renderHint();?></span></td>
        </tr>        
        <?php }?>
        </tbody>
        </table>
      </div>
      <?php $m++?>
      <?php } ?>
      <div class="btn m_top_20"><?php echo $form->renderButtons();?></div>
      <?php echo $form->renderEnd(); ?>
    </div>