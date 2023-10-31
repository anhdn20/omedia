!function($){
	$(document).ready(function() {
		// Color picker
		$('input.harucolorpicker').wpColorPicker();

		// Uploading files
	    $(document).off("click", "button.haru_upload_image_button");
	    $(document).on('click', 'button.haru_upload_image_button', function (event) {

	        event.preventDefault();
	        event.stopPropagation();
	        var $this = $(this);
	        var haru_file_frame;

	        if (typeof wp !== 'undefined' && wp.media && wp.media.editor) {

	            // If the media frame already exists, reopen it.
	            if (haru_file_frame) {
	                haru_file_frame.open();
	                return;
	            }

	            // Create the media frame.
	            haru_file_frame = wp.media.frames.select_image = wp.media({
	                title    : 'Choose',
	                button   : {
	                    text : 'Use this'
	                },
	                multiple : false,
	            });

	            // When an image is selected, run a callback.
	            haru_file_frame.on('select', function () {
	                var attachment = haru_file_frame.state().get('selection').first().toJSON();

	                if ($.trim(attachment.id) !== '') {
	                    $this.prev().val(attachment.id);
	                    var url = ( typeof(attachment.sizes.thumbnail) == 'undefined' ) ? attachment.sizes.full.url : attachment.sizes.thumbnail.url;
	                    $this.closest('.meta-image-field-wrapper').find('img').attr('src', url);
	                    $this.next().show();
	                }
	                //file_frame.close();
	            });

	            // When open select selected
	            haru_file_frame.on('open', function () {

	                // Grab our attachment selection and construct a JSON representation of the model.
	                var selection = haru_file_frame.state().get('selection');
	                var current = $this.prev().val();
	                var attachment = wp.media.attachment(current);
	                attachment.fetch();
	                selection.add(attachment ? [attachment] : []);
	            });

	            // Finally, open the modal.
	            haru_file_frame.open();
	        }
	    });

	    $(document).on('click', 'button.haru_remove_image_button', function () {

	        var $this = $(this);

	        var placeholder = $this.closest('.meta-image-field-wrapper').find('img').data('placeholder');
	        $this.closest('.meta-image-field-wrapper').find('img').attr('src', placeholder);
	        $this.prev().prev().val('');
	        $this.hide();
	        return false;
	    });

	});
}(jQuery);