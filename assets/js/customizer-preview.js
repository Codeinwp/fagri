/**
 * Main customize js file
 *
 * @package fagri
 * @since 1.0.0
 */

( function( $ ) {

    /* Team background-image */
    wp.customize(
        'fagri_team_background', function( value ) {
            value.bind(
                function( newval ) {
                    if ( newval.length > 0 ) {
                        $( '.home .fagri-team-wrapper' ).css( { 'background-image' : 'url(' + newval + ')' } );
                    } else {
                        $( '.home .fagri-team-wrapper' ).css( 'background-image', 'none' ).css( 'background-color', '#000000' );
                    }
                }
            );
        }
    );
    /* Testimonials background-image */
    wp.customize(
        'fagri_testimonials_background', function( value ) {
            value.bind(
                function( newval ) {
                    if ( newval.length > 0 ) {
                        $( '.home .fagri-testimonials-wrapper' ).css( { 'background-image' : 'url(' + newval + ')' } );
                    } else {
                        $( '.home .fagri-testimonials-wrapper' ).css( 'background-image', 'none' ).css( 'background-color', '#000000' );
                    }
                }
            );
        }
    );

} )( jQuery );


























