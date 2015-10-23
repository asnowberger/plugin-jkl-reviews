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
    
    var $divElement, $labelElement, $sliderElement, $feedbackElement, $removeElement, $descElement, ratingCount;
    
    /*
     * First, count the number of input fields that already exist.
     * This is how we set the name and ID attributes of the element. 
     */
    ratingCount = $( '#jkl-review-rating-scales' ).children( 'li' ).length;
    ratingCount++;
    
    $( '#jkl-rating-add-alert' ).addClass( 'hidden' );
    
    // Next, create ALL the rest of the elements necessary
    $divElement = $( '<li></li>' )
            .attr( 'id', 'jkl-reviews-rating-' + ratingCount + '-container' )
            .attr( 'class', 'sortable' );
    $labelElement = 
            $( '<input />' )
            .attr( 'type', 'text' )
            .attr( 'name', 'jkl-reviews-rating-' + ratingCount + '-label' )
            .attr( 'id', 'jkl-reviews-rating-' + ratingCount + '-label' )
            .attr( 'class', 'jkl-reviews-rating-label' )
            .attr( 'value', '' )
            .attr( 'placeholder', 'Label' );
    
    // Create a unique range slider depending on the Rating Scale type desired (passed in)
            if ( type == "star" ) {
                $sliderElement = 
                    $( '<input />' )
                    .attr( 'type', 'range' )
                    .attr( 'list', 'rating-scale' )
                    .attr( 'min', '0' )
                    .attr( 'max', '5' )
                    .attr( 'step', '0.5' )
                    .attr( 'name', 'jkl-reviews-rating-scale-' + ratingCount )
                    .attr( 'id', 'jkl-reviews-rating-scale-' + ratingCount )
                    .attr( 'class', 'jkl-reviews-rating-scale' )
                    .attr( 'value', '' );
            } 

            else if ( type === "bar" ) {
                $sliderElement = 
                    $sliderElement = 
                    $( '<input />' )
                    .attr( 'type', 'range' )
                    .attr( 'list', 'rating-scale' )
                    .attr( 'min', '0' )
                    .attr( 'max', '10' )
                    .attr( 'step', '0.5' )
                    .attr( 'name', 'jkl-reviews-rating-scale-' + ratingCount )
                    .attr( 'id', 'jkl-reviews-rating-scale-' + ratingCount )
                    .attr( 'class', 'jkl-reviews-rating-scale' )
                    .attr( 'value', '' );
            } 

            else if ( type === "percent" ) {
                $sliderElement = 
                    $sliderElement = 
                    $( '<input />' )
                    .attr( 'type', 'range' )
                    .attr( 'list', 'rating-scale' )
                    .attr( 'min', '0' )
                    .attr( 'max', '100' )
                    .attr( 'step', '1' )
                    .attr( 'name', 'jkl-reviews-rating-scale-' + ratingCount )
                    .attr( 'id', 'jkl-reviews-rating-scale-' + ratingCount )
                    .attr( 'class', 'jkl-reviews-rating-scale' )
                    .attr( 'value', '' );
            }
    
    $feedbackElement = $( '' );
    $removeElement =
            $( '<input /><br>')
            .attr( 'type', 'submit' )
            .attr( 'id', '' )
            .attr( 'class', 'jkl-reviews-remove-link button' )
            .attr( 'value', 'x' );
    $descElement = 
            $( '<input />' )
            .attr( 'type', 'text' )
            .attr( 'name', 'jkl-reviews-rating-' + ratingCount + '-label' )
            .attr( 'id', 'jkl-reviews-rating-' + ratingCount + '-label' )
            .attr( 'class', 'jkl-reviews-rating-label' )
            .attr( 'value', '' )
            .attr( 'placeholder', 'Description (optional short clarification of the rating)' );
    
    
    return $divElement.append( $labelElement.add( $sliderElement.add( $removeElement.add( $descElement)  ) ) );
    
} // END createInputElement($)
