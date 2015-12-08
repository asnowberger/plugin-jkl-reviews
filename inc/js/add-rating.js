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
    
    var ratingCount,
        $liElement,
        $divElement,
        $labelElement,
        $descElement,
        $removeElement,
        $divRangeElement,
        $paragraphElement,
        $sliderBoxElement,
        $sliderElement,
        $layerOne,
        $layerTwo;
    
    /*
     * First, count the number of input fields that already exist.
     * This is how we set the name and ID attributes of the element. 
     */
    ratingCount = $( '#jkl-review-rating-scales' ).children( 'li' ).length;
    ratingCount++;
    
    $( '#jkl-rating-add-alert' ).addClass( 'hidden' );
    
    // Next, create ALL the rest of the necessary elements
    // #1: Create the <li> housing for the rest of the ratings
    $liElement = $( '<li></li>' )
            .attr( 'id', 'jkl-reviews-rating-' + ratingCount + '-container' )
            .attr( 'class', 'sortable group' );
    
    // #2: Create the <div> element(s) for each "layer" of the Rating Scale
    $divElement = $( '<div></div>' )
            .attr( 'id', 'jkl-rating-labels-' + ratingCount )
            .attr( 'class', 'jkl-rating-label-box' ); // change foreach
    
    /**
     * LAYER ONE (Label, Description, Remove X)
     */
            // #2.1: Create the Label <input>
            $labelElement = 
                    $( '<input />' )
                    .attr( 'type', 'text' )
                    .attr( 'name', 'jkl-reviews-rating-' + ratingCount + '-label' )
                    .attr( 'id', 'jkl-reviews-rating-' + ratingCount + '-label' )
                    .attr( 'class', 'jkl-reviews-rating-label' )
                    .attr( 'value', '' )
                    .attr( 'placeholder', 'Label' );

            // #2.2: Create the Description <input>
            $descElement = 
                    $( '<input />' )
                    .attr( 'type', 'text' )
                    .attr( 'name', 'jkl-reviews-rating-' + ratingCount + '-desc' )
                    .attr( 'id', 'jkl-reviews-rating-' + ratingCount + '-desc' )
                    .attr( 'class', 'jkl-reviews-rating-desc' )
                    .attr( 'value', '' )
                    .attr( 'placeholder', 'Description (optional short clarification of the rating)' );

            // #2.3: Create the REMOVE X
            $removeElement =
                    $( '<input />')
                    .attr( 'type', 'submit' )
                    .attr( 'id', '' )
                    .attr( 'class', 'jkl-reviews-remove-link button' )
                    .attr( 'value', 'x' );
            
    /**
     * LAYER TWO (
     */
    
    // #3: Create the slider <div> housing
    $divRangeElement = $( '<div></div>' )
            .attr( 'id', 'jkl-rating-scale-' + ratingCount ) // change foreach
            .attr( 'class', 'jkl-range' );
                
            // #3.1: Create the paragraph element to show the Rating Value
            $paragraphElement = $( '<p class="jkl-rating-value"><input type="text" id="rating-value" class="rating-value" readonly><label for="rating-value"> Stars</label></p>' );

            // #3.2: Create the jQuery Slider BOX
            $sliderBoxElement = $( '<div></div>' )
                    .attr( 'class', 'jkl-range-slider-box' );
    
            // #3.3: Create the ACTUAL jQuery Slider
            $sliderElement = $( '<div></div>' )
                    .attr( 'class', 'jkl-star-slider' );

    /**
     * Put together the entire jQuery element
     */
    $layerOne = $divElement.append( $labelElement, $descElement, $removeElement );
    $layerTwo = $divRangeElement.append( $paragraphElement, $sliderBoxElement.append( $sliderElement ) );
    
    return $liElement.append( $layerOne, $layerTwo );
    
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
