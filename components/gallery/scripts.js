import Swiper from 'swiper';
import { Navigation, Keyboard, Mousewheel, FreeMode } from 'swiper/modules';

class SqGallery extends HTMLElement {
	connectedCallback() {
		const swiperEl = this.querySelector('.gallery__swiper');
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
				nextEl: this.querySelector('.gallery__next'),
				prevEl: this.querySelector('.gallery__prev'),
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
	}

	disconnectedCallback() {
		this.swiper?.destroy();
	}
}

customElements.define('sq-gallery', SqGallery);
