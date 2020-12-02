function generateTheme(color) {
    let colors = {}

    colors[50] = `var(--color-${color}-50)`

    for (i=100; i<=900; i+=100){
      colors[i] = `var(--color-${color}-${i})`
    }

    return colors
}

const colors = require('tailwindcss/colors')

module.exports = {
    theme: {
        colors: {
            'blue-gray' : colors.blueGray,
            'cool-gray' : colors.coolGray,
            'gray' : colors.gray,
            'true-gray' : colors.trueGray,
            'warm-gray' : colors.warmGray,
            'red' : colors.red,
            'orange' : colors.orange,
            'amber' : colors.amber,
            'yellow' : colors.yellow,
            'lime' : colors.lime,
            'green' : colors.green,
            'emerald' : colors.emerald,
            'teal' : colors.teal,
            'cyan' : colors.cyan,
            'light-blue' : colors.lightBlue,
            'blue' : colors.blue,
            'indigo' : colors.indigo,
            'violet' : colors.violet,
            'purple' : colors.purple,
            'fuchsia' : colors.fuchsia,
            'pink' : colors.pink,
            'rose' : colors.rose
        },

        screens: {
            'sm': '576px',
            'md': '768px',
            'lg': '1024px',
            'xl': '1200px',
            '2xl': '1366px',
        },

        extend: {
            colors: {
                transparent: 'transparent',

                black: 'var(--color-black)',
                white: 'var(--color-white)',
                disabled: "var(--color-disabled)",

                'primary': "var(--color-primary)",
                'primary-dark': 'var(--color-primary-dark)',
                'primary-light': "var(--color-primary-light)",

                info: "var(--color-info)",
                'info-accent': "var(--color-info-accent)",

                success: "var(--color-success)",
                'success-accent': "var(--color-success-accent)",

                warning: "var(--color-warning)",
                'warning-accent': "var(--color-warning-accent)",

                danger: "var(--color-danger)",
                'danger-accent': "var(--color-danger-accent)"
            }
        },
    },
    variants: {},
    plugins: [],
}
