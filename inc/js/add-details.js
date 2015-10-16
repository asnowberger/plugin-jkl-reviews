/**
 * Creates a new input element to add files be enqueued in the webpage
 * and added to either the head (CSS) or body (JS) of the site.
 * 
 * @since       2.0.1
 * 
 * @package     JKL_Reviews
 * @subpackage  JKL_Reviews/inc/js
 * @author      Aaron Snowberger <jekkilekki@gmail.com>
 * 
 * @param       object  $   A reference to the jQuery object.
 * @returns     object      A file to be enqueued in the webpage.
 */
function createInputElement( $ ) {
    
    var $inputElement, inputCount;
    
    /*
     * First, count the number of input fields that already exist.
     * This is how we set the name and ID attributes of the element. 
     */
    inputCount = $( this ).prev( '.jkl-review-detail-info' ).children().length;
    
    if ( inputCount > 0 ) {
        $( this ).next().removeClass( 'hidden' );
    }
    
    inputCount++;
    
    // Next, create the actual input element and return it
    $inputDetail = 
            $( '<input />' )
            .attr( 'type', 'text' )
            .attr( 'name', 'jkl-review-detail-label-' + inputCount )
            .attr( 'id', 'jkl-review-detail-label-' + inputCount )
            .attr( 'class', 'jkl-review-detail-label' )
            .attr( 'placeholder', 'Detail' )
            .attr( 'value', '' );
    
    return $inputDetail;
    
} // END createInputElement($)

( function( $ ) {
    'use strict';
    
    $( function() {
        
        /**
         * 
         */
        $( '#jkl-reviews-add-details' ).on( 'click', function( e ) {
            $( '#jkl-review-details' ).removeClass( 'hidden' );
            $( this ).addClass( 'hidden' );
        });
        
        $( '.jkl-reviews-add-item' ).on( 'click', function( e ) {
            
            e.preventDefault();
            
            /**
             * Create a new input element that will be used to capture the 
             * user input and append it to the container just above this button.
             */
            $( this ).prev().append( createInputElement( $ ) );
            
        }); // END click function
        
    }); // END main function
    
}) ( jQuery );

