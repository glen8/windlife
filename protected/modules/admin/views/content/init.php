<style>
#treecontrol{
	margin:0 0 0 3px;
}
#treecontrol img{
	vertical-align:middle;
}
.treeview span.list {
	padding: 1px 0 1px 16px;
	background: url(<?php Yii::app()->baseUrl?>/images/admin/tree_list.jpg) left center no-repeat;
}
.treeview span.parent {
	padding: 1px 0 1px 16px;
	background: url(<?php Yii::app()->baseUrl?>/images/admin/tree_parent.jpg) left center no-repeat;
}
</style>
<div id="treecontrol">
  <span style="display:none"><a href="#"></a><a href="#"></a></span>
  <a href="#">
    <img src="<?php Yii::app()->baseUrl?>/images/admin/minus.gif" />
    <img src="<?php Yii::app()->baseUrl?>/images/admin/application_side_expand.png" /> 展开/收缩                 
  </a>
</div>
<?php 
$this->widget('CTreeView',array(
    'id'=>'column_treeview',
    'data'=>$column_data,
	'control'=>'#treecontrol',
	'htmlOptions'=>array(
	    'class'=>'filetree',
    ),
));
?>
