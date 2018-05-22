import Vue    			from 'vue'
import sortableMixin    from '../../../utilities/sortable'

import zone   			from './zone.vue'
import modal     		from '../../app/modal.vue'
import addSection   	from '../../app/addSection.vue'
import store  			from './TraductionsStore'

export default Vue.component('zones', {
	props: ['tab'],

	components: {zone, modal, addSection},

    mixins: [sortableMixin],

	data(){
		return{
			zones: [],
			store,

            sortableOptions: {
                draggable: ".zone",
                route: "/admin/traductions/zones/reorder/zones",
                list: 'zones'
            }
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
			if(this.store.state.currentTab==this.tab){
				axios.get(`/admin/traductions/zones`).then(({data}) => {
					this.zones = data
					Event.fire('refreshSelectItemsList', this.zones)
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
				axios.delete(`/admin/traductions/zones/${zone.element.id}`).then(({data}) => {
					this.fetchData()
					notify(data)
				})
			}
		}
	}
});
