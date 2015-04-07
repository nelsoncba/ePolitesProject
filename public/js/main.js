$(document).ready(function(){
        $('#summernote').summernote({
            height: 300,                 // set editor height

              minHeight: null,             // set minimum height of editor
              maxHeight: null,             // set maximum height of editor

              focus: true,   
        });
    });
//valida si supera 100px para mostrar icono de scroll top.
$(function(){
	$(document).on( 'scroll', function(){
 
		if ($(window).scrollTop() > 100) {
			$('.scroll-top-wrapper').addClass('show');
		} else {
			$('.scroll-top-wrapper').removeClass('show');
		}
	});
});