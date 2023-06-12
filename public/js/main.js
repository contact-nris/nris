(function($) {
    var $main_window = $(window);
    $main_window.on("load", function() {
        $("#preloader").fadeOut("slow");
    });
    $main_window.on("scroll", function() {
        if ($(this).scrollTop() > 250) {
            $(".back-to-top").fadeIn(200);
        } else {
            $(".back-to-top").fadeOut(200);
        }
    });
    $(".back-to-top").on("click", function() {
        $("html, body").animate({
            scrollTop: 0
        }, "slow");
        return false;
    });
    // $('.mobile-menu').slicknav({
    //     prependTo: '.navbar-header',
    //     parentTag: 'liner',
    //     allowParentLinks: true,
    //     duplicate: true,
    //     label: '',
    //     closedSymbol: '<i class="lni-chevron-right"></i>',
    //     openedSymbol: '<i class="lni-chevron-down"></i>',
    // });
    $main_window.on('scroll', function() {
        var scroll = $(window).scrollTop();
        if (scroll >= 10) {
            $(".scrolling-navbar").addClass("top-nav-collapse");
        } else {
            $(".scrolling-navbar").removeClass("top-nav-collapse");
        }
    });
    /*if ($(".counter").length > 0) {
        $(".counterUp").counterUp({
            delay: 10,
            time: 2000
        });
    }*/
    var wow = new WOW({
        mobile: false
    });
    wow.init();
    $('[data-toggle="tooltip"]').tooltip()
    var testiOwl = $("#testimonials");
    testiOwl.owlCarousel({
        autoplay: true,
        margin: 30,
        dots: false,
        autoplayHoverPause: true,
        nav: false,
        loop: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            991: {
                items: 2
            }
        }
    });
    var newproducts = $("#new-products");
    newproducts.owlCarousel({
        autoplay: true,
        nav: true,
        autoplayHoverPause: true,
        smartSpeed: 350,
        dots: false,
        margin: 30,
        loop: true,
        navText: ['<i class="lni-chevron-left"></i>', '<i class="lni-chevron-right"></i>'],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            575: {
                items: 2,
            },
            991: {
                items: 3,
            }
        }
    });
    var realestate = $("#realestate");
    realestate.owlCarousel({
      items: 1,
      autoplay: true,
      nav: true,
      autoplayHoverPause: true,
      smartSpeed: 350,
      dots: false,
      margin: 30,
      loop: false,
      navText: [
        '<i class="lni-chevron-left"></i>',
        '<i class="lni-chevron-right"></i>',
      ],
      responsiveClass: true,
    });
    var other_ad = $("#other_ad");
    other_ad.owlCarousel({
      items: 1,
      autoplay: true,
      nav: true,
      autoplayHoverPause: true,
      smartSpeed: 350,
      dots: false,
      margin: 30,
      loop: false,
      navText: [
        '<i class="lni-chevron-left"></i>',
        '<i class="lni-chevron-right"></i>',
      ],
      responsiveClass: true,
    });
    var desidate = $("#desidate");
    desidate.owlCarousel({
      items: 1,
      autoplay: true,
      nav: true,
      autoplayHoverPause: true,
      smartSpeed: 350,
      dots: false,
      margin: 30,
      loop: false,
      navText: [
        '<i class="lni-chevron-left"></i>',
        '<i class="lni-chevron-right"></i>',
      ],
      responsiveClass: true,
    });
    var categoriesslider = $("#ad-icon-slider");
    categoriesslider.owlCarousel({
        autoplay: true,
        nav: false,
        autoplayHoverPause: true,
        smartSpeed: 350,
        dots: false,
        margin: 30,
        loop: true,
        navText: ['<i class="lni-chevron-left"></i>', '<i class="lni-chevron-right"></i>'],
        responsiveClass: true,
        autoWidth:true,
        /*responsive: {
            0: {
                items: 1,
            },
            575: {
                items: 2,
            },
            991: {
                items: 5,
            }
        }*/
    });
    var detailsslider = $("#owl-demo");
    detailsslider.owlCarousel({
        autoplay: true,
        nav: false,
        autoplayHoverPause: true,
        smartSpeed: 350,
        dots: true,
        margin: 30,
        loop: true,
        navText: ['<i class="lni-chevron-left"></i>', '<i class="lni-chevron-right"></i>'],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            575: {
                items: 1,
            },
            991: {
                items: 1,
            }
        }
    });
    var detailsslider = $("#babysitting");
    detailsslider.owlCarousel({
        autoplay: true,
        nav: false,
        autoplayHoverPause: true,
        smartSpeed: 350,
        dots: true,
        margin: 30,
        loop: false,
        navText: ['<i class="lni-chevron-left"></i>', '<i class="lni-chevron-right"></i>'],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            575: {
                items: 1,
            },
            991: {
                items: 1,
            }
        }
    });
    var detailsslider = $("#blog_carousal");
    detailsslider.owlCarousel({
        items: 3,
        autoplay: true,
        nav: false,
        autoplayHoverPause: true,
        smartSpeed: 350,
        dots: true,
        margin: 30,
        loop: false,
        navText: ['<i class="lni-chevron-left"></i>', '<i class="lni-chevron-right"></i>'],
        responsiveClass: true,
        responsive: {
             0: {
                items: 1,
            },
            575: {
                items: 2,
            },
            991: {
                items: 3,
            },
            1200: {
                items: 4,
            }
        }
    });
    var detailsslider = $("#video_carousal");
    detailsslider.owlCarousel({
        items: 3,
        autoplay: true,
        nav: false,
        autoplayHoverPause: true,
        smartSpeed: 350,
        dots: true,
        margin: 30,
        loop: false,
        navText: ['<i class="lni-chevron-left"></i>', '<i class="lni-chevron-right"></i>'],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            575: {
                items: 2,
            },
            991: {
                items: 3,
            },
            1200: {
                items: 4,
            }
        }
    });

    
}
)(jQuery);

function filterFunction() {
    var input, filter, ul, li, a, i;
    filter = $("#stateinput").val().toLowerCase();
    a = $("#dropdown-state a");
    for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toLowerCase().indexOf(filter) > -1) {
        a[i].style.display = "";
    } else {
        a[i].style.display = "none";
    }
    }
}


// alert('sadf');

// $('a').each(function() {   //add a class to all external links
//     var $a  = jQuery(this);
//     var domainURL = $a.get(0).href;
//     var target = $a.get(0).target;
//     console.log(domainURL);
//       console.log(target);
//     var hostToDetectAsExternal = domainURL.replace('http://','').replace('https://','').replace('www.','').split(/[/?#]/)[0];

//     if(domainURL != 'NULL'  && domainURL.indexOf('javascript') == -1 ) // -1 : Not found in a allowed hosts array & not found javacript in a URL
//     {
//         $a.addClass('external-link');
//     }
// });







