<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' ); ?>
<?php get_template_part( 'header', 'heading' );
$content_padding = get_post_meta(get_the_ID(),'product-ctpadding',true);
$woo_layout = get_post_meta(get_the_ID(),'product-sidebar',true);
if(function_exists('ot_get_option') && $woo_layout==''){
	$woo_layout =  ot_get_option('woocommerce_layout','right');
} 
?>  
<div class="container">
    <?php if($content_padding!='off'){ ?>
    <div class="content-pad-3x">
    <?php }?>
	<div class="row">
			<?php
                /**
                 * woocommerce_before_main_content hook
                 *
                 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
                 * @hooked woocommerce_breadcrumb - 20
                 */
                //do_action( 'woocommerce_before_main_content' );
            ?>
            <div id="content" class="<?php echo $woo_layout!='full'?'col-md-9':'col-md-12' ?><?php echo ($woo_layout == 'left') ? " revert-layout":"";?>">
            <?php while ( have_posts() ) : the_post(); ?>
    
                <?php wc_get_template_part( 'content', 'single-product' ); ?>
    
            <?php endwhile; // end of the loop. ?>
            </div>
            <?php
                /**
                 * woocommerce_after_main_content hook
                 *
                 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                 */
               // do_action( 'woocommerce_after_main_content' );
            ?>
            <?php
                /**
                 * woocommerce_sidebar hook
                 *
                 * @hooked woocommerce_get_sidebar - 10
                 */
                if($woo_layout != 'full'){ do_action( 'woocommerce_sidebar' );}
            ?>
	</div>
     <?php if($content_padding!='off'){ ?>
     </div><!--/content-pad-3x-->
     <?php }?>
</div>
<?php get_footer( 'shop' ); ?>