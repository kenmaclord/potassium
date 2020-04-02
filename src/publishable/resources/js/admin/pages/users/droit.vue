<template>
	<div class="droit">
		<div class="description" v-text="droit.description" @click="toggleActive"></div>
		<div class="checkbox" :class="{granted: granted}" @click="toggleActive"></div>
	</div>
</template>

<script>
	import store from './userStore'

	export default {

		/*
		|--------------------------------------------------------------------------
		| Gestion des data du composant (props, data, computed et watch)
		|--------------------------------------------------------------------------
		*/
		props : ['dataDroit'],

		data(){
			return {
				store,
				user: store.state.currentUser,
				droit: this.dataDroit,
				granted: false
			}
		},


		created(){
			this.isGranted()
		},


		/*
		|--------------------------------------------------------------------------
		| Méthodes du composant
		|--------------------------------------------------------------------------
		*/
		methods:{
			/**
			 * Détermine si le droit courant est détenu par l'utilisateur ou pas
			 *
			 * @return  Boolean
			 */
			isGranted(){
				_.each(this.user.droits, droit => {
					if(_.includes(droit, this.droit.id)){
						this.granted = true
					}
				})
			},

			/**
			 * Alterne le statut d'un droit
			 *
			 * @return  void
			 */
			toggleActive(){
				axios.put(`/admin/utilisateurs/droits/${this.user.id}`, {
					granted: !this.granted,
					droit: this.droit.id
				}).then(({data}) => {
					notify(data)
					this.granted = !this.granted
				})
			}
		}
	}
</script>


<style scoped lang='scss'>

	@import '../../../../sass/core/variables';

	.droit{
		display: flex;
		height: 45px;
		margin-bottom: 5px;
		justify-content: space-between;
		align-items: center;
		cursor: pointer;

		&:nth-child(odd){
			background-color: #EEE;
		}

		.description{
			cursor: pointer;
			flex: 1;
		}

		.checkbox{
			height: 20px;
			width: 20px;
			border: 1px solid black;
			background-color: transparent;
			transition: background-color 0.3s ease;

			&.granted{
				background-color: black;
			}
		}
	}



</style>
