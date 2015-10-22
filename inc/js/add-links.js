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
    inputCount = $( '#jkl-reviews-links' ).children().length;
    inputCount++;
    
    // Next, create the actual input element and return it
    $faElement = 
            $( '<input />' )
            .attr( 'type', 'text' )
            .attr( 'name', 'jkl-reviews-link-' + inputCount + 'icon' )
            .attr( 'id', 'jkl-reviews-link-' + inputCount + 'icon' )
            .attr( 'value', 'fa-' )
            .attr( 'placeholder', 'fa-code' );
    $labelElement = 
            $( '<input />' )
            .attr( 'type', 'text' )
            .attr( 'name', 'jkl-reviews-link-' + inputCount + 'label' )
            .attr( 'id', 'jkl-reviews-link-' + inputCount + 'label' )
            .attr( 'value', 'fa' )
            .attr( 'placeholder', _e( 'Label', 'jkl-reviews' ) );
    $inputElement = 
            $( '<input />' )
            .attr( 'type', 'text' )
            .attr( 'name', 'jkl-reviews-link-' + inputCount )
            .attr( 'id', 'jkl-reviews-link-' + inputCount )
            .attr( 'value', '' )
            .attr( 'placeholder', _e( 'URL', 'jkl-reviews' ) );
    
    return $faElement.add( $labelElement.add( $inputElement ) );
    
} // END createInputElement($)

( function( $ ) {
    'use strict';
    
    $( function() {
        
        var $inputElement;
        
        $( '#jkl-reviews-add-link' ).on( 'click', function( e ) {
            
            e.preventDefault();
            
            /**
             * Create a new input element that will be used to capture the 
             * user input and append it to the container just above this button.
             */
            $( '#jkl-reviews-links' ).append( createInputElement( $ ) );
            
        }); // END click function
        
    }); // END main function
    
}) ( jQuery );

