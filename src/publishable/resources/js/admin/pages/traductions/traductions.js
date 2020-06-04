import Vue from 'vue'
import traductionsStore from './TraductionsStore'

import traductionsContent from './traductions_content'
import langues            from './langues'
import zones              from './zones'

Vue.component('traductions',{
    props: ['data'],

    data() {
        return {
            traductionsStore
        }
    }
})
