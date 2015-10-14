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
    inputCount = $( '#jkl-review-details' ).children().length;
    inputCount++;
    
    // Next, create the actual input element and return it
    $inputLabel = 
            $( '<input />' )
            .attr( 'type', 'text' )
            .attr( 'name', 'jkl-review-detail-label-' + inputCount )
            .attr( 'id', 'jkl-review-detail-label-' + inputCount )
            .attr( 'class', 'jkl-review-detail-label' )
            .attr( 'placeholder', 'Label' )
            .attr( 'value', '' );
    $inputDetail = 
            $( '<input />' )
            .attr( 'type', 'text' )
            .attr( 'name', 'jkl-review-detail-info-' + inputCount )
            .attr( 'id', 'jkl-review-detail-info-' + inputCount )
            .attr( 'class', 'jkl-review-detail-info' )
            .attr( 'placeholder', 'Information' )
            .attr( 'value', '' );
    
    return $inputLabel.add( $inputDetail );
    
} // END createInputElement($)

( function( $ ) {
    'use strict';
    
    $( function() {
        
        var $inputElement;
        
        $( '#jkl-reviews-add-detail' ).on( 'click', function( e ) {
            
            e.preventDefault();
            
            /**
             * Create a new input element that will be used to capture the 
             * user input and append it to the container just above this button.
             */
            $( '#jkl-review-details' ).append( createInputElement( $ ) );
            
        }); // END click function
        
    }); // END main function
    
}) ( jQuery );

