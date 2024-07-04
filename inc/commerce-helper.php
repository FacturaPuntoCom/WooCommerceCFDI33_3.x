<?php

class CommerceHelper{

    static function getOrderById($orderId){
        // $order = new WC_Order($orderId);
        $order = wc_get_order($orderId);
        // var_dump($order->get_items());
        if(!$order){
            return array('Error' => 'El pedido no existe');
        }
        $order_post = get_post( $orderId );
        $configEntity = FacturaConfig::configEntity();

        $decimals = get_option('woocommerce_price_num_decimals');

        if(in_array($decimals, ['1','2','3','4','5','6'])){
          $decimals = intval($decimals);
        } else if ($decimals > 6){
          $decimals = 6;
        } else {
          $decimals = 2;
        }
        
        $order_data = array(
          'decimals'                  => $decimals,
          'price_with_tax'            => $configEntity['sitax'],
          'id'                        => $order->id,
          'order_number'              => $order->get_order_number(),
          'created_at'                => $order_post->post_date_gmt,
          'updated_at'                => $order_post->post_modified_gmt,
          'completed_at'              => $order->completed_date,
          'status'                    => $order->get_status(),
          'currency'                  => $order->order_currency,
          'total'                     => wc_format_decimal( $order->get_total(), 2 ),
          'total_line_items_quantity' => $order->get_item_count(),
          'total_tax'                 => wc_format_decimal( $order->get_total_tax(), 2 ),
          'total_shipping'            => wc_format_decimal( $order->get_total_shipping(), 2 ),
          'cart_tax'                  => wc_format_decimal( $order->get_cart_tax(), 2 ),
          'shipping_tax'              => wc_format_decimal( $order->get_shipping_tax(), 2 ),
          'total_discount'            => wc_format_decimal( $order->get_total_discount(), 2 ),
          // 'cart_discount'             => wc_format_decimal( $order->get_cart_discount(), 2 ),
          // 'order_discount'            => wc_format_decimal( $order->get_order_discount(), 2 ),
          'shipping_methods'          => $order->get_shipping_method(),
          'payment_details' => array(
            'method_id'    => $order->payment_method,
            'method_title' => $order->payment_method_title,
            'paid'         => isset( $order->paid_date ),
          ),
          'billing_email' => $order->billing_email,
          'billing_address' => array(
            'first_name' => $order->billing_first_name,
            'last_name'  => $order->billing_last_name,
            'company'    => $order->billing_company,
            'address_1'  => $order->billing_address_1,
            'address_2'  => $order->billing_address_2,
            'city'       => $order->billing_city,
            'state'      => $order->billing_state,
            'postcode'   => $order->billing_postcode,
            'country'    => $order->billing_country,
            'email'      => $order->billing_email,
            'phone'      => $order->billing_phone,
          ),
          'shipping_address' => array(
            'first_name' => $order->shipping_first_name,
            'last_name'  => $order->shipping_last_name,
            'company'    => $order->shipping_company,
            'address_1'  => $order->shipping_address_1,
            'address_2'  => $order->shipping_address_2,
            'city'       => $order->shipping_city,
            'state'      => $order->shipping_state,
            'postcode'   => $order->shipping_postcode,
            'country'    => $order->shipping_country,
          ),
          'note'                      => $order->customer_note,
          'customer_ip'               => $order->customer_ip_address,
          'customer_user_agent'       => $order->customer_user_agent,
          'customer_id'               => $order->customer_user,
          'view_order_url'            => $order->get_view_order_url(),
          'line_items'                => array(),
          'shipping_lines'            => array(),
          'tax_lines'                 => array(),
          'fee_lines'                 => array(),
          'coupon_lines'              => array(),
        );
        // add line items
        foreach( $order->get_items() as $item_id => $item ) {
          $product = $order->get_product_from_item( $item );
          // var_dump($product->get_tax_class());
          // var_dump("Including ".woocommerce_price($product->get_price_including_tax()));
          // var_dump("Excluding ".woocommerce_price($product->get_price_excluding_tax()));
          // $at = $product->get_tax_status();
          // var_dump($at);
          // $F_ClaveProdServ = $product->get_attribute( 'F_ClaveProdServ' );
          // $F_Unidad = $product->get_attribute( 'F_Unidad' );
          // $F_ClaveUnidad = $product->get_attribute( 'F_ClaveUnidad' );
          // var_dump($F_ClaveProdServ, $F_Unidad, $F_ClaveUnidad);
          if( $product->is_type( 'variation' ) )
          {
            $product = wc_get_product($product->get_parent_id());
          }
          $order_data['line_items'][] = array(
            'id'         => $item_id,
            'subtotal'   => wc_format_decimal( $order->get_line_subtotal( $item ), $decimals),
            'total'      => wc_format_decimal( $order->get_line_total( $item ), $decimals),
            'total_tax'  => wc_format_decimal( $order->get_item_tax( $item ), $decimals),
            'price'      => wc_format_decimal( $order->get_item_total( $item ), $decimals ) + wc_format_decimal( $order->get_item_tax( $item ), $decimals ),
            'meta'       => array(
              'item_total' => wc_format_decimal( $order->get_item_total( $item ), $decimals ),
              'line_tax'   => wc_format_decimal( $order->get_line_tax( $item ), $decimals ),
              'item_tax'   => wc_format_decimal( $order->get_item_tax( $item ), $decimals ),
            ),
            //'quantity'   => (int) $item['qty'], Problemas con cantidades decimales (a granel, ejemplo: 0.25)
            'quantity'   => $item['qty'],
            'tax_class'  => ( ! empty( $item['tax_class'] ) ) ? $item['tax_class'] : null,
            'name'       => $item['name'],
            'product_id' => ( isset( $product->variation_id ) ) ? $product->variation_id : $product->id,
            'sku'        => is_object( $product ) ? $product->get_sku() : null,
            'F_ClaveProdServ'        => $product->get_attribute( 'F_ClaveProdServ' ),
            'F_Unidad'        => $product->get_attribute( 'F_Unidad' ),
            'F_ClaveUnidad'        => $product->get_attribute( 'F_ClaveUnidad' ),
            'F_IVA'        => $product->get_attribute( 'F_IVA' ),
            'F_ISR'      => $product->get_attribute( 'F_ISR' ),
            'price'   => wc_format_decimal($item['cost'], 2),
            'type_tax' => $product->get_tax_status(),
          );
          if($product->get_tax_status() == 'shipping' || $product->get_tax_status() == 'taxable'){$onlyship = "shipping";}
          else{$onlyship = "none";}
        }

        // add shipping as a product
        foreach($order->get_items('shipping') as $shipping_key => $shipping_item){

            if($shipping_item['method_id'] != 'free_shipping'){
                $order_data['line_items'][] = array(
                    'id'         => $shipping_key,
                    'subtotal'   => wc_format_decimal($shipping_item['cost'], $decimals),
                    'total'      => wc_format_decimal($shipping_item['cost'], $decimals),
                    'total_tax'  => round($order->order_shipping_tax, $decimals),
                    'price'      => wc_format_decimal($shipping_item['cost'], $decimals) + round($order->order_shipping_tax, $decimals),
                    'quantity'   => 1,
                    'tax_class'  => null,
                    'name'       => $shipping_item['name'],
                    'product_id' =>$shipping_key,
                    'sku'        => $shipping_item['method_id'],
                    'F_ClaveProdServ'  => "78102203",
                    'F_Unidad'  => "Envío",
                    'F_ClaveUnidad' => "SX",
                    'type_tax' => $onlyship,
                );
            }


        }


        return (object)$order_data;
    }

}
