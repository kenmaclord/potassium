class Easing{
    // simple linear tweening - no easing, no acceleration
    linear(t, b, c, d) {
        return c*t/d + b;
    };


    // quadratic easing in - accelerating from zero velocity
    easeInQuad(t, b, c, d) {
        t /= d;
        return c*t*t + b;
    };


    // quadratic easing out - decelerating to zero velocity
    easeOutQuad(t, b, c, d) {
        t /= d;
        return -c * t*(t-2) + b;
    };


    // quadratic easing in/out - acceleration until halfway, then deceleration
    easeInOutQuad(t, b, c, d) {
        t /= d/2;
        if (t < 1) return c/2*t*t + b;
        t--;
        return -c/2 * (t*(t-2) - 1) + b;
    };


    // cubic easing in - accelerating from zero velocity
    easeInCubic(t, b, c, d) {
        t /= d;
        return c*t*t*t + b;
    };



    // cubic easing out - decelerating to zero velocity
    easeOutCubic(t, b, c, d) {
        t /= d;
        t--;
        return c*(t*t*t + 1) + b;
    };


    // cubic easing in/out - acceleration until halfway, then deceleration
    easeInOutCubic(t, b, c, d) {
        t /= d/2;
        if (t < 1) return c/2*t*t*t + b;
        t -= 2;
        return c/2*(t*t*t + 2) + b;
    };


    // quartic easing in - accelerating from zero velocity
    easeInQuart(t, b, c, d) {
        t /= d;
        return c*t*t*t*t + b;
    };


    // quartic easing out - decelerating to zero velocity
    easeOutQuart(t, b, c, d) {
        t /= d;
        t--;
        return -c * (t*t*t*t - 1) + b;
    };


    // quartic easing in/out - acceleration until halfway, then deceleration
    easeInOutQuart(t, b, c, d) {
        t /= d/2;
        if (t < 1) return c/2*t*t*t*t + b;
        t -= 2;
        return -c/2 * (t*t*t*t - 2) + b;
    };


    // quintic easing in - accelerating from zero velocity
    easeInQuint(t, b, c, d) {
        t /= d;
        return c*t*t*t*t*t + b;
    };


    // quintic easing out - decelerating to zero velocity
    easeOutQuint(t, b, c, d) {
        t /= d;
        t--;
        return c*(t*t*t*t*t + 1) + b;
    };


    // quintic easing in/out - acceleration until halfway, then deceleration
    easeInOutQuint(t, b, c, d) {
        t /= d/2;
        if (t < 1) return c/2*t*t*t*t*t + b;
        t -= 2;
        return c/2*(t*t*t*t*t + 2) + b;
    };


    // sinusoidal easing in - accelerating from zero velocity
    easeInSine(t, b, c, d) {
        return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
    };



    // sinusoidal easing out - decelerating to zero velocity
    easeOutSine(t, b, c, d) {
        return c * Math.sin(t/d * (Math.PI/2)) + b;
    };


    // sinusoidal easing in/out - accelerating until halfway, then decelerating
    easeInOutSine(t, b, c, d) {
        return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
    };


    // exponential easing in - accelerating from zero velocity
    easeInExpo(t, b, c, d) {
        return c * Math.pow( 2, 10 * (t/d - 1) ) + b;
    };


    // exponential easing out - decelerating to zero velocity
    easeOutExpo(t, b, c, d) {
        return c * ( -Math.pow( 2, -10 * t/d ) + 1 ) + b;
    };


    // exponential easing in/out - accelerating until halfway, then decelerating
    easeInOutExpo(t, b, c, d) {
        t /= d/2;
        if (t < 1) return c/2 * Math.pow( 2, 10 * (t - 1) ) + b;
        t--;
        return c/2 * ( -Math.pow( 2, -10 * t) + 2 ) + b;
    };


    // circular easing in - accelerating from zero velocity
    easeInCirc(t, b, c, d) {
        t /= d;
        return -c * (Math.sqrt(1 - t*t) - 1) + b;
    };


    // circular easing out - decelerating to zero velocity
    easeOutCirc(t, b, c, d) {
        t /= d;
        t--;
        return c * Math.sqrt(1 - t*t) + b;
    };


    // circular easing in/out - acceleration until halfway, then deceleration
    easeInOutCirc(t, b, c, d) {
        t /= d/2;
        if (t < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
        t -= 2;
        return c/2 * (Math.sqrt(1 - t*t) + 1) + b;
    };
}

export default new Easing()
