<link type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">

<section class="auth">
	<div class="wcontent features login center" style="max-width: 500px;">

		<img class="mb" src="<?php echo base_url('assets/i/logo.svg'); ?>" width="300" alt="">

		<p align="center"><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>

			<?php echo form_open("auth/forgot_password", "class='sec6_5_form'");?>
				<div class="form-group">  
		          <div class="row">
					  <div class="col-sm-6 col-sm-offset-3">
					  	<div id="infoMessage"><?php echo $message;?></div>
						<div class="sec6_5_label"><?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?></div>
				      	<?php echo form_input($identity);?><br /><br />
				      	<p><?php echo form_submit('submit', lang('forgot_password_submit_btn'), "class='btn blue'");?></p>
					</div>
				<?php echo form_close();?>
				</div>
		</div>
	</div>
</section>