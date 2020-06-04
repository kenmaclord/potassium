import Vue    			from 'vue'

import zone   			from './zone.vue'
import modal     		from '../../app/modal.vue'
import addSection   	from '../../app/addSection.vue'
import store  			from './TraductionsStore'

export default Vue.component('zones', {
	props: ['tab'],

	components: {zone, modal, addSection},

	data(){
		return{
			zones: [],
			store
		}
	},

	created(){
		Event.listen('tabSelected', this.fetchData)
		Event.listen('addCompleted', this.fetchData)
		Event.listen('modal_validate', this.deleteZone)
	},

	methods : {
		/**
		 * Charge ou rafraîchit la liste des zones
		 *
		 * @return  void
		 */
		fetchData()
		{
			if(this.store.state.currentTab == this.tab){
				axios.get(`/admin/zones`).then(({data}) => {
					this.zones = data
					this.store.setAllZones(this.zones)

					Event.fire('refreshSelectItemsList')
				})
			}
		},

		/**
		 * Supprime une zone
		 *
		 * @param   Json  zone
		 *
		 * @return  void
		 */
		deleteZone(zone){
			if(zone.context=="zones"){
				axios.delete(`/admin/zones/${zone.element.id}`).then(({data}) => {
					this.fetchData()
					notify(data)
				})
			}
		}
	}
});
