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
            .attr( 'id', 'jkl-review-remove-item' )
            .attr( 'class', 'jkl-reviews-remove-item button' )
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
         * ADD Detail Lists items
         */        
        $( '.jkl-reviews-add-item' ).live( 'click', function() {
            
            /**
             * Create a new input element that will be used to capture the 
             * user input and append it to the container just above this button.
             */
            $( this ).next().append( createDetailElement( $ ) );
            
        }); // END live function
        
        /**
         * REMOVE Detail List items
         * 
         * @link    http://jsfiddle.net/jaredwilli/tzpg4/4/
         */
        $( '.jkl-reviews-remove-item' ).live( 'click', function() {
            $( this ).parents( 'li' ).remove();
        });
        
        
        /**
         * ADD Link items
         */        
        $( '#jkl-reviews-add-link' ).on( 'click', function( e ) {
            
            e.preventDefault();
            /**
             * Create a new input element that will be used to capture the 
             * user input and append it to the container just above this button.
             */
            $( '#jkl-reviews-links' ).append( createLinkElement( $ ) );
            
        }); // END live function
        
        /**
         * REMOVE Link items
         * 
         * @link    http://jsfiddle.net/jaredwilli/tzpg4/4/
         */
        $( '.jkl-reviews-remove-link' ).live( 'click', function() {
            $( this ).parents( 'li' ).remove();
            
            if( $( '#jkl-reviews-links' ).children( 'li' ).length < 1 ) {
                $( '#jkl-reviews-link-header' ).addClass( 'hidden' );
            }
        });
        
        
        /**
         * ADD Rating items
         */        
        $( '#jkl-reviews-add-rating' ).live( 'click', function( e ) {
            
            e.preventDefault();
            /**
             * Create a new input element that will be used to capture the 
             * user input and append it to the container just above this button.
             */
            var ratingType;
            ratingType = $( 'input[name=jkl-rating-radio]:checked', '#jkl-review-rating-type' ).val();
            if ( !ratingType ) {
                $( '#jkl-rating-add-alert' ).removeClass( 'hidden' );
            } else {
                $( '#jkl-review-rating-scales' ).append( createRatingElement( $, ratingType ) );
            }
            
        }); // END live function
        
        /**
         * REMOVE Rating items
         * 
         * @link    http://jsfiddle.net/jaredwilli/tzpg4/4/
         */
        $( '.jkl-reviews-remove-rating' ).live( 'click', function() {
            $( this ).parents( 'li' ).remove();
        });
        
        /**
         * Disclosure selector
         */
        $( 'input[name=jkl-disclose]:radio' ).change( function() {
            var $disclosureType = $(this).val();
            
            $( '#jkl-review-disclosure-preview' ).append( displayDisclosure( $, $disclosureType ) );
            
        });
        
    }); // END main function
    
}) ( jQuery );

