function generateTheme(color) {
    let colors = {}

    for (i=100; i<=900; i+=100){
      colors[i] = `var(--color-${color}-${i})`
    }

    return colors
}

module.exports = {
    theme: {
        colors: {
            transparent: 'transparent',

            black: 'var(--color-black)',
            white: 'var(--color-white)',
            disabled: "var(--color-disabled)",

            gray: generateTheme('gray'),
            red: generateTheme('red'),
            orange: generateTheme('orange'),
            yellow: generateTheme('yellow'),
            green: generateTheme('green'),
            teal: generateTheme('teal'),
            cyan: generateTheme('cyan'),
            blue: generateTheme('blue'),
            indigo: generateTheme('indigo'),
            purple: generateTheme('purple'),
            pink: generateTheme('pink'),
        },

        screens: {
            'sm': 'var(--screen-sm)',
            'md': 'var(--screen-md)',
            'lg': 'var(--screen-lg)',
            'xl': 'var(--screen-xl)',
            'xxl': 'var(--screen-xxl)',
        },

        extend: {
        },
    },
    variants: {},
    plugins: [],
}
