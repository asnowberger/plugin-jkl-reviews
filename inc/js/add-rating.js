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
function createRatingElement( $, type ) {
    
    var $divElement, 
        $divRangeElement, 
        $labelElement, 
        $sliderElement, 
        $sliderDataElement,
        $datalistElement, 
        $finalElement,
        $rangeElement,
        $dataValueElement, 
        $feedbackElement, 
        $removeElement, 
        $descElement, 
        ratingCount;
    
    /*
     * First, count the number of input fields that already exist.
     * This is how we set the name and ID attributes of the element. 
     */
    ratingCount = $( '#jkl-review-rating-scales' ).children( 'li' ).length;
    ratingCount++;
    
    $( '#jkl-rating-add-alert' ).addClass( 'hidden' );
    
    // Next, create ALL the rest of the necessary elements
    // #1: Create the <li> housing for the rest of the ratings
    $divElement = $( '<li></li>' )
            .attr( 'id', 'jkl-reviews-rating-' + ratingCount + '-container' )
            .attr( 'class', 'sortable' );
    
    // #2: Create the Label <input>
    $labelElement = 
            $( '<input />' )
            .attr( 'type', 'text' )
            .attr( 'name', 'jkl-reviews-rating-' + ratingCount + '-label' )
            .attr( 'id', 'jkl-reviews-rating-' + ratingCount + '-label' )
            .attr( 'class', 'jkl-reviews-rating-label' )
            .attr( 'value', '' )
            .attr( 'placeholder', 'Label' );
    
    // #3: Create the Description <input>
    $descElement = 
            $( '<input />' )
            .attr( 'type', 'text' )
            .attr( 'name', 'jkl-reviews-rating-' + ratingCount + '-desc' )
            .attr( 'id', 'jkl-reviews-rating-' + ratingCount + '-desc' )
            .attr( 'class', 'jkl-reviews-rating-desc' )
            .attr( 'value', '' )
            .attr( 'placeholder', 'Description (optional short clarification of the rating)' );
    
    // #4: Create the REMOVE X
    $removeElement =
            $( '<input />')
            .attr( 'type', 'submit' )
            .attr( 'id', '' )
            .attr( 'class', 'jkl-reviews-remove-link button' )
            .attr( 'value', 'x' );
    
    // #5: Create the slider <div> housing
    $divRangeElement = $( '<div></div>' )
            .attr( 'id', 'jkl-rating-scale-' + ratingCount ) // change foreach
            .attr( 'class', 'jkl-range' );

    // #6: Create the ACTUAL jQuery Slider
    $sliderElement = $( '<div></div>' )
            .attr( 'class', 'jkl-range-slider' );
    
    $sliderDataElement = $( '<div></div>' )
            .attr( 'class', 'jkl-range-slider-data' );
    
    $dataValueElement = $( '<p class="jkl-rating-value"><input type="text" id="rating-value-' + ratingCount + '" readonly><label for="rating-value"> Stars</label></p>');
    
    // #7: Create a unique range slider DATA depending on the Rating Scale type desired (passed in)
//            if ( type == "star" ) {
//                $sliderElement = 
//                        $( '<div></div>' )
//                        .attr( 'id', 'jkl-reviews-rating-scale-' + ratingCount )
//                        .attr( 'class', 'jkl-star-slider jkl-range-slider' );
//                $rangeNumLeft = $( '<span class="range-number-left">0 Stars</span>' );
//                $rangeNumRight = $( '<span class="range-number-right">5 Stars</span>' );
//            } 
//
//            else if ( type === "bar" ) {
//                $sliderElement = 
//                    $( '<div></div>' )
//                    .attr( 'id', 'jkl-reviews-rating-scale-' + ratingCount )
//                    .attr( 'class', 'jkl-bar-slider jkl-range-slider' );
//                $rangeNumLeft = $( '<span class="range-number-left">0 Bars</span>' );
//                $rangeNumRight = $( '<span class="range-number-right">10 Bars</span>' );
//            } 
//
//            else if ( type === "percent" ) {
//                $sliderElement = 
//                    $( '<div></div>' )
//                    .attr( 'id', 'jkl-reviews-rating-scale-' + ratingCount )
//                    .attr( 'class', 'jkl-percent-slider jkl-range-slider' );
//                $rangeNumLeft = $( '<span class="range-number-left">0%</span>' );
//                $rangeNumRight = $( '<span class="range-number-right">100%</span>' );
//            }
    
    
    
    $rangeElement = $( '<div></div>' ).append( $sliderDataElement.append( $dataValueElement ).add( $( '<div style="width: 80%; float: right;"></div>' ).append( $sliderElement ) ) );
    $finalElement = $labelElement.add( $descElement.add( $removeElement ) );
    
    return $divElement.append( $finalElement.add( $rangeElement ) );
    
} // END createRatingElement($,type)

function displayDisclosure( $, type ) {
    
    $( '#jkl-review-disclosure-preview' ).removeClass( 'hidden' );
    
    switch( type ) {
        case 'none'         :
            return 'No';
            break;
        case 'affiliate'    :
            
            break;
        case 'sample'       :
            
            break;
        case 'sponsored'    :
            
            break;
        case 'shareholder'  :
            
            break;
        default: // this takes care of the 'remove' case as well
            $( '#jkl-review-disclosure-preview' ).addClass( 'hidden' );
            return;
    }
    
} // END createDisclosePreview($)
