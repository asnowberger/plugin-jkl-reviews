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
function createLinkElement( $ ) {
    
    var $divElement, $faElement, $labelElement, $linkElement, linkCount;
    
    /*
     * First, count the number of input fields that already exist.
     * This is how we set the name and ID attributes of the element. 
     */
    linkCount = $( '#jkl-reviews-links' ).children( 'div' ).length;
    linkCount++;
    
    if ( linkCount >= 1 ) {
        $( '#jkl-reviews-remove-link' ).removeClass( 'hidden' );
        $( '#jkl-reviews-link-header' ).removeClass( 'hidden' );
    }
    
    // Next, create the actual input element and return it
    $divElement = $( '<div/>' )
            .attr( 'id', 'jkl-reviews-link-' + linkCount + '-container' );
    $faElement = 
            $( '<input />' )
            .attr( 'type', 'text' )
            .attr( 'name', 'jkl-reviews-link-' + linkCount + '-icon' )
            .attr( 'id', 'jkl-reviews-link-' + linkCount + '-icon' )
            .attr( 'class', 'jkl-reviews-link-icon' )
            .attr( 'value', 'fa-' )
            .attr( 'placeholder', 'fa-icon' );
    $labelElement = 
            $( '<input />' )
            .attr( 'type', 'text' )
            .attr( 'name', 'jkl-reviews-link-' + linkCount + '-label' )
            .attr( 'id', 'jkl-reviews-link-' + linkCount + '-label' )
            .attr( 'class', 'jkl-reviews-link-label' )
            .attr( 'value', '' )
            .attr( 'placeholder', 'Label' );
    $linkElement = 
            $( '<input />' )
            .attr( 'type', 'url' )
            .attr( 'name', 'jkl-reviews-link-' + linkCount + '-url' )
            .attr( 'id', 'jkl-reviews-link-' + linkCount + '-url' )
            .attr( 'class', 'jkl-reviews-link-url')
            .attr( 'value', '' )
            .attr( 'placeholder', 'URL' );
    
    return $divElement.append( $faElement.add( $labelElement.add( $linkElement ) ) );
    
} // END createInputElement($)

function removeLinkElement( $ ) {
    
    var $linkElement, linkCount;
    
    /*
     * First, count the number of input fields that already exist.
     * This is how we set the name and ID attributes of the element. 
     */
    
    linkCount = $( '#jkl-reviews-links' ).children( 'div' ).length;
    alert( linkCount );
    
    if ( linkCount <= 0 ) {
        $( '#jkl-reviews-remove-link' ).addClass( 'hidden' );
        $( '#jkl-reviews-link-header' ).addClass( 'hidden' );
    } 
    
        $( this ).parent().remove();

    
    linkCount--;
    
} // END removeLinkElement($)