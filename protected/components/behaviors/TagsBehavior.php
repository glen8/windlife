<?php

class TagsBehavior extends CActiveRecordBehavior
{
    
    public $modelName;
    
    public function afterSave($event){
        if(!$this->owner->isNewRecord){
            Tags::model()->updateCounters(array('num'=>-1),'id in(SELECT tags_id FROM {{tags_item}} WHERE content_id=:id)',array('id'=>$this->owner->id));
            TagsItem::model()->deleteAllByAttributes(array('content_id'=>$this->owner->id,'model_name'=>$this->modelName));
        }
        if(!empty($this->owner->tags_list)){
            $tags_array=explode(',', $this->owner->tags_list);
            $tags_array=array_filter($tags_array);
            $tags_item_insert=array();
            foreach ($tags_array as $k=>$v){
                $tags_item_insert[$k]['tags_id']=$v;
                $tags_item_insert[$k]['model_name']=$this->modelName;
                $tags_item_insert[$k]['content_id']=$this->owner->id;                
            }
            Tags::model()->updateCounters(array('num'=>1),'id in('.$this->owner->tags_list.')');
            if(!empty($tags_item_insert)){
                $builder=Yii::app()->db->schema->commandBuilder;
                $command=$builder->createMultipleInsertCommand('{{tags_item}}', $tags_item_insert);
                $command->execute();
            }
        }
        return parent::afterSave($event);
    }
    
    public function afterDelete($event){
        Tags::model()->updateCounters(array('num'=>-1),'id in(SELECT tags_id FROM {{tags_item}} WHERE content_id=:id)',array('id'=>$this->owner->id));
        TagsItem::model()->deleteAllByAttributes(array('content_id'=>$this->owner->id,'model_name'=>$this->modelName));
        return parent::afterDelete($event);
    }
}

?>