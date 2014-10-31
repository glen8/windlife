    <div id="form_create">
      <?php echo $form->renderBegin(); ?>
      <?php foreach($form->getElements() as $k=>$element){ ?>
      <fieldset>
        <legend><?php echo $element->title?></legend>
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
      </fieldset>
      <?php } ?>
      <div class="btn m_top_10"><?php echo $form->renderButtons();?></div>
      <?php echo $form->renderEnd(); ?>
    </div>