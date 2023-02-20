$(document).ready(function () {
    $('body').addClass('js');

    // Check for Cookies enabled
    var dt = new Date();
    dt.setSeconds(dt.getSeconds() + 60);
    document.cookie = "cookietest=1; expires=" + dt.toGMTString();
    var cookiesEnabled = document.cookie.indexOf("cookietest=") != -1;
    if(!cookiesEnabled){
        alert('Cookies are blocked or not supported by your browser. You must enable cookies to login.');
    }

    var $navToggle = $('.mobile-toggle-nav'),
        $nav = $('#navigation'),
        $newsboardToggle = $('.mobile-toggle-newsboard'),
        $newsboard = $('#newsboard');

    $navToggle.click(function (e) {
        e.preventDefault();
        if ($navToggle.hasClass('mobile-toggle__active')) {
            scrollTo('docs');
            return false;
        } else {
            $navToggle.toggleClass('mobile-toggle__active');
            $newsboardToggle.toggleClass('mobile-toggle__active');
            $nav.toggleClass('active');
            $newsboard.toggleClass('active');
            scrollTo('docs');
        }

        return false;
    });
    $newsboardToggle.click(function (e) {
        e.preventDefault();
        if ($newsboardToggle.hasClass('mobile-toggle__active')) {
            scrollTo('newsboard');
            return false;
        } else {
            $newsboardToggle.toggleClass('mobile-toggle__active');
            $navToggle.toggleClass('mobile-toggle__active');
            $nav.toggleClass('active');
            $newsboard.toggleClass('active');
            scrollTo('newsboard');
        }

        return false;
    });

function scrollTo(hash) {
    location.hash = "#" + hash;
}

    
    $('.iframe-link').magnificPopup({
        type: 'iframe',
        closeOnContentClick: false,
        fixedContentPos: true,
        mainClass: 'condo-modal mfp-fade',
        fixedBgPos: true,
        autoFocusLast: true,
        iframe: {
            markup: '<div class="mfp-iframe-scaler">' +
                '<div class="mfp-close"></div>' +
                '<iframe class="mfp-iframe" frameborder="0" allowfullscreen>            </iframe>' +
                '</div>'
        },
    });

});
