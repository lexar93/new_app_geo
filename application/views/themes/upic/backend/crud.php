<?php foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets_admin/css/wancora.css'); ?>"  />
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

	<div class="body-crud">
		<?php 
			echo $output;
		?>
	</div>
	
</div>