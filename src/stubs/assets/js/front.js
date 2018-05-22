window.Vue = require('vue');

require('../utilities/bootstrap');

/** Application */
import store            from "./store"

/** Pages */
import home             from "./pages/home/home"

/* Application */
const app = new Vue({
    el: '#front',

    data: {
        store,
    },

    created(){
        this.store.initState(window.location.href)
    },

    mounted(){},

    methods: {}
});
