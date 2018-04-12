/**
 * Main customize js file
 *
 * @package fagri
 * @since 1.0.0
 */

( function( $ ) {
    /* === Pricing section === */
    /* Table one icon */
    wp.customize(
        'fagri_pricing_table_one_icon', function( value ) {
            value.bind(
                function( newval ) {
                    $( '.home .hestia-pricing .hestia-table-one .card-pricing .content .fagri-pricing-icon-wrapper i' ).removeClass();
                    $( '.home .hestia-pricing .hestia-table-one .card-pricing .content .fagri-pricing-icon-wrapper i' ).addClass( 'fa' ).addClass( newval );
                }
            );
        }
    );
    /* Table two icon */
    wp.customize(
        'fagri_pricing_table_two_icon', function( value ) {
            value.bind(
                function( newval ) {
                    $( '.home .hestia-pricing .hestia-table-two .card-pricing .content .fagri-pricing-icon-wrapper i' ).removeClass();
                    $( '.home .hestia-pricing .hestia-table-two .card-pricing .content .fagri-pricing-icon-wrapper i' ).addClass( 'fa' ).addClass( newval );
                }
            );
        }
    );
    /* Card one background color */
    wp.customize(
        'accent_color', function( value ) {
            value.bind(
                function( newval ) {
                    /* Testimonials */
                    $( '.home .fagri-testimonials-wrapper .hestia-testimonials .hestia-testimonials-content .card-testimonial .content .card-description::before' ).css( 'color', newval );
                    /* Pricing */
                    $( '.home .hestia-pricing .hestia-table-one .card-pricing' ).css( 'background-color', newval );
                    $( '.home .hestia-pricing .hestia-table-one .card-pricing .content .fagri-pricing-icon-wrapper' ).css( 'color', newval ).css( { 'box-shadow' : '0px 9px 30px -6px ' + newval  } );
                    $( '.home .hestia-pricing .hestia-table-one .card-pricing .content .btn' ).css( 'color', newval );
                    $( '.home .hestia-pricing .card-pricing .content .btn' ).css( { 'box-shadow' : '0px 9px 30px -6px ' + newval  } );
                    $( '.home .hestia-pricing .card-pricing .content .fagri-pricing-icon-wrapper' ).css( 'color', newval ).css( { 'box-shadow' : '0px 9px 30px -6px ' + newval  } );
                }

            );
        }
    );

} )( jQuery );


























