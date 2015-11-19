<?php 
/*
Template Name: This is simple Template 
Template URI: http://www.rrfoundation.net
Author Name:Abdus salam
Auhtor URI: http://www.abdussalam.me.com
Version: 1.0
Description: This is my personal page
*/

/*This code for php header areas*/ 
<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="all" />
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />	

<?php echo get_template_directory_uri(); ?>/
<?php wp_head(); ?>


/*This code for use dymamic widget register areas*/  
function salam_widget_areas() {
	register_sidebar(array (
		'name' =>__( 'left_sidebar', 'salam' ),
		'id' => 'single_sidebar',
		'before_widget' => '<div class="single_sidebar">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	));
}
add_action('widgets_init', 'salam_widget_areas');

/*This code for register index widget areas*/
<?php dynamic_Sidebar('single_sidebar'); ?>

/*This code for coditional widget register*/
<?php if ( ! dynamic_sidebar( 'call_to_action_widget' ) ) : ?>
	<-write your text here->
<?php endif; ?>


/*This code for post quert in index.php*/
<?php if(have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>        
your text file
<?php endwhile; ?>    
<?php endif; ?>


/*This code use for red more in word-press */
<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts') ); ?></div>
<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>') ); ?></div>	


/*This code for single_post query in single.php*/
<?php if(have_posts()) : ?><?php while(have_posts())  : the_post(); ?>
<h2><?php the_title(); ?></h2>
<?php the_content(); ?>
<?php comments_template( '', true ); ?>  
<?php endwhile; ?>
					 
<?php else : ?>
<h3><?php _e('404 Error&#58; Not Found'); ?></h3>
<?php endif; ?>


/*This code for breadcumbs it use in page.php*/
<div class="breadcumbs">
	<?php if (function_exists('wordpress_breadcrumbs')) wordpress_breadcrumbs(); ?>
</div>

<?php if(have_posts()) : ?><?php while(have_posts())  : the_post(); ?>
	<h2><?php the_title(); ?></h2>
	<?php the_content(); ?> 
	<?php endwhile; ?>
					
	<?php else : ?>
	<h3><?php _e('404 Error&#58; Not Found', 'bilanti'); ?></h3>
	<?php endif; ?>

	
/*This codw for archive.php */
         <h2 class="archive_title">
	        <?php if (have_posts()) : ?>

           <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>

            <?php /* If this is a category archive */ if (is_category()) { ?>

               <?php _e('Archive for the'); ?> '<?php echo single_cat_title(); ?>' <?php _e('Category'); ?>                                    

            <?php /* If this is a tag archive */  } elseif( is_tag() ) { ?>

                <?php _e('Archive for the'); ?> <?php single_tag_title(); ?> Tag

            <?php /* If this is a daily archive */ } elseif (is_day()) { ?>

                <?php _e('Archive for'); ?> <?php the_time('F jS, Y'); ?>                                        

            <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>

                <?php _e('Archive for'); ?> <?php the_time('F, Y'); ?>                                    

            <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>

                <?php _e('Archive for'); ?> <?php the_time('Y'); ?>                                        

            <?php /* If this is a search */ } elseif (is_search()) { ?>

                <?php _e('Search Results'); ?>                            

            <?php /* If this is an author archive */ } elseif (is_author()) { ?>

                <?php _e('Author Archive'); ?>                                        

            <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>

                <?php _e('Blog Archives'); ?>                                        
			<?php } ?>
        </h2>
		
		
/*This code use for before the post-loop.php*/
<?php else : ?>
	<h3><?php _e('404 Error&#58; Not Found'); ?></h3>
<?php endif; ?>


/*This code for dynamic slider in post-query in functions.php */
add_theme_support( 'post-thumbnails', array( 'post', 'slider') );
add_image_size( 'slider-image', 670, 325, true );
/*This code for register post query in functions.php for slider dynamic in wordpress*/
	function create_post_type() {
		register_post_type( 'slider',
			array(
				'labels' => array(
					'name' => __( 'Slides' ),
					'singular_name' => __( 'Slide' ),
					'add_new' => __( 'Add New' ),
					'add_new_item' => __( 'Add New Slide' ),
					'edit_item' => __( 'Edit Slide' ),
					'new_item' => __( 'New Slide' ),
					'view_item' => __( 'View Slide' ),
					'not_found' => __( 'Sorry, we couldn\'t find the Slide you are looking for.' )
				),
			'public' => true,
			'publicly_queryable' => false,
			'exclude_from_search' => true,
//			'show_in_menu' => false,
			'menu_position' => 14,
			'has_archive' => false,
			'hierarchical' => false, 
			'capability_type' => 'page',
			'rewrite' => array( 'slug' => 'slide' ),
			'supports' => array( 'title', 'thumbnail' )
			)
		);
	}
	add_action( 'init', 'create_post_type' );
/*This code use for dynamic slider we will use it in ul */
		<?php if(!is_paged()) { ?>
		<?php
			$args = array( 'post_type' => 'slider', 'posts_per_page' => 4 );
			$loop = new WP_Query( $args );
		?>  
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
		<li>
		
			<?php the_post_thumbnail('slider-image', array('class' => 'postthumbnails')); ?>
		</li>						
		<?php endwhile; ?>
		<?php wp_reset_query(); ?>
		<?php } ?>
/*This is another code for slider in word-press side*/


<?php $slider_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'slider-thumb' ); ?>	



							<?php
							global $post;
							$args = array( 'posts_per_page' => -1, 'post_type'=> 'slider' );
							$myposts = get_posts( $args );
							foreach( $myposts as $post ) : setup_postdata($post); ?>
								<img src="<?php $slide_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'slider-image' ); echo $slide_image[0]; ?>" alt="" title="#<?php the_ID(); ?>"/>
							<?php endforeach; ?>
				
/*This code for option tree */


		<?php
			$homepage_category= get_option_tree( 'homepage_post_category', '', false );
			global $post;


			$args = array( 'posts_per_page' => -1, 'post_type'=> 'post', 'cat' => $homepage_category );
			$myposts = get_posts( $args );
			foreach( $myposts as $post ) : setup_postdata($post);
		?>
		//your default code here
		<?php endforeach; ?>
		
		
/********This query post categoey for id selection in woerdpress side*******/
	<?php
	global $post;
	$args = array( 'posts_per_page' => -1, 'post_type'=> 'post', 'cat' => '3,2' );
	$myposts = get_posts( $args );
	foreach( $myposts as $post ) : setup_postdata($post); ?>
		//Your default data set here
		
	<?php endforeach; ?>
	
/*This code for category post query */
	<?php
	global $post;
	$args = array( 'posts_per_page' => -1, 'post_type'=> 'product', 'product_cat' => 'Featured' );
	$myposts = get_posts( $args );
	foreach( $myposts as $post ) : setup_postdata($post); ?>
		//Your default data set here
		
	<?php endforeach; ?>
	
/*This code for comments.css*/
.comments {margin: 10px 0;}
.comments h3 {margin:50px 0 30px 0;font-size:24px;}
ol.commentlist { list-style:none; margin:0 0 1em; padding:0; text-indent:0; }
ol.commentlist li { }
ol.commentlist li.alt { }
ol.commentlist li.bypostauthor {}
ol.commentlist li.byuser {}
ol.commentlist li.comment-author-admin {}
ol.commentlist li.comment { border-bottom: 1px solid #ddd; padding:1em; margin-bottom: 10px; }
ol.commentlist li div.comment-author {}
ol.commentlist li div.vcard { font-size:20px;}
ol.commentlist li div.vcard cite.fn { font-style:normal; }
ol.commentlist li div.vcard cite.fn a.url {}
ol.commentlist li div.vcard img.avatar {float:left; margin:0 1em 1em 0; }
ol.commentlist li div.vcard img.avatar-32 {}
ol.commentlist li div.vcard img.photo {}
ol.commentlist li div.vcard span.says {}
ol.commentlist li div.commentmetadata {}
ol.commentlist li div.comment-meta { font-size:9px; margin-bottom: 10px;}
ol.commentlist li div.comment-meta a { color: #aaa; }
ol.commentlist li p { margin: 0; }
ol.commentlist li ul { list-style:square; margin:0 0 1em 2em; }
ol.commentlist li div.reply { font-size:11px; }
ol.commentlist li div.reply a { font-weight:bold; }
ol.commentlist li ul.children { list-style:none; margin:1em 0 0; text-indent:0; }
ol.commentlist li ul.children li {}
ol.commentlist li ul.children li.alt {}
ol.commentlist li ul.children li.bypostauthor {}
ol.commentlist li ul.children li.byuser {}
ol.commentlist li ul.children li.comment {}
ol.commentlist li ul.children li.comment-author-admin {}
ol.commentlist li ul.children li.depth-2 { margin:0 0 .25em .25em; }
ol.commentlist li ul.children li.depth-3 { margin:0 0 .25em .25em; }
ol.commentlist li ul.children li.depth-4 { margin:0 0 .25em .25em; }
ol.commentlist li ul.children li.depth-5 {}
ol.commentlist li ul.children li.odd {}
ol.commentlist li.even { background:#fff; }
ol.commentlist li.odd { background:#f6f6f6; }
ol.commentlist li.parent { }
ol.commentlist li.pingback { margin: 0 0 10px; padding: 1em; border: 1px dashed #ccc; }
ol.commentlist li.thread-alt { }
ol.commentlist li.thread-even { }
ol.commentlist li.thread-odd {}

/* ===================== comment form ===================== */ 

#respond {position: relative;}
#respond input[type="text"],#respond textarea {border:1px solid #ddd;padding:10px}
#respond input[type="text"] {padding:7px;width:300px}
#respond .comment-form-author,
#respond .comment-form-email,
#respond .comment-form-url,
#respond .comment-form-comment { position: relative; }
#respond .comment-form-author label,
#respond .comment-form-email label,
#respond .comment-form-url label,
#respond .comment-form-comment label { background: #eee; color: #555; display: inline-block; left: 4px; min-width: 60px; padding: 4px 10px; position: relative; top: 40px; z-index: 1; }
#respond input[type="text"]:focus,
#respond textarea:focus { text-indent: 0; z-index: 1; }
#respond textarea { resize: vertical; width: 95%; }
#respond .comment-form-author .required,
#respond .comment-form-email .required { color: #bd3500; font-size: 22px; font-weight: bold; left: 75%; position: absolute; top: 45px; z-index: 1; }
#respond .comment-notes,
#respond .logged-in-as { font-size: 13px; }
#respond p { margin: 10px 0; }
#respond .form-submit { float: right; margin: -20px 0 10px; }
#respond input#submit { background: #454545; border: none; -moz-border-radius: 3px; border-radius: 3px; -webkit-box-shadow: 0px 1px 2px rgba(0,0,0,0.3); -moz-box-shadow: 0px 1px 2px rgba(0,0,0,0.3); box-shadow: 0px 1px 2px rgba(0,0,0,0.3); color: #eee; cursor: pointer; padding: 5px 42px 5px 22px; }
#respond input#submit:active { background: #86222D; color: #fff; }
#respond #cancel-comment-reply-link { color: #666; margin-left: 10px; text-decoration: none; }
#respond .logged-in-as a:hover,
#respond #cancel-comment-reply-link:hover { text-decoration: underline; }
.commentlist #respond { margin: 1.625em 0 0; width: auto; }
#reply-title { color: #373737; font-size: 20px; }
#cancel-comment-reply-link { color: #888; display: block; position: absolute; right: 1.625em; text-decoration: none; text-transform: uppercase; top: 1.1em; }
#cancel-comment-reply-link:focus,
#cancel-comment-reply-link:active,
#cancel-comment-reply-link:hover { color: #ff4b33; }
#respond label {display: block; float: right; font-size: 16px; line-height: 2.2em; width: 280px;}
#respond input[type=text] {}
#respond p { font-size: 12px; }
p.comment-form-comment { margin: 0; }
.form-allowed-tags { display: none; }
.trackback { margin: 0 0 10px; padding: 1em; border: 1px dashed #ccc; }

/*For This add Funtions.php This code*/
function comment_scripts(){

   if ( is_singular() ) wp_enqueue_script( 'comment-reply' );

}

add_action( 'wp_enqueue_scripts', 'comment_scripts' );

/*Note:You must be add header.php comments.css*/


/*This code for featured images support in functions.php */
add_theme_support( 'post-thumbnails', array( 'post' ) );
set_post_thumbnail_size( 200, 200, true );
add_image_size( 'post-image', 150, 150, true );

/*This code for use post-loop.php featured images support*/
<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('post-image', array('class' => 'post-thumb')); ?></a>


/*This code for menu creation in functions.php*/

function wpj_register_menu() {

    if (function_exists('register_nav_menu')) {

        register_nav_menu( 'main-menu', __( 'Main Menu') );

    }

}
add_action('init', 'wpj_register_menu');


/*This code for menu for header.php*/
<?php wp_nav_menu( array( 'theme_location' => 'wpj-main-menu', 'menu_id' => 'nav') ); ?>
<?php wp_nav_menu( array( 'theme_location' => 'wpj-main-menu', 'menu_id' => 'mobile_menu') ); ?>	
<?php wp_nav_menu( array( 'theme_location' => 'main-menu') ); ?>

<?php wp_nav_menu( array( 'theme_location' => 'top-menu', 'menu_class' => 'footermenu') ); ?>

/*This code for conditional menu creation function.php */
	add_action('init', 'wpj_register_menu');
	function wpj_register_menu() {
		if (function_exists('register_nav_menu')) {
			register_nav_menu( 'wpj-main-menu', __( 'Main Menu', 'brightpage' ) );
		}
	}
	function wpj_default_menu() {
		echo '<ul id="nav">';
		if ('page' != get_option('show_on_front')) {
			echo '<li><a href="'. home_url() . '/">Home</a></li>';
		}
		wp_list_pages('title_li=');
		echo '</ul>';
	}
	register_nav_menu( 'menu_footer', __( 'Footer Menu', 'bilanti' ) );

	
/*This code for use header.php convert menu */
				<?php
				if (function_exists('wp_nav_menu')) {
					wp_nav_menu(array('theme_location' => 'wpj-main-menu', 'menu_id' => 'nav', 'fallback_cb' => 'wpj_default_menu'));
				}
				else {
					wpj_default_menu();
				}
				?>
				
				
/*========================= For register Navigation menu=======================*/
function Function_Name() {

    if (function_exists('register_nav_menu')) {
		register_nav_menu( 'Write_ID', __( 'Write_Menu_Name') );
		}
	}
add_action('init', 'Function_Name');



/*This code use read more for functions.php*/
function excerpt($num) {

$limit = $num+1;

$excerpt = explode(' ', get_the_excerpt(), $limit);

array_pop($excerpt);

$excerpt = implode(" ",$excerpt)." <a href='" .get_permalink($post->ID) ." ' class='".readmore."'>Read More</a>";

echo $excerpt;

}

/*This code use remove php_contrent and use this code in post-loop.php in wordpress*/
<?php echo excerpt('70'); ?>


/*This code for category selection*/
<?php query_posts('post_type=post&category_name=News&post_status=publish&posts_per_page=2&paged='. get_query_var('paged')); ?>
<?php get_template_part('post-loop'); ?>

<?php query_posts('post_type=post&category_name=Others&post_status=publish&posts_per_page=2&paged='. get_query_var('paged')); ?>
<?php get_template_part('post-loop'); ?>


/*This code for custom post register in functions.php / testimonial*/
            add_action( 'init', 'create_post_type' );
            function create_post_type() {
                    register_post_type( 'testimonial',
                            array(
                                    'labels' => array(
                                            'name' => __( 'Testimonial' ),
                                            'singular_name' => __( 'Testimonial' ),
                                            'add_new' => __( 'Add New' ),
                                            'add_new_item' => __( 'Add New Testimonial' ),
                                            'edit_item' => __( 'Edit Testimonial' ),
                                            'new_item' => __( 'New Testimonial' ),
                                            'view_item' => __( 'View Testimonial' ),
                                            'not_found' => __( 'Sorry, we couldn\'t find the Testimonial you are looking for.' )
                                    ),
                            'public' => true,
                            'publicly_queryable' => false,
                            'exclude_from_search' => true,
                            'menu_position' => 14,
                            'has_archive' => false,
                            'hierarchical' => false,
                            'capability_type' => 'page',
                            'rewrite' => array( 'slug' => 'testimonial' ),
                            'supports' => array( 'title', 'editor', 'custom-fields' )
                            )
                    );
            }
/*This code for psot images*/
	add_image_size( 'portfolio-image', 640, 440, true );
	add_image_size( 'author-image', 150, 150, true );
	
	add_action( 'init', 'create_post_type' );
	function create_post_type() {
		register_post_type( 'portfolio',
			array(
				'labels' => array(
					'name' => __( 'Portfolio Items' ),
					'singular_name' => __( 'Portfolio' ),
					'add_new' => __( 'Add New' ),
					'add_new_item' => __( 'Add New Portfolio' ),
					'edit_item' => __( 'Edit Portfolio' ),
					'new_item' => __( 'New Portfolio' ),
					'view_item' => __( 'View Portfolio' ),
					'not_found' => __( 'Sorry, we couldn\'t find the Portfolio you are looking for.' )
				),
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => true,
			'menu_position' => 14,
			'has_archive' => true,
			'hierarchical' => true,
			'capability_type' => 'page',
			'rewrite' => array( 'slug' => 'portfolio' ),
			'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields' )
			)
		);
	}
			
/*This code for testimonial use which you gate want*/
<?php query_posts('post_type=testimonial&post_status=publish&posts_per_page=1&paged='. get_query_var('paged')); ?>	

<?php if(have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>        
	<div class="single_testimonial fix">
		<div class="client_comment fix">
			<?php the_content(); ?>
		</div>
		<div class="client_name fix">
			<?php the_title(); ?>
		</div>
	</div>
<?php endwhile; ?>    
<?php endif; ?>
						
						
/*conditional customfiled data in posted-look.php*/
<p style="background:red;color:#fff;padding:10px"><?php
	$url = get_post_meta( $post->ID, 'url', true );
	if ( $url ) {
		echo $url;
	} else {
		the_permalink();
	}
	?>
</p>
/*To get different images perpage in page.php or other page.php and use this page customfield register*/
<?php $image = get_post_meta($post->ID, 'url', true);
<?php echo get_post_meta($post->ID, 'key', true); ?>

if($image) : ?>

<img src="<?php echo $image; ?>" alt="" />

<?php endif; ?>


/*This code for option tree in function.php to activate option tree */
add_filter( 'ot_show_pages', '__return_false' );
add_filter( 'ot_show_new_layout', '__return_false' );
add_filter( 'ot_theme_mode', '__return_true' );
include_once( 'option-tree/ot-loader.php' );
include_once( 'includes/theme-options.php' );
include_once( 'includes/meta-boxes.php' );

/*conditional option tree data in word-press for images*/
				<?php if ( function_exists( 'get_option_tree') ) : if( get_option_tree( 'logo_uploader') ) : ?>    
					<a href="<?php bloginfo('home'); ?>"><img src="<?php get_option_tree( 'logo_uploader', '', 'true' ); ?>" alt=""/></a>
				<?php else : ?>
					// default data in hitml which you can abe change <a href="<?php bloginfo('home'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.jpg" alt=""/></a>
				<?php endif; endif; ?>

				
/*This code for pagination use function.php*/	
function pagination($pages = '', $range = 4)
    {  
         $showitems = ($range * 2)+1;  

         global $paged;
         if(empty($paged)) $paged = 1;

         if($pages == '')
         {
             global $wp_query;
             $pages = $wp_query->max_num_pages;
             if(!$pages)
             {
                 $pages = 1;
             }
         }   

         if(1 != $pages)
         {
             echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
             if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
             if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";

             for ($i=1; $i <= $pages; $i++)
             {
                 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
                 {
                     echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
                 }
             }

             if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";  
             if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
             echo "</div>\n";
         }
    } 		
			
/* For Pagination Css */
.pagination{
clear:both;
font-size:11px;
line-height:13px;
margin-left:35px;
padding:20px 0;
}
.pagination span, .pagination a{
display:block;
float:left;
margin:2px 2px 2px 0;
padding:6px 9px 5px 9px;
text-decoration:none;
width:auto;
color:#fff;
background:#555;
}
.pagination a:hover{
color:#fff;
background:#3279BB;
}
.pagination .current{
padding:6px 9px 5px 9px;
background:#3279BB;
color:#fff;
} 

/*This code for pagination in index.php*/			
<?php if (function_exists("pagination")) {
        pagination($additional_loop->max_num_pages);
    } ?>

	
/*Searchform Code in index.php==========(searchformcode) */				
<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
   <input type="text" value="<?php the_search_query(); ?>" name="s" id="s" class="searchfield" />
   <input type="submit" id="searchsubmit" value="search" class="searchbutton"/>
</form>

<?php the_content(); ?>

<?php get_header(); ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>

<?php the_time('m-d-y') ?>

<?php comments_popup_link(); ?>

<?php the_title(); ?>

<?php the_permalink() ?>

<?php the_category(', ') ?>

<?php the_author(); ?>

<?php the_ID(); ?>

<?php edit_post_link(); ?>

<?php get_links_list(); ?>

<?php comments_template(); ?>

<?php wp_list_pages(); ?>

<?php wp_list_cats(); ?>

<?php next_post_link(' %link ') ?>

<?php previous_post_link('%link') ?>

<?php get_calendar(); ?>

<?php wp_get_archives() ?>

<?php posts_nav_link(); ?>

<?php bloginfo(’description’); ?>

<?php wp_head(); ?>  

<?php wp_footer(); ?>	

<?php bloginfo('stylesheet_directory'); ?>	

<?php bloginfo('home'); ?>	
		
<?php bloginfo('name'); ?>	
		
<?php bloginfo('stylesheet_url'); ?>
			
<?php get_template_part('part_name'); ?>			

<?php get_search_form(); ?>				

<?php get_header(); ?>			

<?php get_sidebar(); ?>			

<?php get_footer(); ?>			

<?php the_author(); ?> 			

<?php the_title(); ?> 			

<?php the_permalink();?>			

<?php the_time('M d, Y') ?> 			

<?php the_excerpt(); ?> 			

<?php the_category(', '); ?>			

<?php the_tags('',','); ?>					

<?php the_post_thumbnail('ID_Name', array('class' => 'Class_Name')); ?>		//thepostthumbnail

<?php comments_number( 'No Comment', '1 Comment', '% Comments');  ?>    //Eunus Vaiya

<?php comments_popup_link('No Comment', '1 Comment', '% Comments');	?>//Rasel Vaiya    

<?php comments_template( '', true ); ?>			

<?php post_class(); ?>			

<?php include ("file_name"); ?>	


/*This code for post information*/
					<?php if(have_posts()) : ?>
					<?php while (have_posts()) : the_post(); ?>        

						<div class="single_post">
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<div class="post_info">
								Posted In: <?php the_category(', '); ?> | Posted on: <?php the_time('M d, Y') ?> <?php comments_popup_link('No Comment', '1 Comment', '% Comments'); ?>
							</div>
							<div class="post_content">
								<?php the_content(); ?>
							</div>
						</div>

					<?php endwhile; ?>    
					<?php endif; ?>


					
					
/* Adding Latest jQuery from Wordpress use it functions php */
function td_latest_jquery() {
	wp_enqueue_script('jquery');
}
add_action('init', 'td_latest_jquery');		


Note: You must be change $ and replace jQuery 


/*This cde for portfolio page creation ude it portfolio page.php */
	<?php
	global $post;
	$args = array( 'posts_per_page' => -1, 'post_type'=> 'portfolio' );
	$myposts = get_posts( $args );
	foreach( $myposts as $post ) : setup_postdata($post); ?>
	
		<div class="single_portfolio floatleft">
			<?php the_post_thumbnail('portfolio-image', array('class' => 'portfolio_img_c')); ?>
			<div class="hover_text">
				<a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/portfolio_more.png" alt="" /></a>
				<h2><?php the_title(); ?></h2>
			</div>
		</div>
		
	<?php endforeach; ?>

	
/*This code for portfolio use it in functions.php */	
	add_action( 'init', 'create_post_type' );
	function create_post_type() {
		register_post_type( 'portfolio',
			array(
				'labels' => array(
					'name' => __( 'Portfolio Items' ),
					'singular_name' => __( 'Portfolio' ),
					'add_new' => __( 'Add New' ),
					'add_new_item' => __( 'Add New Portfolio' ),
					'edit_item' => __( 'Edit Portfolio' ),
					'new_item' => __( 'New Portfolio' ),
					'view_item' => __( 'View Portfolio' ),
					'not_found' => __( 'Sorry, we couldn\'t find the Portfolio you are looking for.' )
				),
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => true,
			'menu_position' => 14,
			'has_archive' => true,
			'hierarchical' => true,
			'capability_type' => 'page',
			'rewrite' => array( 'slug' => 'portfolio' ),
			'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields' )
			)
		);
		
		register_post_type( 'reviews',
			array(
				'labels' => array(
					'name' => __( 'Reviews' ),
					'singular_name' => __( 'Review' ),
					'add_new' => __( 'Add New' ),
					'add_new_item' => __( 'Add New Review' ),
					'edit_item' => __( 'Edit Review' ),
					'new_item' => __( 'New Review' ),
					'view_item' => __( 'View Review' ),
					'not_found' => __( 'Sorry, we couldn\'t find the Review you are looking for.' )
				),
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => true,
			'menu_position' => 14,
			'has_archive' => true,
			'hierarchical' => true,
			'capability_type' => 'page',
			'rewrite' => array( 'slug' => 'review' ),
			'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields'  )
			)
		);		
	}

/*This code for portfolio use in functions.php*/
	add_image_size( 'portfolio-image', 640, 440, true );
	add_image_size( 'author-image', 150, 150, true );




/*This code for conditional query-post use it in post-loop php */
	<?php $image = get_post_meta($post->ID, 'url', true); if($image) : ?>
	<p style="background:red;color:#fff;padding:10px"><?php echo $image; ?></p>
	<?php endif; ?>

/*This code for query post for another page to get another image*/
<?php $image = get_post_meta($post->ID, 'url', true);
if($image) : ?>
<img src="<?php echo $image; ?>" alt="" />
<?php endif; ?>

/*Note: you will add custom field id is url and meta box use */

<?php $job_link= get_post_meta($spot->ID, 'job_link', true); ?>

<?php if($job_link) : ?>
	<a href="<?php echo $job_link; ?>" class="job_pdf "></a>
<?php endif; ?>

	

<h4><?php $key="contact"; echo get_post_meta($post->ID, $key, true); ?></h4>



/*This code for woocmmerce support*/
add_theme_support( 'woocommerce' );



							<?php
							global $post;
							$args = array( 'posts_per_page' => 3, 'post_type'=> 'post', 'category' => 'Featured');
							$myposts = get_posts( $args );
							foreach( $myposts as $post ) : setup_postdata($post); ?>
							
							<?php 
								$post_thumb= get_post_meta($post->ID, 'post_thumb', true);
								$post_description= get_post_meta($post->ID, 'post_description', true);
							?>
							
							
							<div class="single_blogpost">
								<div class="blogpost_thumb">
									<img src="<?php echo $post_thumb; ?>" alt="" />
								</div>
								
								<div class="right_blogpost_content">
									<h3><?php the_title(); ?></h3>
									<div class="post_detail_fix">
										<?php echo $post_description; ?>
									</div>
									<a href="<?php the_permalink(); ?>" class="read_more">Read More</a>
								</div>
							</div>							
							
							 
							<?php endforeach; ?>	






	///// Rubel vai News multipost


	<?php $count=1; $query = new WP_Query('showposts=9&category_name=News24&offset=0'); if ($query->have_posts()) : ?>
	<?php while ($query->have_posts()) : $query->the_post(); ?> 
	<?php if($count==1){ ?> 


	<?php } if($count>1){ ?>
		<ul>
			<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
		</ul>
		<?php } if($count==9){ ?>
	<?php } ?> <?php $count++; endwhile; else: endif; wp_reset_postdata(); ?>
                            
							
	
	
	
	





	
							



	
?>
