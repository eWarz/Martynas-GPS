
	
	<div class="pagination pagination-right pagination-mini">
	  <ul>
		<?php echo $this->Paginator->prev(''); ?>
		<?php echo $this->Paginator->numbers(array('first' => 2, 'last' => 2));?>
		<?php echo $this->Paginator->next(''); ?>
	  </ul>
	</div>
	<table class="table table-bordered table-hover table-striped table-striped-success">
		<thead>
		<?php
			echo $this->Html->tableHeaders(array(
					array(''=>array('class'=>'warning')),
					array($this->paginator->sort('Location.name','Device ID') =>array('class'=>'info')),
					array($this->paginator->sort('LocationCategory.name','Selectas')=>array('class'=>'info')),
					array($this->paginator->sort('User.full_name','Vartotojas')=>array('class'=>'warning'))
					));
		?>
		</thead>
		<tbody>
		<?php if(empty($locations)): ?>
		<tr>
			<td colspan="6" class="striped-info">No record found.</td>
		</tr>
		<?php endif; ?>
		<?php foreach ($locations as $location):?>
		<tr>
			<td>
				<a href="<?php echo $this->Html->url(array('controller' => 'locations', 'action' => 'edit', $location['Location']['id'])); ?>"><i class="icon-edit"></i></a>
			</td>
			<td class="striped-info"><a href="<?php echo $this->Html->url(array('controller' => 'locations', 'action' => 'view', $location['Location']['id'])); ?>"><?php echo $location['Location']['name']; ?></a></td>
			<td><?php echo $location['LocationCategory']['name']; ?></td>
			<td><?php
	
			 ?>&nbsp;<?php echo $location['User']['username']; ?></td>
			
		</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	<div class="pagination pagination-right pagination-mini">
	  <ul>
		<?php echo $this->Paginator->prev(''); ?>
		<?php echo $this->Paginator->numbers(array('first' => 2, 'last' => 2));?>
		<?php echo $this->Paginator->next(''); ?>
	  </ul>
	</div>
</div>
<script>
jQuery(function($) {
	$("#more").click(function(){
		$(".filter-box").toggle('fold');
	});
	$('#filter-result-close').click(function(){
		window.location.href = "<?php echo $this->Html->url(array('controller'=>'locations','action'=>'index')); ?>";
	});
});
</script>