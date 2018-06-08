<div class="navbar navbar-static-top">
		<div class="navbar-inner zhen-nav">
			<div class="container">
				<ul class="nav">
	    		  		<li class="<?php if($this->params['controller']=='dashboards') echo 'active'; ?>"><a href="<?php echo $this->Html->url(array('plugin'=>'','controller'=>'dashboards','action'=>'index')); ?>"><span></span>Pagrindinis</a></li>
	    		  		<li><a href="<?php echo $this->Html->url(array('plugin'=>'','controller'=>'dashboards','action'=>'full')); ?>"><span></span>Žemėlapis</a></li>
		          		<li class="dropdown <?php if($this->params['controller']=='locations') echo 'active'; ?>">
		          			<a class="dropdown-toggle" data-toggle="dropdown" data-target="<?php echo $this->Html->url(array('plugin'=>'','controller'=>'locations','action'=>'index')); ?>"
		          			 href="<?php echo $this->Html->url(array('plugin'=>'','controller'=>'locations','action'=>'index')); ?>">
		          			<span></span>
		          			DEVICE
		          			
		          			</a>
		          			<ul class="dropdown-menu">
		          				<li><a href="<?php echo $this->Html->url(array('plugin'=>'','controller'=>'locations','action'=>'add'));?>" > Naujas DEVICE</a></li>
		          			</ul>
		          		</li>          		       		
		        </ul>
			    <ul class="nav pull-right">
        			<?php if($this->Session->read('Auth.User')): ?>


		        	</a>
		        	</li>
		        	<?php  if (AuthComponent::user('group_id')==1): ?>
		        	<li class="dropdown <?php if(($this->params['controller']=='users') and ($this->params['action']=='index')) echo 'active'; ?>">
		        		<a class="dropdown-toggle"
					       data-toggle="dropdown"
					       href="#"><span></span>
					        Nustatymai
					        <i class="icon-angle-down"></i>
					    </a>
						<ul class="dropdown-menu" >
						      <li><?php echo $this->Html->link('Google',array('plugin'=>'','controller'=>'options','action'=>'edit')); ?></li>
						</ul>
		        	</li>
		        	<?php endif; ?>
		       		<li><a href="<?php echo $this->Html->url(array('plugin'=>'','controller'=>'users','action'=>'logout')); ?>"><span></span>Atsijungti</a></li>
		        	<?php else: ?>
		        	<?php endif; ?>
		        </ul>
			</div>
		</div>
	</div>