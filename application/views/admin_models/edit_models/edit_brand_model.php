<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> 
		Edit Merk
	</h4>
</div>
<div class="modal-body">
   <div class="row">
	  	<div class="box box-danger">
		    <div class="box-body">
		     	<div class="col-md-12">
			 	<?php
					$Edit_attributes = array('id'=>'brand_form','method'=>'post','class'=>'form-horizontal');
				?>
				<?php echo form_open('initilization/edit_brand',$Edit_attributes); ?>	  
			      <div class="form-group">    
					<?php
						echo form_label('Nama Merk:');
						$data = array('class'=>'','type'=>'hidden','name'=>'edit_brand_id','value'=>$single_brand[0]->id);
						echo form_input($data);	

						$data = array('class'=>'form-control input-lg','type'=>'text','value'=>$single_brand[0]->name,'name'=>'brand_name');
						echo form_input($data);									
					?>          
			      </div>	
				  <div class="form-group">  				
			         <?php
						$data = array('class'=>'btn btn-info btn-outline-primary ','type' => 'submit','name'=>'btn_submit_category','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Perbarui Merk ');
						echo form_button($data);
					 ?>                            
			      </div>
				  <?php echo form_close(); ?>	
				</div>		
			</div>
		</div>
	</div>
</div>
<!-- Form Validation -->
<script src="<?php echo base_url(); ?>assets/dist/js/custom.js"></script>