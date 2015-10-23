/**
 * Callback function for the 'click' event of the 'Add Cover Image' anchor in the meta box.
 * 
 * Displays the media uploader for selecting an image.
 * 
 * @since       2.0.1
 * 
 * @package     JKL_Reviews
 * @subpackage  JKL_Reviews/inc/js
 * @author      Aaron Snowberger <jekkilekki@gmail.com>
 * 
 * @param       object  $   A reference to the jQuery object.
 * @returns     html        HTML to be included in the meta box.
 * 
 * @link        http://code.tutsplus.com/tutorials/getting-started-with-the-wordpress-media-uploader--cms-22011
 */

function renderMediaUploader( $ ) {
    'use strict';
    
    var file_frame, image_data;
    
    /**
     * If an instance of file_frame already exists, then open it - don't create a new one.
     * 
     * @param {type} $
     * @returns {undefined}
     */
    if ( undefined !== file_frame ) {
        
        file_frame.open();
        return;
        
    }
    
    /**
     * If we're here, then there's no instance, so create one.
     * 
     * Use the wp.media library to define the settings of the Uploader. Opt to use 
     * the 'post' frame which is a template defined in the WP core and initialize 
     * the file_frame with the 'insert' state.
     * 
     * Also, do NOT allow the user to select more than one image.
     * 
     * @param {type} $
     * @returns {undefined}
     */
    file_frame = wp.media.frames.file_frame = wp.media({
        frame:      'post',
        state:      'insert', 
        multiple:   false
    });
    
    /** 
     * Setup an event handler for what to do after selecting an image.
     * 
     * Since we use the 'view' state when initializing the file_frame, make sure
     * the handler is attached to the insert event.
     * 
     * @param {type} $
     * @returns {undefined}
     */
    file_frame.on( 'insert', function() {
       
        // Read the JSON data returned from the Media Uploader
        json = file_frame.state().get( 'selection' ).first().toJSON();
        
        // First, make sure that we have the URL of an image to display
        if ( 0 > $.trim( json.url.length ) ) {
            return;
        }
        
        // After that, set the properties of the image and display it
        $( '#jkl-cover-preview' )
            .children( 'img' )
                .attr( 'src', json.url )
                .attr( 'alt', json.caption )
                .attr( 'title', json.title )
                        .show()
            .parent()
            .removeClass( 'hidden' );
    
        // Next, hide the anchor responsible for allowing the user to select
        
    });
    
    // Now display the actual file_frame
    file_frame.open();
}

( function( $ ) {
    'use strict';
    
    $( function() {
       
        $( '#jkl-review-cover-button' ).on( 'click', function( e ) {
           
            // Stop the default behavior
            e.preventDefault();
            
            // Display the media uploader
            renderMediaUploader( $ );
            
        });
        
    });
    
//    $(document).ready( function( $ ) {
//        var jkl_cover_image = true,
//        _orig_send_attachment = wp.media.editor.send.attachment;
//        
//        $( '#jkl-review-cover-button' ).on( 'click', function( e ) {
//            
//            e.preventDefault();
//            
//            var send_attachment_bkp = wp.media.editor.send.attachment;
//            var button = $(this);
//            var id = button.attr('id').replace( '_button', '');
//            jkl_cover_image = true;
//            
//            wp.media.editor.send.attachment = function( props, attachment ) {
//                if ( jkl_cover_image ) {
//                    $("#"+id).val(attachment.url);
//                } else {
//                    return _orig_send_attachment.apply( this, [props, attachment] );
//                };
//            }
//            
//            wp.media.editor.open(button);
//            return false;
//            
//            
//        });
//        
//        $( '#jkl-review-cover-button' ).on('click', function() {
//                jkl_cover_image = false;
//        });
//        
//    });
    
}) ( jQuery );