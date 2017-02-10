// Agency Theme JavaScript
function createCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }

    document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
};

function readCookie(name) {
    var nameEQ = encodeURIComponent(name) + "=";
    var ca = document.cookie.split(";");
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === " ") c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) {
            return decodeURIComponent(c.substring(nameEQ.length, c.length));
        }
    }
    return null;
}

function deleteCookie(name) {
    this.createCookie(name, "", -1);
}

function showCookieConsent() {
    var usrCc = readCookie("usr_cc");
    if (!usrCc) {
        $(".cookie-consent").slideDown("slow");
    }
}

/*function cookieTest() {
 console.log('Testing terms set');
 }*/

(function ($) {
    "use strict"; // Start of use strict

    // jQuery for page scrolling feature - requires jQuery Easing plugin
    $('a.page-scroll').bind('click', function (event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: ($($anchor.attr('href')).offset().top - 50)
        }, 1250, 'easeInOutExpo');
        event.preventDefault();
    });

    // Highlight the top nav as scrolling occurs
    $('body').scrollspy({
        target: '.navbar-fixed-top',
        offset: 100
    });

    // Closes the Responsive Menu on Menu Item Click
    $('.navbar-collapse ul li a').click(function () {
        $('.navbar-toggle:visible').click();
    });

    // Offset for Main Navigation
    $('#mainNav').affix({
        offset: {
            top: 100
        }
    })

    if (window.location.href.indexOf("wr") > -1) {
        $("#viewport-spy").show();
        $("#viewport-spy").html(window.innerWidth + "x" + window.innerHeight);
    }


    $(".carousel-control").click(function () {
        var slide = parseInt($(this).attr("data-slide"));
        var current_slide = 0;
        if ((slide - 1) === 0) {
            current_slide = 5;
        } else {
            current_slide = slide - 1;
        }
        console.log(current_slide);
        console.log(slide);
        $("#galleryModal" + current_slide).hide();
        $("#galleryModal" + slide).show();

    });

    showCookieConsent();

    $(".cc-btn").click(function () {
        var ccVal;
        if ($(this).hasClass("cc-btn-positive")) {
            ccVal = "1";
        } else {
            ccVal = "0";
        }
        createCookie("usr_cc", ccVal, 4745);
        $(".cookie-consent").slideUp("fast");
    });

})(jQuery); // End of use strict

//Credits : http://devblog.lastrose.com/html5-audio-video-playlist/
$(window).load(function () {
    var audio;
    var playlist;
    var tracks;
    var current;
    init();

    function init() {
        current = 0;
        audio = $('audio');
        playlist = $('#playlist');
        tracks = playlist.find('li a');
        len = tracks.length - 1;
        audio[0].volume = .10;
        playlist.find('a').click(function (e) {
            e.preventDefault();
            link = $(this);
            current = link.parent().index();
            run(link, audio[0]);
        });
        audio[0].addEventListener('ended', function (e) {
            current++;
            if (current == len) {
                current = 0;
                link = playlist.find('a')[0];
            } else {
                link = playlist.find('a')[current];
            }
            run($(link), audio[0]);
        });
    }

    function run(link, player) {
        player.src = link.attr('href');
        par = link.parent();
        par
            .addClass('active')
            .siblings().removeClass('active');
        audio[0].load();
        audio[0].play();
    }
});