import Swiper from 'swiper';
import { Navigation, Keyboard, Mousewheel, FreeMode } from 'swiper/modules';

class Gallery {
	constructor(element) {
		this.element = element;
		if (this.element.dataset.galleryInitialized === 'true') {
			return;
		}

		const swiperEl = this.element.querySelector('.gallery__swiper');
		if (!swiperEl) return;

		this.swiper = new Swiper(swiperEl, {
			modules: [Navigation, Keyboard, Mousewheel, FreeMode],
			slidesPerView: 'auto',
			spaceBetween: 24,
			speed: 500,
			grabCursor: true,
			freeMode: {
				enabled: true,
				momentum: true,
			},
			keyboard: {
				enabled: true,
				onlyInViewport: true,
			},
			mousewheel: {
				enabled: true,
				forceToAxis: true,
			},
			navigation: {
				nextEl: this.element.querySelector('.gallery__next'),
				prevEl: this.element.querySelector('.gallery__prev'),
			},
			breakpoints: {
				768: {
					spaceBetween: 32,
				},
				1024: {
					spaceBetween: 48,
				},
				1440: {
					spaceBetween: 48,
				},
			},
		});

		this.element.dataset.galleryInitialized = 'true';
	}
}

function initGalleries(root = document) {
	root.querySelectorAll('sq-gallery').forEach((element) => {
		new Gallery(element);
	});
}

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', () => initGalleries(), { once: true });
} else {
	initGalleries();
}
