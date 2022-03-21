$(document).ready(function() {
    
    $('a[href*=\\#]').bind('click', function(e) {
            e.preventDefault(); // prevent hard jump, the default behavior

            var target = $(this).attr("href"); // Set the target as variable

            // perform animated scrolling by getting top-position of target-element and set it as scroll target
            $('html, body').stop().animate({
                    scrollTop: $(target).offset().top
            }, 600, function() {
                    location.hash = target; //attach the hash (#jumptarget) to the pageurl
            });

            return false;
    });
});

$(window).scroll(function() {
    var scrollDistance = $(window).scrollTop();

    // Assign active class to nav links while scrolling
    // IMPORTANT : j'utilise ici "active2" au lieu de "active" pour éviter un conflit avec les 'dots' du slideshow montrant les packages disponibles (sur cell)
    $('.page-section').each(function(i) {
            if ($(this).position().top <= scrollDistance) {
                    $('.navigation a.active2').removeClass('active2');
                    $('.navigation a').eq(i).addClass('active2');
            }
    });
}).scroll();