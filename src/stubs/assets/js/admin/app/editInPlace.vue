<template>
	<div class="edit-in-place">
		<div class="focus editField control" v-show="editing">
			<input
				class="input edition"
				:class="inputClass"
				autofocus
				type="text"
				name="text"
				v-model="editedText"
				@keyup.esc="cancel"
				@keyup.enter="save"
				v-focus="editing"
				v-if="!textarea"
			>
			<textarea
				class="input edition"
				:class="inputClass"
				autofocus
				type="text"
				name="text"
				v-model="editedText"
				@keyup.esc="cancel"
				v-focus="editing"
				v-if="textarea"
			></textarea>

			<div class="buttons">
				<a class="button is-danger cancel" @click="cancel">
					<span class="icon">
						<i class="fa fa-remove"></i>
					</span>
					<span class="buttonLabel">Annuler</span>
				</a>

				<a class="button is-success save" :class="{disabled: !canBeSaved}" :disabled="!canBeSaved" @click="save">
					<span class="icon">
						<i class="fa fa-check"></i>
					</span>
					<span class="buttonLabel">Valider</span>
				</a>
			</div>
		</div>

		<div class="componentText" :class="textClass" @click="edit" v-if="!editing" v-text="savedText"></div>
	</div>

</template>

<script >
	export default {
		props : {
			id:{type:String|Number, default:0},
			url:{type:String, default:""},
			text:{type:String, default:""},
			emptyText:{type:String|Number, default:"Cliquez pour saisir une valeur..."},
			inputClass:{type:String, default:""},
			textClass:{type:String, default:""},
			context:{default:""},
			field:{type:String, default:"name"},
			message:{type:String, default:"Information mise à jour"},
			textarea:{type:Boolean, default:false},
			required:{type:Boolean, default:true},
		},

		data(){
			return {
				editing : false,
				savedText: this.text || this.emptyText,
				editedText: ""
			}
		},


		computed: {
			canBeSaved(){
				if(this.required && this.editedText==""){
					return false
				}
				return true
			},
		},

		watch: {
			text(value){
				this.savedText = value
			}
		},

		methods:{

			/**
			* Passage en mode édition
			* @return Void
			*/
			edit(){
				Event.fire("startEditing", this.id)
				this.editedText=""

				if(this.savedText!=this.emptyText){
					this.editedText = this.savedText
				}
				this.editing = true
			},


			/**
			 * Annulation de l'édition
			 * @param  DomEvent e
			 * @return Void
			 */
			cancel(e){
				Event.fire("editInPlaceCanceld", this.id)
				this.editing = false
			},


			/**
			 * Sauvegarde la nouvelle valeur saisie dans le champ d'édition
			 * @param  DomEvent e
			 * @return Void
			 */
			save(e){
				if(this.canBeSaved){
					Event.fire("editInPlaceSaving")

					/**
					 * Préparation des données à envoyer
					 * @type {Object}
					 */
					let data = {}
					data[this.field] = this.editedText

					/**
					 * Envoi des données
					 *
					 * @param  String url 	: Route pour l'envoi des données
					 * @param  Object data 	: Les données
					 * @return {[type]}      [description]
					 */
					axios.put(this.url, data).then(({data}) => {
						notify(data)
						this.setSavedText(this.editedText)
						this.editing = false

						Event.fire("editInPlaceSaved", {
							'id': this.id,
							'field': this.field,
							'value': this.editedText,
							'context': this.context
						})
				 	}).catch(({response: {data:{error}}}) => {
						notify({
							'status': 'error',
							'message': 'Données non sauvergardées.<br>Vérifiez les champs de données.'
						})
					})
				}
			},


			/*
			|--------------------------------------------------------------------------
			| Initialise le texte à une valeur par défaut si celui-ci est null ou vide
			|--------------------------------------------------------------------------
			*/
			setSavedText(value){
				if(value==null || value==""){
					this.savedText = this.emptyText
				}else{
					this.savedText = value
				}
			}
		},


		/**
		 * Directive personnelle pour donner le focus
		 * @type {Object}
		 */
		directives: {
			focus(el, value){
				if(value.value){
					Vue.nextTick(() => {
						el.focus()
					})
				}
			}
		}
	}
</script>


<style scoped lang='scss'>

.edit-in-place{
	display: flex;
	align-items: center;
	min-height: 50px;

	.editField{
		width:  100%;
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding-right: 20px;
	}

	.input, .componentText{
		font-family: 'Lato-Regular', Arial;
	}

	.componentText{
		cursor: pointer;
		padding-left: 10px;
	}

	.buttons{
		display:  flex;
		min-width: 100px;
		flex-direction: row;
		flex: 1;
		justify-content: flex-end;

		.buttonLabel{ display: none;}

		span.icon{
			margin:  0 -5px !important;
		}
	}

	.button.cancel{
		margin-right: 10px;
	}
}

@media screen and (max-width: 700px){
	.edit-in-place{
		.editField{
			width:  100%;
			display: flex;
			justify-content: space-between;
			flex-direction:  column;
		}

		.buttons{
			margin-top: 10px;

			a.button{
				flex:1;
			}

			span.icon{
				margin:  0 8px 0 -4px!important;
			}

			.buttonLabel{
				display: inline;
			}

			.button.cancel{
				margin-right: 0px;
			}
		}
	}

}
</style>
