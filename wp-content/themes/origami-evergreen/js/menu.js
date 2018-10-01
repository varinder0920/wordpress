jQuery(function($){
    $('#main-menu-wrapper > div > ul > li').has('ul')
        .mouseenter(function(){
            $(this).find('> ul').show().hide().slideDown('fast');
        })
        .mouseleave(function(){
            $(this).find('> ul').slideUp('fast');
        }).find('> a').append('<span class="dropdown-icon"></span>');

    $('#main-menu-wrapper > div > ul > li ul li').has('ul')
        .mouseenter(function(){
            $(this).find('> ul').show().hide().fadeIn('fast');
        })
        .mouseleave(function(){
            $(this).find('> ul').fadeOut('fast');
        });
});