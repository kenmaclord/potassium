import Vue from 'vue';

/**
* Composants des onglets, contenant les pages individuelles
*/
export default Vue.component('tabs',{
	template : `
		<div>
			<div class="tabs is-fullwidth">
				<ul>
					<li v-for="tab in tabs" :class="{'is-active': tab.isActive}" @click.prevent="setActive(tab)"><a :href="tab.href">{{tab.title}}</a></li>
				</ul>
			</div>

			<div class="tabs-content"><slot></slot></div>
		</div>
	`,

	props: ['store'],

	data(){
		return{
			tabs: [],
		}
	},

	created(){
		this.tabs = this.$children
	},

	mounted(){
		this.setActive()
	},

	methods : {
		setActive(selectedTab){
			this.tabs.forEach(tab =>{
				if(selectedTab != undefined){
					tab.isActive = (tab.name == selectedTab.name)
				}

				if(tab.isActive){
					this.store.setTab(tab.name)
					Event.fire('tabSelected', tab.name)
				}
			})
		},
	}
});


/**
* Composants du contenu d'un onglet
*/
Vue.component('tab',{
	template : `
	<transition name="fade" key="initialTab">
		<div class="tab" v-show="isActive"><slot></slot></div>
	</transition>
	`,

	props : {
		name: {required: true},
		title: {required: true},
		selected: {default: false}
	},

	data(){
		return{ isActive: false }
	},

	mounted(){
		this.isActive = this.selected
	},

	computed: {
		href(){
			return "#"+$.slugify(this.name)
		}
	}
});
