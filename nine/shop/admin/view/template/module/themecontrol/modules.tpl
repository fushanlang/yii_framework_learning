<?php 
	$d = array(
		'delivery_data_module' => '
		
			<div id="freeship">
				<div class="heading">
					<h4>Free delivery !</h4>
					<span>Lorem psum conubia.</span>
				</div>
			</div>
		',
		'content_data_module'=>'
			<p>123 Me Tri, Hanoi , VietNam 100000</p>
			<p class="tel">0123456789</p>
			<p><img src="image/data/payment.png" alt="paymethods" /></p>
		',
		'username_twitter_module' => 'pavothemes'
	);
	$module = array_merge( $d, $module );
?>
<h4><?php echo $this->language->get( 'Internal Modules' ) ; ?></h4>
<table class="form">
		<tr>
			<td><?php echo $this->language->get('Delivery Module');?></td>
			<td>
				<h4><label><?php echo $this->language->get('Module HTML Content');?></label></h4>
				<textarea name="themecontrol[delivery_data_module]" id="delivery_data_module" rows="5" cols="60"><?php echo $module['delivery_data_module'];?></textarea>
				<p><i><?php echo $this->language->get('this module appear in header right position');?></i></p>
			</td>
		</tr>
		<tr>
			<td><?php echo $this->language->get('Twitter Module');?></td>
			<td>
				<h4><label><?php echo $this->language->get('Username');?></label></h4>
				<input name="themecontrol[username_twitter_module]"  value="<?php echo $module['username_twitter_module'];?>"/>
				<p><i><?php echo $this->language->get('this module appear in Footer [1] position');?></i></p>
			</td>
		</tr>
		<tr>
			<td><?php echo $this->language->get('Contact Us Module');?></td>
			<td>
				<h4><label><?php echo $this->language->get('Module HTML Content');?></label></h4>
				<textarea name="themecontrol[content_data_module]" id="content_data_module" rows="5" cols="60"><?php echo $module['content_data_module'];?></textarea>
				<p><i><?php echo $this->language->get('this module appear in Footer [5] position');?></i></p>
			</td>
		</tr>
</table>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--


CKEDITOR.replace('delivery_data_module', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});

CKEDITOR.replace('content_data_module', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});

//--></script> 