/**
 * Listens for which product type is chosen and loads the appropriate input 
 * fields for each type
 * 
 * @since       2.0.1
 * 
 * @package     JKL_Reviews
 * @subpackage  JKL_Reviews/inc/js
 * @author      Aaron Snowberger <jekkilekki@gmail.com>
 * 
 * @param       object  $   A reference to the jQuery object.
 * @returns     html        HTML to be included in the meta box.
 */

( function( $ ) {
    'use strict';
    
    $( function() {
        
        $( '#jkl-reviews-types a' ).on( 'click', function( e ) {
            
            e.preventDefault();
            
            $( '.jkl-review-helper' ).addClass( 'hidden' );
            $( '#jkl-review-rating' ).removeClass( 'hidden' );
            
            var target = $( this ).attr( "id" );

            switch( target ) {
                case 'book-type':
                    $( '.jkl-review' ).addClass( 'hidden' );
                    $( '#jkl-reviews-types a' ).removeClass( 'active' );
                    $( '.book-info' ).toggleClass( 'hidden' );
                    $( '.book-type' ).addClass( 'active' );
                    break;
                case 'audio-type':
                    $( '.jkl-review' ).addClass( 'hidden' );
                    $( '#jkl-reviews-types a' ).removeClass( 'active' );
                    $( '.audio-info' ).toggleClass( 'hidden' );
                    $( '.audio-type' ).addClass( 'active' );
                    break;
                case 'video-type':
                    $( '.jkl-review' ).addClass( 'hidden' );
                    $( '#jkl-reviews-types a' ).removeClass( 'active' );
                    $( '.video-info' ).toggleClass( 'hidden' );
                    $( '.video-type' ).addClass( 'active' );
                    break;
                case 'course-type':
                    $( '.jkl-review' ).addClass( 'hidden' );
                    $( '#jkl-reviews-types a' ).removeClass( 'active' );
                    $( '.course-info' ).toggleClass( 'hidden' );
                    $( '.course-type' ).addClass( 'active' );
                    break;
                case 'product-type':
                    $( '.jkl-review' ).addClass( 'hidden' );
                    $( '#jkl-reviews-types a' ).removeClass( 'active' );
                    $( '.product-info' ).toggleClass( 'hidden' );
                    $( '.product-type' ).addClass( 'active' );
                    break;
                case 'service-type':
                    $( '.jkl-review' ).addClass( 'hidden' );
                    $( '#jkl-reviews-types a' ).removeClass( 'active' );
                    $( '.service-info' ).toggleClass( 'hidden' );
                    $( '.service-type' ).addClass( 'active' );
                    break;
                case 'travel-type':
                    $( '.jkl-review' ).addClass( 'hidden' );
                    $( '#jkl-reviews-types a' ).removeClass( 'active' );
                    $( '.travel-info' ).toggleClass( 'hidden' );
                    $( '.travel-type' ).addClass( 'active' );
                    break;
                default:
                    $( '.jkl-review' ).addClass( 'hidden' );
                    $( '#jkl-reviews-types a' ).removeClass( 'active' );
                    $( '.other-info' ).toggleClass( 'hidden' );
                    $( '.other-type' ).addClass( 'active' );
            }
            
        }); // END click function
        
    }); // END main function
    
}) ( jQuery );

