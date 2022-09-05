<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );


// replaceing the select box -- to values in contact form 7 
function my_wpcf7_form_elements($html) {
    $text = 'Designing & Branding';
    $html = str_replace('<option value="">---</option>', '<option value="'.$text.'">' . $text . '</option>', $html);
    return $html;
}
add_filter('wpcf7_form_elements', 'my_wpcf7_form_elements');


// search
add_action('wp_ajax_nopriv_my_action', 'data_fetch');
add_action('wp_ajax_my_action', 'data_fetch');

function data_fetch(){
    
    $search = (!empty($_POST['search']) )? sanitize_text_field($_POST['search']) : ''; 
    $post_type = (!empty($_POST['post_type']) )? sanitize_text_field($_POST['post_type']) : '';   
    $post_cat_id = (int)$post_type;

    $no_post = (!empty($_POST['number']) )? sanitize_text_field($_POST['number']) : '';   
    $no_post = (int)$no_post;



    // echo gettype($post_cat_id);
    // exit();
    if( empty($search) && empty($post_cat_id) ){
        
        $args =  array(
                'post_type' => 'post',
                'posts_per_page' => $no_post,
                'order' => 'DESC',              

            );

    $getPosts = new WP_Query($args);
    }

    if( !empty($search) || !empty($post_cat_id) ){
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $no_post,
            'order' => 'DESC',
            's' => $search,
            'tax_query' => array(
                 'relation' => 'AND',
                    array(
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => $post_cat_id
                ),
            ),
        );
        $getPosts = new WP_Query($args);
    }  


     if( !empty($post_cat_id) ){
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $no_post,
            'order' => 'DESC',            
            'tax_query' => array(
                 'relation' => '',
                    array(
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => $post_cat_id
                ),
            ),
        );
        $getPosts = new WP_Query($args);
    } 

     if( !empty($search) ){
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $no_post,
            'order' => 'DESC',
            's' => $search,
            // 'tax_query' => array(
            //      'relation' => '',
            //         array(
            //         'taxonomy' => 'category',
            //         'field'    => 'term_id',
            //         'terms'    => $post_cat_id
            //     ),
            // ),
        );
        $getPosts = new WP_Query($args);
    } 


    
    // echo "<pre>";
    // print_r($getPosts);
    // exit();
    $post_count = $getPosts->post_count;
    if($post_count == 0) {
        $result = [
        'status' => 'error',        
        'msg' => ( 'No Result found' ),        
        ];

        wp_send_json($result);
        wp_die();    
    }

    $posts = [];
     if ( $getPosts->have_posts() ) { 
      while ($getPosts->have_posts()) {
            $getPosts->the_post();                       

    $posts[] = array(
        'title' => get_the_title(),
        'contents' => get_the_content(),
        
    );

    }
}
    $result = [
        'status' => 'success',
        'response_type' => 'get posts',
        'msg' => 'results',        
        'data' => $posts,              
    ];
    wp_send_json($result);
    wp_die();
    
}



/*

// financial filter
add_action('wp_ajax_nopriv_financial_filter_action', 'getFinancialIssuePost');
add_action('wp_ajax_financial_filter_action', 'getFinancialIssuePost');


function getFinancialIssuePost() {





    
    $yearField = (!empty($data['select_year_box'])) ? sanitize_text_field($data['select_year_box']) : "";   

    
    $counterField = (!empty($data['counter'])) ? absint($data['counter']) : "";
    $args = array(
        'post_type' => 'cb_financialresults',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'tax_query' => array(
                array(
            'taxonomy' => 'financialresults_type',
            'field'    => 'term_id',
            'terms'    => [$termId]
            ),
            ),
    );

        if($yearField != "") {
            $args['meta_query'] = array(
                    'relation' => 'AND',
            );
            if($yearField != "") {
                $args['meta_query'][] = array(
                        'key' => 'financial_year',
            'value' => $yearField,
            'compare' => '='
                );
            }           
        }   
    // print_r($args);
    // exit;   
    $getPosts = new WP_Query($args);
    $post_count = $getPosts->post_count;
    if($post_count == 0) {
        $result = [
        'status' => 'error',
        'response_type' => 'get posts',
        'msg' => __( 'No Result found' ),
        'post_count' => $post_count,
        'data' => null,
        'counter' => $counterField,
        'layoutType' => $data['layout'],
        ];
        wp_send_json($result);
        wp_die();    
    }
  $posts = [];
  if ( $getPosts->have_posts() ) { 
      while ($getPosts->have_posts()) {
            $getPosts->the_post();
            $posts[] = array(
                'title' => get_the_title(),
                'thumbnail_img' => get_field('thumbnail_img'),
                'investor_date' => get_field('investor_date'),
                'upload_pdf' => get_field('upload_pdf'),
                'updf_link' => get_field('upload_pdf'),
                'uaudio_link' => get_field('upload_audio'),
                'q1_pdf_link' => get_field('q1_pdf'),
                    'q1_audio_link' => get_field('q1_audio'),
                    'q2_pdf_link' => get_field('q2_pdf'),
                    'q2_audio_link' => get_field('q2_audio'),
                    'q3_pdf_link' => get_field('q3_pdf'),
                    'q3_audio_link' => get_field('q3_audio'),
                    'q4_pdf_link' => get_field('q4_pdf'),
                    'q4_audio_link' => get_field('q4_audio'),
                    'uploadv_link' => get_field('upload_video'),
                    'custom_link' => get_field('custom_link'),

            );
        }    
   } 
    $result = [
        'status' => 'success',
        'response_type' => 'get posts',
        'msg' => 'products found',
        'post_count' => $post_count,
        'data' => $posts,
        'counter' => $counterField,
        'layoutType' => $data['layout'],
    ];
    wp_send_json($result);
    wp_die();
}
