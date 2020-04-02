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
	export default {
		/*
		|--------------------------------------------------------------------------
		| Gestion des data du composant (props, data, computed et watch)
		|--------------------------------------------------------------------------
		*/
		props : ['data'],

		mounted(){
			Event.listen('filterZone', this.autocomplete)
		},

		data(){
			return {
				query: "",
				isOpen: false,
				debounceFilter: _.debounce(() => {this.autocomplete()}, 100)
			}
		},

		/*
		|--------------------------------------------------------------------------
		| Méthodes du composant
		|--------------------------------------------------------------------------
		*/
		methods:{
			/**
			 * Gère le filtrage des zones
			 *
			 * @return Void
			 */
			autocomplete(){
				if(this.query==""){
					this.$emit('filter', Object.keys(this.data))
				}else{
					let suggestions = [];
					_.each(this.data, (item, key) =>{
						if (~(key).toLowerCase().indexOf(this.query.toLowerCase())){
							suggestions.push(key)
						}
					})

					/** Assignation des résultats */
					if(suggestions.length > 0){
						this.$emit('filter', suggestions)
					}else{
						this.$emit('filter', [])
					}
				}
			},
		}
	}
</script>


<style scoped lang='scss'>
	.zone-filter{
		display: flex;
		justify-content: flex-end;
		min-width: 250px;
		flex: 1;

		.fa-search{
			margin-top: 10px;
		}

		input{
			width: 100%;
			border: none;
			border-bottom: 1px solid #777;
			height: 35px;
			outline: none;
			font-family: Lato-regular;
			font-size: 1rem;
		}
	}
</style>
