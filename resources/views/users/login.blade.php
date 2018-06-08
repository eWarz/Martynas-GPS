<div class="users form">
<?php echo $this->Form->create('User',array('class'=>'form-horizontal')); ?>
    <fieldset>
        <legend><?php echo __('Įveskite Vartotojo Vardą Ir Slaptažodį'); ?></legend>
        <?php echo $this->Form->input('username',array('placeholder'=>'Vartotojo Vardas'));
        echo $this->Form->input('password',array('placeholder'=>'Slaptažodis'));
    ?>
    <div class="form-actions">
	<?php echo $this->Form->submit('Prisijungti',array( 'div'=>false,'class'=>'btn btn-info')); ?>
	</div>
    </fieldset>
<?php echo $this->Form->end(); ?>
</div>
<script>
$(document).ready(function(){
	$('#UserUsername').focus();
});
</script>