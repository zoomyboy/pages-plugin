module.exports = {
    corePlugins: {
        preflight: false
    },
    theme: {
        extend: {
            width: {
                'sidebar': '280px'
            },
            colors: {
                'section': 'hsla(211, 96%, 43%, 1)',
                'row': 'hsl(352, 88%, 64%)',
                'module': 'hsl(200, 0%, 100%)'
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
