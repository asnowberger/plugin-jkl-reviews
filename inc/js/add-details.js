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
            //.attr( 'class', 'sortable' );
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
            dateFormat : 'yy-mm-dd', 
            changeMonth: true,
            changeYear: true,
        });
        
        /**
         * Make lists sortable using jQuery UI Sortable
         * 
         * 1: Detail Lists = Connected
         * 2. Link Lists = 
         * 3. Rating Lists = 
         */
        $( '#jkl-detail-list-right, #jkl-detail-list-left' ).sortable( {
            connectWith: ".connectedSortable"
        });
        $( '#jkl-reviews-links, #jkl-review-rating-scales' ).sortable();
        
        /**
         * Add jQuery UI Range Slider functionality
         * 
         * @link    https://jqueryui.com/slider/#rangemin
         */
//        $( '.jkl-range-slider' ).slider({
//            range: "min",
//            value: 30,
//            min: 0, 
//            max: 100,
//            step: 10,
//            slide: function( event, ui )  {
//                $( '#left-amt' ).val( ui.value + "%" );
//                $( '#rt-amt' ).val( 100 - ui.value + "%" );
//            }
//        });
//        $( '#left-amt' ).val( $( ".jkl-range-slider" ).slider( "value" ) + "%" );
//        $( '#rt-amt' ).val( 100 - $( ".jkl-range-slider" ).slider( "value" ) + "%" );
        
//        $( '.jkl-star-slider' ).each( function() {
//            // read initial values from markup and remove that
//            var value = parseInt( $( this ).text(), 10 );
//            $( this ).empty().slider({
//                range: "min",
//                value: 0,
//                min: 0,
//                max: 5,
//                step: 0.5,
//                slide: function( event, ui ) {}
//            });
//        });
//        
//        $( '.jkl-bar-slider' ).slider({
//            range: "min",
//            value: 0,
//            min: 0,
//            max: 10,
//            step: 0.5,
//            slide: function( event, ui ) {}
//        });
//        
//        $( '.jkl-percent-slider' ).slider({
//            range: "min",
//            value: 0,
//            min: 0,
//            max: 100,
//            step: 1,
//            slide: function( event, ui ) {}
//        });
        
        
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
                $( 'input[name=jkl-rating-radio]' ).attr( "disabled", true );
                $( '#jkl-reviews-change-rating' ).parent( 'span' ).removeClass( 'hidden' );
            }
            
            
            $( '.jkl-range-slider' ).slider({
                range: "min",
                value: 30,
                min: 0, 
                max: 100,
                step: 10,
                slide: function( event, ui )  {
                    $( '#rating-value' ).val( ui.value + "%" );
                }
            });
            $( '#rating-value' ).val( $( ".jkl-range-slider" ).slider( "value" ) + "%" );
            
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
         * REMOVE ALL Rating items (change rating scale)
         */
        $( '#jkl-reviews-change-rating' ).live( 'click', function( e ) {
            
            e.preventDefault();
            
           $( '#jkl-review-rating-scales' ).children().remove();
           $( this ).parent( 'span' ).addClass( 'hidden' );
           $( 'input[name=jkl-rating-radio]' ).attr( "disabled", false );
        });
        
        /**
         * Disclosure selector
         */
        $( 'input[name=jkl-disclose]:radio' ).change( function( e ) {
            
            e.preventDefault();
            
            var $disclosureType = $(this).val();
            
            $( '.jkl-review-disclosure-preview' ).removeClass( 'hidden' );
            
            switch( $disclosureType ) {
                case 'none' :
                    $( '.disclosure-preview' ).addClass( 'hidden' );
                    $( '#none-disclosure' ).removeClass( 'hidden' );
                    break;
                case 'affiliate' :
                    $( '.disclosure-preview' ).addClass( 'hidden' );
                    $( '#affiliate-disclosure' ).removeClass( 'hidden' );
                    break;
                case 'sample' :
                    $( '.disclosure-preview' ).addClass( 'hidden' );
                    $( '#sample-disclosure' ).removeClass( 'hidden' );
                    break;
                case 'sponsored' :
                    $( '.disclosure-preview' ).addClass( 'hidden' );
                    $( '#sponsored-disclosure' ).removeClass( 'hidden' );
                    break;
                case 'shareholder' :
                    $( '.disclosure-preview' ).addClass( 'hidden' );
                    $( '#shareholder-disclosure' ).removeClass( 'hidden' );
                    break;
                case 'default' :
                    $( '.disclosure-preview' ).addClass( 'hidden' );
                    $( '#default-disclosure' ).removeClass( 'hidden' );
                    break;
                default:
                    $( '.jkl-review-disclosure-preview' ).addClass( 'hidden' );
                    $( '.disclosure-preview' ).addClass( 'hidden' );
            }
            
        });
        
    }); // END main function
    
}) ( jQuery );

