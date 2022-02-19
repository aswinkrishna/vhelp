$('.carousel-main').owlCarousel({
	items: 5,
	loop: true,
	autoplay: true,
	autoplayTimeout: 1500,
	margin: 20,
	nav: true,
	dots: false,
	responsive: {
		0: {
			items: 1
		},
		480: {
			items: 2
		},
		769: {
			items: 5
		}
	},
	navText: ['<span class="fas fa-chevron-left fa-2x arow-btn"><img src="./front_template/images/icons/left.png"/></span>','<span class="fas fa-chevron-right fa-2x arow-btn"><img src="./front_template/images/icons/right.png"/></span>'],
})



$("#owl-example2").owlCarousel({
	items: 4,
	loop: true,
	autoplay: true,
	autoplayTimeout: 1500,
	margin: 10,
	nav: true,
	dots: false,
	responsive: {
		0: {
			items: 3
		},
		480: {
			items:3
		},
		769: {
			items: 4
		}
	},
	navText: ['<span class="fas fa-chevron-left fa-2x arow-btn"><img src="./front_template/images/icons/left.png"/></span>','<span class="fas fa-chevron-right fa-2x arow-btn"><img src="./front_template/images/icons/right.png"/></span>'],
})

$("#owl-example3").owlCarousel({
	items: 4,
	loop: true,
	autoplay: true,
	autoplayTimeout: 1400,
	margin: 10,
	nav: true,
	dots: false,
	responsive: {
		0: {
			items: 3
		},
		480: {
			items: 3
		},
		769: {
			items: 4
		}
	},
	navText: ['<span class="fas fa-chevron-left fa-2x arow-btn"><img src="./front_template/images/icons/left.png"/></span>','<span class="fas fa-chevron-right fa-2x arow-btn"><img src="./front_template/images/icons/right.png"/></span>'],
})









