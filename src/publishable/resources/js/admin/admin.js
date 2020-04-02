window.Vue = require('vue');

import i18n         from "../utilities/i18n"

Vue.mixin(i18n)

require('../utilities/bootstrap');


/* Application */
import notification       from "./app/notification"
import tabs               from "./app/tabs"
import sessionExpiration  from './app/sessionExpiration.vue'

/* Pages */
import dashboard			from './pages/dashboard/dashboard'

import traductions			from './pages/traductions/traductions'

import users				from './pages/users/users'
import user					from './pages/users/user'

//@newJs

const app = new Vue({
	el: '#admin',

		props: ['data'],

		components:{notification, sessionExpiration, tabs},

		data: {
			menuOpen: false,
			sessionExpired: false
		},

		created(){

			Event.listen('sessionExpired', () => {
				this.sessionExpired = true
			})
		}
});
