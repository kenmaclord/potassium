<template>
	<div class="item">
			<div class="key head" v-text="item.key"></div>
			<div class="fr head">
				<edit-in-place
					:id="item.id"
					:url="updateUrl"
					:text="content('fr')"
					emptyText="Cliquer pour saisir une traduction..."
					message="Traduction mise à jour"
					field="fr"
					:textarea="true"
					input-class="input"
					text-class="textToDisplay"
				></edit-in-place>
			</div>
			<div class="localized head">
				<edit-in-place
					:id="item.id"
					:url="updateUrl"
					:text="content('localized')"
					emptyText="Cliquer pour saisir une traduction..."
					message="Traduction mise à jour"
					:field="store.state.currentLocalizedLang.code"
					:textarea="true"
					input-class="input"
					text-class="textToDisplay"
				></edit-in-place>
			</div>
	</div>

</template>

<script>
	import editInPlace from "../../app/editInPlace.vue"
	import store  from './TraductionsStore'

	export default {

		/*
		|--------------------------------------------------------------------------
		| Déclaration des composants enfants utilisés
		|--------------------------------------------------------------------------
		*/
		components : {editInPlace},


		/*
		|--------------------------------------------------------------------------
		| Gestion des data du composant (props, data, computed et watch)
		|--------------------------------------------------------------------------
		*/
		props : ['item'],

		data(){
			return {
				url: '/admin/traductions/content',
				store
			}
		},

		computed: {
			updateUrl(){
				return `${this.url}/${this.item.id}`
			}
		},

		/*
		|--------------------------------------------------------------------------
		| Méthodes du composant
		|--------------------------------------------------------------------------
		*/
		methods:{
			content(type){
				if(this.item[type] !=null){
					return this.item[type]
				}
			}
		}
	}
</script>


<style scoped lang='scss'>

.item{
	display: flex;
	min-height: 50px;
	align-items: center;

	&:nth-child(2n){
		background-color: #E3E3E3;
	}


	.key{
		width: 22%;
		margin-right: 1%;
	}

	.delete{
		display: block;
		width:10%;
	}

	.fr{
		margin-right: 1%;
	}

	.fr, .localized{
		width: 38%;
	}

}

</style>
