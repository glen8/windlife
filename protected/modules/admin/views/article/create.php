<div id="content_create">
  <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'article_form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions' => array(
		'validateOnSubmit'=>true,
		'afterValidateAttribute'=>'js:afterValidate',
	),
  )); ?>
  <div class="content">
    <div class="breadcrumbs">当前位置：<?php echo $this->breadcrumbs;?></div>
    <div class="left">
      <div class="left_content">
        <table width="100%" class="table_form" align="center">
          <tr>
            <th width="90" height="20"><span class="red">*</span> 栏目</th>
            <td><?php echo $column_info['colname']?></td>
          </tr>
          <tr>
            <th><span class="red">*</span> 标题</th>
            <td>
              <?php 
              $this->widget('application.extensions.wl_inputTitle.WLInputTitle',array(
              		'model'=>$model,
              		'attribute'=>'title',
                    'styleAttribute'=>'style',
                    'maxLength'=>ParamGet::get($column_info['id'], 0, 'b_title_length'),
                    'imgCss'=>'cursor: pointer;float:left;margin-top:3px;',
                    'htmlOptions'=>array('class'=>'input-text measure-input','style'=>'width: 380px;'),
               ));
              ?>
              <span><?php echo $form->error($model,'title'); ?></span>
              <span><div class="hint">标题最长 <?php echo ParamGet::get($column_info['id'], 0, 'b_title_length')?> 字符</div></span>
            </td>
          </tr>
          <tr>
            <th>关键词</th>
            <td>
              <?php echo $form->textField($model,'keywords',array('class'=>'input-text','style'=>'width: 280px;')); ?>
              <span><?php echo $form->error($model,'keywords'); ?></span>
              <span><div class="hint">多关键词之间用“,”隔开</div></span>
            </td>
          </tr>
          <tr>
            <th>来源</th>
            <td>
              <?php 
              $this->widget('application.modules.admin.components.widgets.CopyFrom',array(
              		'model'=>$model,
              		'attribute'=>'copyfrom',
                    'selectData'=>$copy_from_cache,
                    'htmlOptions'=>array('class'=>'input-text','style'=>'width: 180px;'),
               ));
              ?>
              <span><?php echo $form->error($model,'copyfrom'); ?></span>
            </td>
          </tr>
          <tr>
            <th>摘要</th>
            <td>
              <?php echo $form->textarea($model,'description',array('class'=>'input-text','style'=>'width: 99%;height: 46px;')); ?>
            </td>
          </tr>
          <tr>
            <th><span class="red">*</span> 内容</th>
            <td>
              <span><?php echo $form->error($model,'content'); ?></span>
              <div class="clear"></div>
              <?php $this->widget('application.extensions.wl_fileContent.WLEditor',array(
              'model'=>$model,
          	  'attribute'=>'content',
              'width'=>"99.9%",
              'height'=>'200'
              ));?>
            </td>
          </tr>
          <tr>
            <th> 发布版位</th>
            <td>
              <?php $this->widget('application.modules.admin.components.widgets.ReleaseCon',array(
              'model'=>$model,
              'attribute'=>'release_content',
              'model_id'=>$column_info['modelid'],
          	  'htmlOptions'=>array('class'=>'input-checkbox'),
              ));?>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <div class="right">
      <div class="right_content">
        <h3 class="right_title">缩略图</h3>
        <p class="right_tip">缩略图大小为：<?php echo ParamGet::get($column_info['id'], 0, 'b_image_size')?></p>
        <div class="thumb">
          <div class="thumb_input">
          <?php $this->widget('application.extensions.wl_fileContent.WLImageUpload',array(
              'type'=>'image',
              'model'=>$model,
          	  'attribute'=>'thumb'
          ));?>
          </div>
          <p class="thumb_button">
            <input type="button" class="button" value="裁剪图片" />
            <input type="button" onClick="escImage('<?php echo CHtml::activeId($model, 'thumb');?>')" class="button" value="取消图片" />
          </p>
        </div>
        <h3 class="right_title padding_top_6"><?php echo empty($model->id)?'发布时间':'修改时间';?></h3>
        <div class="create_time">  
        <?php $this->widget('application.extensions.wl_timepicker.timepicker', array(  
            'model'=>$model,
            'attribute'=>empty($model->id)?'inputtime':'updatetime',
        	'language'=>'cn',
            'options' => array(  
                'dateFormat'=>'yy-mm-dd',
            ),  
            'htmlOptions'=>array('class'=>'input-text inputtime_img','style'=>'width: 180px;','readonly'=>'readonly')  
        ));?>    
        </div>
        <h3 class="right_title padding_top_6">转向链接</h3>
        <div class="link">
          <p class="link_url"><?php echo $form->textField($model,'url',array('class'=>'input-text','style'=>'width: 180px;')); ?></p>
          <p class="is_link"><?php echo $form->checkbox($model,'islink',array('style'=>'float:left;margin-top:2px')); ?>&nbsp;&nbsp;<span class="red">开启转向链接</span></p>
        </div>
        <h3 class="right_title padding_top_6">状态</h3>
        <div class="status"><?php echo $form->checkbox($model,'status'); ?></div>
      </div>
    </div>
    <div class="close"></div>
  </div>
  <div class="button_content">
    <div class="button_content_create"><?php echo CHtml::submitButton('保存后自动关闭',array('name'=>'close_button')); ?></div>
    <div class="button_content_create"><?php echo CHtml::submitButton('保存后继续发布',array('name'=>'open_button')); ?></div>
    <div class="button_content_create"><input type="button" value="关闭" onClick="window.close()" /></div>
  </div>
  <?php $this->endWidget(); ?>
</div>