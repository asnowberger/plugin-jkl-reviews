/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * Ref: http://austin.passy.co/2010/creating-custom-metaboxes-and-the-built-in-uploader/
 */

// Check this doc (helpful) : http://code.tutsplus.com/articles/how-to-integrate-the-wordpress-media-uploader-in-theme-and-plugin-options--wp-26052

jQuery(document).ready(function($) {

        // save the send_to_editor handler function
        window.send_to_editor_default = window.send_to_editor;

        $('#jkl_review_cover_button').click(function(){

                // replace the default send_to_editor handler function with our own
                window.send_to_editor = window.attach_image;
                
                // THE code that makes the image chooser "Thickbox" pop up.
                // tb_show ('name_of_window', $url(that handles and validates files), imageGroup
                // $url (referer(optional), post_id, type, TB_iframe(always TRUE or no frame and no window) 
                tb_show('Upload a Cover', 'media-upload.php?post_id=<?php echo $post->ID ?>&amp;type=image&amp;TB_iframe=true', false);

                return false;
        });
        
        window.send_to_editor = function(html) {
            var image_url = $('img',html).attr('src');
            $('#jkl_review_cover').val(image_url);
            tb_remove();
        }

        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: jkl_review_cover.title,
            button: { text: jkl_review_cover.button },
            library: { type: 'image' }
        });
			
        $('#remove-book-image').click(function() {

                $('#upload_image_id').val('');
                $('img').attr('src', '');
                $(this).hide();

                return false;
        });

        // handler function which is invoked after the user selects an image from the gallery popup.
        // this function displays the image and sets the id so it can be persisted to the post meta
        window.attach_image = function(html) {

                // turn the returned image html into a hidden image element so we can easily pull the relevant attributes we need
                $('body').append('<div id="temp_image">' + html + '</div>');

                var img = $('#temp_image').find('img');

                imgurl   = img.attr('src');
                imgclass = img.attr('class');
                imgid    = parseInt(imgclass.replace(/\D/g, ''), 10);

                $('#upload_image_id').val(imgid);
                $('#remove-book-image').show();

                $('img#book_image').attr('src', imgurl);
                try{tb_remove();}catch(e){};
                $('#temp_image').remove();

                // restore the send_to_editor handler function
                window.send_to_editor = window.send_to_editor_default;

        };

});
