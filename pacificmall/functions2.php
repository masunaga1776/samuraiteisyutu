<?php
function my_enqueue_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'bundle_js', get_template_directory_uri(). '/assets/js/bundle.js', array() );
	wp_enqueue_style( 'my_styles', get_template_directory_uri(). '/assets/css/styles.css', array() );
}
add_action( 'wp_enqueue_scripts', 'my_enqueue_scripts' );

// �w�b�_�[�A�t�b�^�[�̃J�X�^�����j���[��
register_nav_menus(
	array(
		'place_global' => ' �O���[�o��',
		'place_footer' => ' �t�b�^�[�i�r',
	)
);

// ���C���摜��Ƀe���v���[�g���Ƃ̕������\��
function get_main_title() {
	if ( is_singular( 'post' ) ):
		$category_obj = get_the_category();
		return $category_obj[0]->name;
	elseif ( is_page() ):
		return get_the_title();
	elseif ( is_category() || is_tax() ):
		return single_cat_title();
	elseif ( is_search() ):
		return ' �T�C�g����������';
	elseif ( is_404() ):
		return ' �y�[�W��������܂���';
	elseif ( is_singular( 'daily_contribution' ) ):
		global $post;
		$term_obj = get_the_terms( $post->ID, 'event' );
		return $term_obj[0]->name;
	endif;
}

// �q�y�[�W���擾����֐�
function get_child_pages( $number = -1, $specified_id = null ) {
	if ( isset( $specified_id ) ):
		$parent_id = $specified_id;
	else:
		$parent_id = get_the_ID();
	endif;
	$args = array(
		'posts_per_page' => $number,
		'post_type' => 'page',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'post_parent' => $parent_id,
	);
	$child_pages = new WP_Query( $args );
	return $child_pages;
}

// �A�C�L���b�`�摜�𗘗p�ł���悤�ɂ���
add_theme_support( 'post-thumbnails' );

// �g�b�v�y�[�W�̃��C���摜�p�̃T�C�Y�ݒ�
add_image_size( 'top', 1077, 622, true );

// �n��v�������ꗗ�摜�p�̃T�C�Y�ݒ�
add_image_size( 'contribution', 557, 280, true );

// �g�b�v�y�[�W�̒n��v�������ɂĎg�p���Ă���摜�p�̃T�C�Y�ݒ�
add_image_size( 'front-contribution', 255, 189, true );

// ��Ə��E�X�܏��ꗗ�摜�p�̃T�C�Y�ݒ�
add_image_size( 'common', 465, 252, true );

// �e�y�[�W�̃��C���摜�p�̃T�C�Y�ݒ�
add_image_size( 'detail', 1100, 330, true );

// �����ꗗ�摜�p�̃T�C�Y�ݒ�
add_image_size( 'search', 168, 168, true );

// �e�e���v���[�g���Ƃ̃��C���摜��\��
function get_main_image() {
	if ( is_page() || is_singular( 'daily_contribution' ) ):
		$attachment_id = get_field( 'main_image' );
		if ( is_front_page() ):
			return wp_get_attachment_image( $attachment_id, 'top' );
		else:
			return wp_get_attachment_image( $attachment_id, 'detail' );
		endif;
	elseif ( is_category( 'news' ) || is_singular( 'post' ) ):
		return '<img src="'. get_template_directory_uri(). '/assets/images/bg-page-news.jpg" />';
	elseif ( is_search() || is_404() ):
		return '<img src="'. get_template_directory_uri() .'/assets/images/bg-page-search.jpg">';
	elseif ( is_tax( 'event' ) ):
		$term_obj = get_queried_object();
		$image_id = get_field( 'event_image', $term_obj->taxonomy. '_'. $term_obj->term_id );
		return wp_get_attachment_image( $image_id, 'detail' );
	else:
		return '<img src="'. get_template_directory_uri(). '/assets/images/bg-page-dummy.png" />';
	endif;
}

// ����̋L���𒊏o����֐�
function get_specific_posts( $post_type, $taxonomy = null, $term = null, $number = -1 ) {
	if ( ! $term ):
		$terms_obj = get_terms( 'event' );
		$term = wp_list_pluck( $terms_obj, 'slug' );
	endif;

	$args = array(
		'post_type' => $post_type,
		'tax_query' => array(
			array(
				'taxonomy' => $taxonomy,
				'field' => 'slug',
				'terms' => $term,
			),
		),
		'posts_per_page' => $number,
	);
	$specific_posts = new WP_Query( $args );
	return $specific_posts;
}

function cms_excerpt_more() {
	return '...';
}
add_filter( 'excerpt_more', 'cms_excerpt_more' );

function cms_excerpt_length() {
	return 80;
}
add_filter( 'excerpt_mblength', 'cms_excerpt_length' );

// �����@�\���Œ�y�[�W�Ɏg����悤�ݒ�
add_post_type_support( 'page', 'excerpt' );

function get_flexible_excerpt( $number ) {
	$value = get_the_excerpt();
	$value = wp_trim_words( $value, $number, '...' );
	return $value;
}

//get_the_excerpt() �Ŏ擾���镶����ɉ��s�^�O��}��
function apply_excerpt_br( $value ) {
	return nl2br( $value );
}
add_filter( 'get_the_excerpt', 'apply_excerpt_br' );

// �E�B�W�F�b�g�@�\��L����
function theme_widgets_init() {
	register_sidebar( array(
		'name' => ' �T�C�h�o�[�E�B�W�F�b�g�G���A',
		'id' => 'primary-widget-area',
		'description' => ' �Œ�y�[�W�̃T�C�h�o�[',
		'before_widget' => '<aside class="side-inner">',
		'after_widget' => '</aside>',
		'before_title' => '<h4 class="title">',
		'after_title' => '</h4>',
	) );
}
add_action( 'widgets_init', 'theme_widgets_init' );

// ���C���摜��Ƀe���v���[�g���Ƃ̉p��^�C�g����\��
function get_main_en_title() {
	if ( is_category() ):
		$term_obj = get_queried_object();
		$english_title = get_field( 'english_title', $term_obj->taxonomy. '_'. $term_obj->term_id );
		return $english_title;
	elseif ( is_singular( 'post' ) ):
		$term_obj = get_the_category();
		$english_title = get_field( 'english_title', $term_obj[0]->taxonomy. '_'. $term_obj[0]->term_id );
		return $english_title;
	elseif ( is_page() || is_singular( 'daily_contribution' ) ):
		return get_field( 'english_title' );
	elseif ( is_search() ):
		return 'Search Result';
	elseif ( is_404() ):
		return '404 Not Found';
	elseif ( is_tax() ):
		$term_obj = get_queried_object();
		$english_title = get_field( 'english_title', $term_obj->taxonomy. '_'. $term_obj->term_id );
		return $english_title;
	endif;
}
