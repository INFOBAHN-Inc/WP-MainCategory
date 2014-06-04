<?php
/*
Plugin Name: Main Category
Description: メインカテゴリを選択し、カスタムフィールドに登録
Version: 0.1
*/

/**
 * main-category.php
 *
 * @package WordPress
 * @subpackage MainCategory
 * @copyright Copyright (c) 2013, infobahn inc.
 */

/**
 * カスタムフィールド名
 * @var string
 */
define("MAIN_CATEGORY_POST_META", "main_category");
/**
 * 管理画面のselect要素に指定する名前
 * @var string
 */
define("MAIN_CATEGORY_POST_NAME", "main_category");
/**
 * nonce 用ユニークキー
 * @var string
 */
define("MAIN_CATEGORY_NONCE_NAME", plugin_basename(__FILE__));
/**
 * nonce の hidden タグに指定する名前
 * @var string
 */
define("MAIN_CATEGORY_NONCE_POST_NAME", "main_category_nonce");

/**
 * 管理画面で、「メインカテゴリ」を指定
 * @see http://wpdocs.sourceforge.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/add_meta_box
 */
add_action("admin_menu", function () {

	$post_types = (array) apply_filters('main_category_add_meta', array('post'));

	$callback = function ($wppost, $plugin) {

		$nonce      = wp_create_nonce(MAIN_CATEGORY_NONCE_NAME);
		$registed   = get_post_meta($wppost->ID, MAIN_CATEGORY_POST_META, true);

		include_once dirname(__FILE__) . "/admin-html.php";

	};

	foreach ($post_types as $type) {
		add_meta_box("main_category_section", "メインカテゴリ", $callback, $type, 'side');
	}
});

/**
 * 記事の保存時、メインカテゴリをカスタムフィールドに保存
 * @param int $post_id
 * @return int
 */
add_action("save_post", function ( $post_id ) {

	if ( !wp_verify_nonce( $_POST[MAIN_CATEGORY_NONCE_POST_NAME], MAIN_CATEGORY_NONCE_NAME )) {
		return $post_id;
	}

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
		return $post_id;
	}

	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) ){
			return $post_id;			
		}
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) ){
			return $post_id;
		}
	}

	$value = $_POST[MAIN_CATEGORY_POST_NAME];

	if (!$value && $value != -1) {
		return $post_id;
	}

	update_post_meta($post_id, MAIN_CATEGORY_POST_META, $value);

	return $value;
});


/**
 * フロント用　メインカテゴリの取得
 * @param string $post_id
 * @return NULL|Ambigous <mixed, unknown, NULL, WP_Error, multitype:, object, array|object, string>
 */
function get_main_category( $post_id=null ) {

	if (is_null($post_id)) {
		$post_id = get_the_ID();
	}

	$id = get_post_meta($post_id, MAIN_CATEGORY_POST_META, true);

	if (!id) {
		return null;
	}

	return get_category($id);
}

/**
 * フロント用 メインカテゴリの存在チェック
 * @param string $post_id
 * @return boolean
 */
function have_main_category($post_id=null) {
	return (get_post_meta($post_id, MAIN_CATEGORY_POST_META, true) !== "");
}

/**
 * フロント用 メインカテゴリの出力
 * @param string $post_id
 */
function the_main_category( $post_id=null ) {
	$category = get_main_category($post_id);
	echo ($category) ? $category->name : "";
}

/**
 * フロント用 メインカテゴリスラッグの出力
 * @param string $post_id
 */
function the_main_category_slug( $post_id=null ) {
	$category = get_main_category($post_id);
	echo ($category) ? $category->slug : "";
}