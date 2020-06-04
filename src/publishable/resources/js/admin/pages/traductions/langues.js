import Vue            from 'vue'
import langue from './langue.vue'

import store  from './TraductionsStore'

export default Vue.component('langues', {
	props: ['tab'],

	components: {langue},

	data(){
		return{
			langues: [],
			store
		}
	},

	created(){
		Event.listen('tabSelected', this.fetchData)
		// Event.listen('setData', this.setData)
	},

	methods : {
		// /**
		//  * Charge la liste des langues
		//  *
		//  * @param   data
		//  * @return  void
		//  */
		// setData(data){
		// 	if(this.store.state.currentTab==this.tab){
		// 		this.langues = data
		// 	}
		// },

		/**
		 * Charge la liste des zones
		 *
		 * @return  void
		 */
		fetchData()
		{
			if(this.store.state.currentTab==this.tab){
				axios.get(`/admin/langues`).then(({data}) => {
					this.langues = data
				})
			}
		}
	}
});
