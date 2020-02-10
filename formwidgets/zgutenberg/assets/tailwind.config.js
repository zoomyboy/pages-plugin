module.exports = {
    corePlugins: {
        preflight: false
    },
    theme: {
        extend: {
            width: {
                'sidebar': '280px'
            }
        },
        inset: {
            'full': '100%'
        }
    },
    variants: {
        visibility: ['responsive', 'hover', 'focus'],
    },
    plugins: [

    ],
    prefix: 'zg-'
}
