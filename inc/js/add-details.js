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
function createDetailElement( $ ) {
    
    var $listElement, $inputElement, $removeElement, listCount;
    
    /*
     * First, count the number of input fields that already exist.
     * This is how we set the name and ID attributes of the element. 
     */
    listCount = $( this ).next( '.jkl-review-detail-info' ).children().length;
    listCount++;
    
    // Next, create the actual input element and return it
    $listElement = 
            $( '<li></li>' )
            .attr( 'class', 'sortable' );
    $inputElement =
            $( '<input />' )
            .attr( 'type', 'text' )
            .attr( 'name', 'jkl-review-detail-label-' + listCount )
            .attr( 'id', 'jkl-review-detail' )
            .attr( 'class', 'jkl-review-detail' )
            .attr( 'placeholder', 'Detail' )
            .attr( 'value', '' );
    $removeElement = 
            $( '<input />' )
            .attr( 'type', 'submit' )
            .attr( 'name', 'jkl-review-detail-' + listCount + '-remove' )
            .attr( 'id', 'jkl-review-remove-detail' )
            .attr( 'class', 'jkl-reviews-remove-detail button' )
            .attr( 'value', 'x' )
    
    return $listElement.append( $inputElement.add( $removeElement ) );
    
} // END createInputElement($)






/**
 * The Actual jQuery function that handles all the button clicks on the Details Tab
 * 
 * @since   2.0.1
 * 
 * @param   jQuery  $
 * @returns void
 */
( function( $ ) {
    'use strict';
    
    $( function() {
        
        /**
         * Add Date Picker functionality to the Date area in the Info Section of the Meta box
         */
        $( '.input-date' ).datepicker({
            dateFormat : 'yy-mm-dd'
        });
        
        $('#jkl-detail-list-sizing').on("change", function() {
            $('.output').val(this.value + "% Left / " + (100-this.value) + "% Right" );
        }).trigger("change");
        
        /**
         * 
         */
        $( '#jkl-reviews-add-details' ).on( 'click', function( e ) {
            $( '#jkl-review-details' ).removeClass( 'hidden' );
            $( this ).addClass( 'hidden' );
        });
        
        /**
         * Button functionality to add items to the Detail Lists
         */
        $( '.jkl-reviews-add-item' ).on( 'click', function( e ) {
            
            e.preventDefault();
            
            /**
             * Create a new input element that will be used to capture the 
             * user input and append it to the container just above this button.
             */
            $( this ).next().append( createDetailElement( $ ) );
            
        }); // END click function
        
        
        /**
         * Button functionality to ADD items to the Links Section of the Meta box
         */
        $( '#jkl-reviews-add-link' ).on( 'click', function( e ) {
            
            e.preventDefault();
            
            /**
             * Create a new input element that will be used to capture the 
             * user input and append it to the container just above this button.
             */
            $( '#jkl-reviews-links' ).append( createLinkElement( $ ) );
            
        }); // END #jkl-reviews-add-link click function
        
        /**
         * Button functionality to REMOVE items from the Links Section
         */
        $( '#jkl-reviews-remove-detail' ).on( 'click', function( e ) {
            
            e.preventDefault();
            
               $( this ).parents('li').remove();
               
        });
        
    }); // END main function
    
}) ( jQuery );

