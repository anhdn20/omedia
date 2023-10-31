!function($) {
	$(document).ready(function() {
		$('.rwmb-video.haru-select2').each(function() {
			$(this).select2({
				allowClear: false
			});
		});

		/**
		 * Turn select field into beautiful dropdown with select2 library
		 * This function is called when document ready and when clone button is clicked (to update the new cloned field)
		 *
		 * @return void
		 */
		function update() {
			setTimeout(function(){
				// $('.rwmb-video.haru-select2').select2('destroy'); 
				$('.rwmb-video.haru-select2').each(function() {
					$('.rwmb-video.haru-select2').select2({
						allowClear: false
					});
				});
			}, 200);
		}

		// $( '.rwmb-video.haru-select2' ).each( update );
		// $( '.rwmb-input' ).on( 'clone', '.rwmb-videos', update );

		// If use clone need re run select2() - fix many options: http://stackoverflow.com/questions/15041058/select2-performance-for-large-set-of-items
		$('.rwmb-button.add-clone').on('click', function(e){
			e.preventDefault();
			$('.rwmb-videos').children('select.haru-select2').select2('destroy').end(console.log('Cloned'));

			setTimeout(function(){
				$('select.rwmb-video.haru-select2').each(function() {
					$('select.rwmb-video.haru-select2').select2({
						placeholder: "Select video",
						allowClear: false
					});
				});
			}, 10);
		})
	});
}(jQuery);