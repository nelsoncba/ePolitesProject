$(window).scroll(function(){
    if (window.scrollY !== 0) {
        $('nav.navbar-fixed-top').addClass('transparent');
    }else{
        $('nav.navbar-fixed-top').removeClass('transparent');
    }
    
});
$('#nav').mouseenter(function(){
    $('#nav.navbar-fixed-top').removeClass('transparent');
});
$('#nav').mouseleave(function(){
	if($(window).scrollTop() !== 0)
       $('#nav.navbar-fixed-top').addClass('transparent');  
});