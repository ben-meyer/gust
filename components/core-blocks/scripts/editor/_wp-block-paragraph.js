/**
 * Register block styles for core/paragraph block.
 */
wp.domReady(() => {
    wp.blocks.registerBlockStyle('core/paragraph', {
        name: 'type-small',
        label: 'Small',
    });

    wp.blocks.registerBlockStyle('core/paragraph', {
        name: 'type-regular',
        label: 'Regular',
        isDefault: true,
    });

    wp.blocks.registerBlockStyle('core/paragraph', {
        name: 'type-large',
        label: 'Large',
    });

    wp.blocks.unregisterBlockStyle('core/paragraph', 'default');
});
