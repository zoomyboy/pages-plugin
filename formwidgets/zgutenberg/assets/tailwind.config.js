
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
            },
        },
        fontSize: {
            xs: '0.75rem',
            sm: '0.875rem',
            base: '1.6rem',
            lg: '1.8',
            xl: '1.2',
            '2xl': '2.4rem',
            '3xl': '3rem',
            '4xl': '3.6rem',
            '5xl': '4.8rem',
            '6xl': '6.4rem',
        },
        spacing: {
            'px': '1px',
            '0': '0',
            '1': '0.4rem',
            '2': '0.8rem',
            '3': '1.2rem',
            '4': '1.6rem',
            '5': '2.0rem',
            '6': '2.4rem',
            '8': '3.2rem',
            '10': '4rem',
            '12': '4.8rem',
            '16': '6.4rem',
            '20': '8rem',
            '24': '9.6rem',
            '32': '12.8rem',
            '40': '16rem',
            '48': '19.2rem',
            '56': '22.4rem',
            '64': '25.6rem'
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
