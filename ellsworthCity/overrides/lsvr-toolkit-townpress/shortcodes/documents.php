<?php /* 
* Mods
*     23Jun16 add order_alpha param to shortcode.
*     1 july15 - change to choice of ordering
*/
if ( ! lsvr_shortcode_exists( 'lsvr_documents' ) && ! function_exists( 'lsvr_documents_shortcode' ) ) {

    function lsvr_documents_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------

            Output shortcode info for shortcode generator

        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            $shortcode_data = array(
                'lsvr_documents' => array(
                    'name' => __( 'Documents', 'lsvrtoolkit' ),
                    'description' => __( 'Lists documents. You can add documents under <strong>Documents</strong>', 'lsvrtoolkit' ),
                    'paired' => false,
                    'inline' => false,
                    'atts' => array(
                        'title' => array(
                            'label' => __( 'Title', 'lsvrtoolkit' ),
                            'type' => 'text',
							'default' => __( 'Town <strong>Documents</strong>', 'lsvrtoolkit' )
                        ),
						'icon' => array(
                            'label' => __( 'Icon', 'lsvrtoolkit' ),
							'description' => __( 'Name of the icon (e.g. "fa fa-heart"). Please refer to the documentation to learn more about using the icons.', 'lsvrtoolkit' ),
                            'type' => 'text',
							'default' => 'tp tp-papers',
                        ),
                        'number_of_items' => array(
                            'label' => __( 'Number of Documents', 'lsvrtoolkit' ),
                            'type' => 'select',
                            'values' => array( '0' => __( 'All', 'lsvrtoolkit' ), '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10 ),
                            'default' => 'all'
                        ),
                        'show_filesize' => array(
                            'label' => __( 'Show file size', 'lsvrtoolkit' ),
                            'type' => 'select',
                            'values' => array( 'yes' => __( 'Yes', 'lsvrtoolkit' ), 'no' => __( 'No', 'lsvrtoolkit' ) ),
                            'default' => 'yes'
                        ),
                        'show_icons' => array(
                            'label' => __( 'Show document type icons', 'lsvrtoolkit' ),
                            'type' => 'select',
                            'values' => array( 'yes' => __( 'Yes', 'lsvrtoolkit' ), 'no' => __( 'No', 'lsvrtoolkit' ) ),
                            'default' => 'yes'
                        ),
                        'doc_order' => array(
                            'label' => __( 'Ordering', 'lsvrtoolkit' ),
                            'type' => 'select',
                            'values' => array( 'default' => __( 'Default', 'lsvrtoolkit' ), 'alpha' => __( 'Alphabetical', 'lsvrtoolkit' ), 'menu' => __( 'Menu Order', 'lsvrtoolkit' )  ),
                            'default' => 'default'
                        ),
                        'more_btn_label' => array(
                            'label' => __( 'More Button Label', 'lsvrtoolkit' ),
							'description' => __( 'Leave blank to hide More button.', 'lsvrtoolkit' ),
                            'type' => 'text',
                        ),
                        'custom_class' => array(
                            'label' => __( 'Custom Class', 'lsvrtoolkit' ),
                            'description' => __( 'It can be used for applying custom CSS.', 'lsvrtoolkit' ),
                            'type' => 'text'
                        )
                    )
                )
            );

            // CHECK FOR CATEGORIES
            $categories_tax = get_categories( 'taxonomy=lsvrdocumentcat&hide_empty=1&hierarchical=0&parent=0' ) ;

            if ( count( $categories_tax ) > 0 ) {

                $values = array( 'none' => __( 'None', 'lsvrtoolkit' ) );

                foreach ( $categories_tax as $value ) {
                    $values[$value->cat_ID] = $value->name;
                }

                $att_data = array(
                    'label' => __( 'Category', 'lsvrtoolkit' ),
                    'description' => __( 'Category to load documents from. Choose <strong>None</strong> to load documents regardless of category.', 'lsvrtoolkit' ),
                    'type' => 'select',
                    'values' => $values,
                    'default' => 'none'
                );

                $shortcode_atts_arr = $shortcode_data['lsvr_documents']['atts'];
				$shortcode_atts_arr = array( 'category' => $att_data ) + $shortcode_atts_arr;
                $shortcode_data['lsvr_documents']['atts'] = $shortcode_atts_arr;

            }

            return $shortcode_data;

        }

        /* ---------------------------------------------------------------------
            Check if shortcode is inline
        --------------------------------------------------------------------- */

        if ( $check_if_inline === true ) {
            return false;
        }

        /* ---------------------------------------------------------------------
            Prepare arguments
        --------------------------------------------------------------------- */

        $args = shortcode_atts(
            array(
				'category' => 'none',
				'title' => '',
				'icon' => 'tp tp-papers',
				'number_of_items' => 'all',
                'show_filesize' => 'yes',
                'show_icons' => 'yes',
				'more_btn_label' => '',
                'custom_class' => '',
                'doc_order' => '',
            ),
            $atts
        );

		$category = trim( esc_attr( $args['category'] ) );
		$title = $args['title'];
		$icon = esc_attr( $args['icon'] );
        $number_of_items = (int) esc_attr( $args['number_of_items'] );
        $number_of_items = $number_of_items < 1 ? 1000 : $number_of_items;
        $show_filesize = esc_attr( $args['show_filesize'] );
        $show_filesize = $show_filesize === 'yes' ? true : false;
        $show_icons = esc_attr( $args['show_icons'] );
        $show_icons = $show_icons === 'yes' ? true : false;
       // $order_alpha = esc_attr( $args['order_alpha'] );
       // $order_alpha = $order_alpha === 'on' ? true : false;
        $doc_order = esc_attr( $args['doc_order'] );
		$more_btn_label = $args['more_btn_label'];
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

		$class = $custom_class;
        $class .= $icon !== '' ? ' m-has-icon' : '';
		$class = trim( preg_replace( '/\s+/', ' ', $class ) );
		$class = $class !== '' ? ' ' . $class : '';

		$more_btn_link = $category !== 'none' ? get_term_link( intval( $category ), 'lsvrdocumentcat' ) : get_post_type_archive_link( 'lsvrdocument' );

        $output = '<div class="c-documents"><div class="c-content-box"><div class="c-documents-inner">';
        //$output .= '<!-- shortcode:  order alpha parma{'.$args['order_alpha'].'} -->';
        $before_title = $icon !== '' ? '<h3 class="widget-title m-has-ico"><i class="widget-ico ' . $icon . '"></i>' : '<h3 class="widget-title">';

        ob_start();
        the_widget( 'Lsvr_Documents_Widget', array(
            'title' => $title,
            'icoclass' => $icon,
            'category' => $category,
            'limit' => $number_of_items,
            'show_filesize' => $show_filesize,
            'show_icons' => $show_icons,
            'show_all_btn_label' => $more_btn_label,
            'doc_order' => $doc_order,
        ), array(
            'before_widget' => '<div class="widget lsvr-documents"><div class="widget-inner">',
            'after_widget'  => '</div></div>',
            'before_title'  => $before_title,
            'after_title'   => '</h3>'
        ));

        $output .= ob_get_contents();
        ob_end_clean();

        $output .= '</div></div></div>';

		return $output;

    }
    add_shortcode( 'lsvr_documents', 'lsvr_documents_shortcode' );

}
?>