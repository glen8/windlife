<?php

class ColumnIndexAction extends CAction{
	
	public $module='content';
	
	
	public function run(){
		$tree=new Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$column_list=Column::model()->order('listorder ASC')->findAll();
		$column_array=array();
		foreach ($column_list as $k=>$v){
			$column_array[$v->id]['id']=$v->id;
			$column_array[$v->id]['parentid']=$v->parentid;
			$column_array[$v->id]['colname']=$v->colname;
			$column_array[$v->id]['name']=$v->colname;
			$column_array[$v->id]['listorder']=$v->listorder;
			$column_array[$v->id]['url']="<a href=\"{$v->url}\" target=\"_blank\">访问</a>";
			$column_array[$v->id]['type']=$v->type;
			$update_url='';
			$create_url='';
			switch ($v->type){
				case 1:
					$column_array[$v->id]['typename']='<span style="color:blue">内部栏目</span>';
					$create_url='admin/column/create';
					$update_url='admin/column/update';
					break;
				case 2:
					$column_array[$v->id]['typename']='<span style="color:green">自定栏目</span>';
					$create_url='admin/column/custom';
					$update_url='admin/column/customUpdate';
					break;
				case 3:
					$column_array[$v->id]['typename']='<span style="color:red">链接栏目</span>';
					$create_url='admin/column/link';
					$update_url='admin/column/linkUpdate';
					break;
				default:
					$column_array[$v->id]['typename']='<span style="color:blue">内部栏目</span>';
					$create_url='admin/column/create';
					$update_url='admin/column/update';
					break;					
			}
			Yii::app()->cacheManage->cacheName='ModelCache';
			$model_list=Yii::app()->cacheManage->findCache();	
			$column_array[$v->id]['model_id']=$v->modelid;
			$column_array[$v->id]['modelname']=$v->modelid>0?$model_list[$v->modelid]['name']:'';
			if($v->type==1){
				switch ($v->dataway){
					case 1:
						$column_array[$v->id]['dataway']='子栏目集合';
						$column_array[$v->id]['items']='';
						break;
					case 2:
						$column_array[$v->id]['dataway']='独立栏目';
						$column_array[$v->id]['items']=$v->items;
						break;
					case 3:
						$column_array[$v->id]['dataway']='子第一栏目';
						$column_array[$v->id]['items']='';
						break;
					default:
						$column_array[$v->id]['dataway']='子栏目集合';
						$column_array[$v->id]['items']='';
						break;
				}
			}
			else{
				$column_array[$v->id]['dataway']='';
				$column_array[$v->id]['items']='';
			}
			$column_array[$v->id]['display_icon'] = $v->display ? '' : ' <img src ="'.Yii::app()->baseUrl.'/images/admin/gear_disable.png" title="不在导航显示">';
			$delete_url=CHtml::link('删除',array('/admin/column/delete',array('id'=>$v->id)),array('submit'=>array('/admin/column/delete','id'=>$v->id), 'confirm'=>'确定要删除 『 '.$v->colname.' 』 吗？'));
			$column_array[$v->id]['str_manage'] = '<a href="'.Yii::app()->createUrl($create_url,array('parent_id'=>$v->id)).'">添加子栏目</a> | <a href="'.Yii::app()->createUrl($update_url,array('id'=>$v->id)).'">修改</a> | '.$delete_url;
		}
		$str  = "<tr>
					<td align='center'><input name='listorders[\$id]' type='text' size='3' value='\$listorder' class='input-text input-text-c'></td>
					<td align='center'>\$id</td>
					<td >\$spacer\$colname\$display_icon</td>
					<td align='center'>\$typename</td>
					<td align='center'>\$modelname</td>
				    <td align='center'>\$dataway</td>
					<td align='center'>\$items</td>
					<td align='center'>\$url</td>
					<td align='center' >\$str_manage</td>
				</tr>";
		$tree->init($column_array);
		
		$data['columns'] = $tree->get_tree_carray(0);
		$this->controller->render('application.modules.admin.components.views.column.index',$data);
	}
	
}

?>