<template>
	<div class="zone-filter">
		<input
			id="zoneFilter"
			type="text"
			@keyup="debounceFilter"
			placeholder="Rechercher une zone..."
			v-model="query"
			autofocus="autofocus"
		>
		<span class="icon">
			<i class="fa fa-search"></i>
		</span>
	</div>
</template>

<script>
	import store  from './TraductionsStore'

	export default {
		data(){
			return {
				store,
				query: "",
				debounceFilter: _.debounce(() => {this.updateZoneListe()}, 100)
			}
		},

		created(){
			Event.listen('refreshSelectItemsList', this.updateZoneListe)
		},

		methods:{
			/**
			 * Gère le filtrage des zones
			 *
			 * @return Void
			 */
			updateZoneListe(){
				if(this.query==""){
					this.store.state.filteredZones = this.store.state.allZones
				}else{
					this.store.state.filteredZones = _.filter(this.store.state.allZones, zone => {
						return ~(zone).toLowerCase().indexOf(this.query.toLowerCase())
					})
				}
			},
		}
	}
</script>


<style scoped lang='scss'>
	.zone-filter{
		display: flex;
		justify-content: flex-end;
		align-items: center;
		min-width: 250px;
		flex: 1;

		.fa-search{
			margin-top: 10px;
		}

		input{
			width: 100%;
			border: none;
			border-bottom: 1px solid var(--color-primary);
			height: 35px;
			outline: none;
			font-size: 1rem;
		}
	}
</style>
