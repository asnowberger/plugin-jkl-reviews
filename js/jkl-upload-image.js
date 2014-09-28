/* 
 * Attaches the image uploader to the input field
 */

/*
 * Checkout this stuff for Image Uploader Help:
 * https://github.com/kharissulistiyo/7K-Image-Uploader-Meta-Box/blob/master/7k-image-uploader-meta-box.php
 * https://github.com/WebDevStudios/Custom-Metaboxes-and-Fields-for-WordPress/blob/master/js/cmb.js
 * http://code.tutsplus.com/tutorials/reusable-custom-meta-boxes-part-1-intro-and-basic-fields--wp-23259
 * http://www.wproots.com/upload-media-in-meta-boxes/
 * http://www.krishnakantsharma.com/image-uploads-on-wordpress-admin-screens-using-jquery-and-new-plupload/#.VCH3sCuSwxt
 */

jQuery(document).ready(function($) {
    
    // Instantiates the variable that holds the media library frame
    var meta_image_frame;
    
    // Runs when the image button is clicked
    $('#jkl_review_cover_button').click(function(e) {
        
        // Prevents the default action from occuring
        e.preventDefault();
        
        // If the frame already exists, re-open it.
        if ( meta_image_frame ) {
            meta_image_frame.open();
            return;
        }
        
        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: jQuery( this ).data( 'jkl_review_cover' ),
            button: { text: jQuery( this ).data( 'jkl_review_cover_button' ) },
            library: { type: 'image' },
            multiple: false // Set to true to allow multiple files to be selected
        });
        
        // Runs when an image is selected
        meta_image_frame.on('select', function() {
            
            // Grabs the attachment selection and creates a JSON representation of the model
            var media_attachment = meta_image_frame.state().get('selection');
            
            media_attachment.map( function( attachment ) {
               attachment = attachment.toJSON();
               
               // Sends the attachment URL to our custom image input field
                $('#jkl_review_cover').val(media_attachment.url);
            });
        });
        
        // Opens the media library frame
        wp.media.editor.open();
    });
});
