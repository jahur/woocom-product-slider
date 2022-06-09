jQuery(document).ready(function( $ ) {
              var owl = $('.owl-carousel');
              owl.owlCarousel({
                margin: 10,
                stagePadding: 10,
                autoHeight: false,
                nav: true,
				dots: false,
				navText: ['<','>'],
                loop: true,
                responsive: {
                  0: {
                    items: 1
                  },
                  600: {
                    items: 3
                  },
                  1000: {
                    items: 5
                  }
                }
              })
            });