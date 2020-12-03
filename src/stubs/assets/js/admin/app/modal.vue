<template>
  <transition name="fade-modal">
		<div class="modal is-active" v-if="showDeleteConfirmationModal">
		  <div class="modal-background"></div>
		  <div class="modal-card">
			<header class="modal-card-head"></header>
			<section class="modal-card-body">
					<div class="content">
			  <h3><strong><slot name="message"></slot></strong></h3>
			  <strong><slot name="warning"></slot></strong>
			</div>
			  <slot name="content"></slot>
			</section>
			<footer class="modal-card-foot">
				<slot name="actions">
				<a class="button" @click="closeModal">Annuler</a>
				<a class="button is-danger" @click="validate">Supprimer</a>
			  </slot>
			</footer>
		  </div>
		</div>
	</transition>
</template>



<script>
	export default {
		props: {
			context: {
				required: false,
				default: ""
			}
		},

		components : {},

		data(){
			return {
				showDeleteConfirmationModal: false,
				data: ""
			}
		},

	  created() {
		Event.listen('confirmation', this.showModal)
	  },

		methods:{
			/**
			* Ouvre le dialogue de confirmation de la suppression
			*
			* @param  JSON data : l'élément qui a demandé la suppression
			* @return void
			*/
			showModal(data){
				if(this.context=="" || this.context==data.context){
					this.data = data
					this.showDeleteConfirmationModal = true
				}
		  	},


			/**
			* Fermeture de la modale
			*
			* @return void
			*/
			closeModal(){
				this.showDeleteConfirmationModal = false
					Event.fire('modal_close')
			},


			/**
			* Si la confirmation est validée on lance l'action
			*
			* @return void
			*/
			validate(){
				this.closeModal()
				Event.fire('modal_validate', this.data)
			}
		}
	}
</script>


<style scoped lang='scss'>
	.modal-card{
		margin-bottom: 500px;
	}

	.modal-card-head{
		height: 5px;
		background-color: #FFF;
		border:  none;
		padding:  0;
		margin:  0;
	}

	.modal-card-foot{
		display: flex;
		justify-content: flex-end;
	}

	h3 strong{
		color:  #e54b4b;
	}

	.fade-modal-enter-active, .fade-modal-leave-active {
	  transition: opacity .3s
	}
	.fade-modal-enter, .fade-modal-leave-to /* .fade-leave-active in <2.1.8 */ {
	  opacity: 0
	}

</style>
