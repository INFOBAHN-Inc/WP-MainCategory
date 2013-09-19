<?php
/**
 * admin-html.html
 * 管理画面に
 * @package WordPress
 * @subpackage MainCategory
 * @copyright Copyright (c) 2013, infobahn inc.
 */
?>
<!-- MainCategory Plugin -->
<input type="hidden" name="<?php echo MAIN_CATEGORY_NONCE_POST_NAME; ?>" value="<?php echo $nonce?>" />
<?php 
wp_dropdown_categories(array(
	'name'             => MAIN_CATEGORY_POST_NAME,
	'show_option_none' => '--',
	'hide_empty'       => false,
	'selected'         => $registed,
	'hierarchical'     => 1,
));
?>
<script>
jQuery(function ($) {
	var $mainCategory = $('#main_category');

	$mainCategory.on('change', function (event) {
		var $this = $(this),
			val   = $this.val();

		if (val !== '-1') {
			$('#categorydiv input[value=' + val + ']').prop('checked', true);
		}
	});
});
</script>