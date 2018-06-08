<div id="info-container" style="overflow:hidden;">
<?php echo $this->Form->create('Location',array('action'=>'ajax_add')); ?>
<?php echo $this->Form->input('latitude',array('type'=>'hidden','id'=>'latitude')); ?>
<?php echo $this->Form->input('longitude',array('type'=>'hidden','id'=>'longitude')); ?>
<?php echo $this->Form->input('name'); ?>
<?php echo $this->Form->input('location_category_id',array('options'=>$listLocationCategory)); ?>
<?php echo $this->Form->submit('Add',array('class'=>'btn btn-warning add-button')); ?>
<?php echo $this->Form->end();?>
</div>