    <div id="form_create">
      <?php echo $form->renderBegin(); ?>
      <input type="hidden" name="form_type" id="form_type" value="<?php echo $form_type;?>" />
      <ul class="form_menu m_top_10">
        <?php $element_num=count($form->getElements())?>
        <?php $n=1;?>
        <?php foreach($form->getElements() as $k=>$element){ ?>
        <li id="form_menu_<?php echo $n?>" onclick="formTypeTab('form_menu','<?php echo $element_num?>','<?php echo $n?>')" class="<?php echo ((isset($form_type)&&$k==$form_type)?'form_menu_on':'form_menu_off')?>" rel="<?php echo $k?>"><?php echo $element->title?></li>
        <?php $n++;?>
        <?php } ?>
      </ul>
      <?php $m=1;?>
      <?php foreach($form->getElements() as $k=>$element){ ?>
      <div class="form_content" id="form_menu_content_<?php echo $m;?>" <?php echo ((isset($form_type)&&$k==$form_type)?'':'style="display:none"');?>>
        <table width="100%" class="table_form">
        <tbody>
        <?php foreach($element->getElements() as $e) {?>
        <tr <?php if($e->type=='hidden') echo 'style="display:none"';?>>
          <th width="200"><?php echo $e->label ?>：</th>
          <td><?php echo $e->renderInput();?><span><?php echo $e->renderError();?></span><span><?php echo $e->renderHint();?></span></td>
        </tr>        
        <?php }?>
        </tbody>
        </table>
      </div>
      <?php $m++?>
      <?php } ?>
      <div class="btn m_top_10"><?php echo $form->renderButtons();?></div>
      <?php echo $form->renderEnd(); ?>
    </div>