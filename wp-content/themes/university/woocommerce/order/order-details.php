<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$order = wc_get_order( $order_id );
$show_details_order = ot_get_option('show_details_order');
$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
?>
<h2 class="woocommerce-order-details__title"><?php _e( 'Order Details', 'woocommerce' ); ?></h2>
<table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
	<thead>
		<tr>
			<th class="woocommerce-table__product-name product-name"><span><?php _e( 'Product', 'woocommerce' ); ?></span></th>
			<th class="woocommerce-table__product-table product-total"><span><?php _e( 'Total', 'woocommerce' ); ?></span></th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach( $order->get_items() as $item_id => $item ) {
				$product = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );
				$purchase_note = get_post_meta( $product->id, '_purchase_note', true );

				wc_get_template( 'order/order-details-item.php', array(
					'order'					=> $order,
					'item_id'				=> $item_id,
					'item'					=> $item,
					'show_purchase_note'	=> $show_purchase_note,
					'purchase_note'			=> $purchase_note,
					'product'				=> $product,
				) );
				if($show_details_order == 'on'){
					$product_id   = $product->id; echo $product_id;
					echo '<style type="text/css">
					.event-cpurse-if,.product-event-course{ border-top:0 !important}
					.event-cpurse-if h2{ margin-top:0}
					</style>';
					ct_details_event_course($product_id, $data_if ='checkout');
				}
			}
		?>
		<?php
        
				
		do_action( 'woocommerce_order_items_table', $order );
		?>
	</tbody>
    <tfoot>
		<?php
			foreach ( $order->get_order_item_totals() as $key => $total ) {
				?>
				<tr>
					<th scope="row"><?php echo $total['label']; ?></th>
					<td><?php echo $total['value']; ?></td>
				</tr>
				<?php
			}
		?>
	</tfoot>
</table>

<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>

<?php if ( $show_customer_details ) : ?>
	<?php wc_get_template( 'order/order-details-customer.php', array( 'order' =>  $order ) ); ?>
<?php endif; ?>
