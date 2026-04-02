<?php
/**
 * Gallery Examples
 *
 * Swiper-powered image carousel.
 * Captions from attachment caption field, credits from 'credit' meta.
 */

use Gust\Components\Gallery;

// Basic usage
echo Gallery::make(
    heading: 'Gallery',
    images: [
        ['image' => ['ID' => 131]],
        ['image' => ['ID' => 132]],
        ['image' => ['ID' => 133]],
        ['image' => ['ID' => 134]],
    ],
);

// Without heading (nav still shows if multiple images)
echo Gallery::make(
    images: [
        ['image' => ['ID' => 126]],
        ['image' => ['ID' => 127]],
        ['image' => ['ID' => 128]],
        ['image' => ['ID' => 129]],
        ['image' => ['ID' => 130]],
    ],
);
