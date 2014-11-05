<?php

class Tag extends CInputWidget
{
    
    // input 选项
    public $htmlOptions = array ();
    
    // button 选项
    public $buttonOptions = array ();
    
    public function run(){
        $this->htmlOptions ['id'] = 'wl_tags_create_input';
        $this->buttonOptions ['id'] = 'wl_tags_create_button';
        $this->buttonOptions ['data-url'] = Yii::app()->createUrl('admin/tags/create');
        $html='<div class="input">';
        $html.=CHtml::textField('wl_tags_create_input',null,$this->htmlOptions);
        $html.=CHtml::button('添加',$this->buttonOptions);
        $html.='</div>';
        $html.='<div class="clear"></div>';
        $html.='<p>多个标签请用英文逗号（,）分开</p>';
        $html.='<ul id="tags_selected_list">';
        if(!empty($this->model->id)){
            $tags_itmes=TagsItem::model()->with('tags')->findAllByAttributes(array('model_name'=>get_class($this->model),'content_id'=>$this->model->id));
            $tags_id_array=array();
            foreach ($tags_itmes as $v){
                $html.='<li data="'.$v->tags_id.'"><span>'.$v->tags['title'].'</span></li>';
                $tags_id_array[]=$v->tags_id;
            }
            $this->model->tags_list=implode(',', $tags_id_array);
        }
        $html.='</ul>';
        $html.='<div class="clear"></div>';
        $html.=CHtml::activeHiddenField($this->model, $this->attribute);
        $html.="<a rel=\"tags_select_a\" class=\"tags_select_a\">从常用标签中选择</a>";
        $html.="<ul id=\"tags_used_list\">";
        $tags_list=Tags::model()->order('listorder ASC,id ASC')->findAll();
        foreach($tags_list as $v){
            $html.='<li data="'.$v->id.'" style="font-size: '.Util::getCloud($tags_list,$v->num).'px;"><a title="'.$v->num.'个内容">'.$v->title.'</a></li>';
        }
	    $html.='<div class="clear"></div>';
        $html.='</ul>';
	    $html.='<div class="clear"></div>';
        echo $html;
    }
}

?>