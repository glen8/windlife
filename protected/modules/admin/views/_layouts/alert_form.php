<div id="form_create">
  <?php echo $form->renderBegin(); ?>  
  <?php foreach($form->getElements() as $element){ ?>
  <div class="form_content">
    <table width="100%" class="table_form">
      <?php foreach($element->getElements() as $e) {?>
      <tr <?php if($e->type=='hidden') echo 'style="display:none"';?>>
        <th><?php echo $e->label ?>：</th>
        <td><?php echo $e->renderInput();?><span><?php echo $e->renderError();?></span><span><?php echo $e->renderHint();?></span></td>
      </tr>        
      <?php }?>
    </table>
  </div>
  <?php } ?>
  <div class="form_button" style="display: none"><?php echo $form->renderButtons();?></div>
  <?php echo $form->renderEnd(); ?>
</div>