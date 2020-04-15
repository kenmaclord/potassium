<template>
	<div class="add-section">
		<a class="button is-primary is-outlined" @click="openAdd">
			<span class="icon">
				<i class="fa fa-plus"></i>
			</span>
			<span>{{buttonText}}</span>
		</a>

		<div class="addItem" :class="{close: !isOpen}">
			<div class="box" :class="{unique: onlyOneField}">
				<div class="fields">
					<div class="field" v-for="field in fields">
						<label class="label" v-text="field.titre"></label>
						<div class="control">
							<input
								class="input libelle"
								:type="field.type"
								:id="field.name"
								autofocus
								tabindex="-1"
								:placeholder="field.titre"
								v-model="data[field.name]"
								@keyup.enter="addEntity"
							>
						</div>
					</div>
				</div>

				<div class="buttons">
					<button class="button is-success is-outlined addButton" :disabled="!hasEntity" @click="addEntity">
						<span>Ajouter</span>
						<span class="icon">
							<i class="fa fa-plus"></i>
						</span>
					</button>

					<button class="button is-inline is-danger is-outlined cancelButton" @click="cancelAdd">
						<span>Annuler</span>
						<span class="icon">
							<i class="fa fa-remove"></i>
						</span>
					</button>

				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import foreach from 'lodash/foreach'

	export default {
		components : {},

		props: ['buttonText','routeCreate', 'fields', 'nullable', 'extraParams'],

		created(){
			document.addEventListener('keyup', (event) => {
				if(event.keyCode==27){
					this.cancelAdd()
				}
			})
		},

		mounted(){
			this.resetData()
		},

		data(){
			return {
				isOpen: false,
				isDisabled: false,
				data: {},
				currentFocus: 0,
			}
		},

		computed: {
			hasEntity(){
				let empty = false

				foreach(this.fields, field => {
					if(!this.nullable.includes(field.name)) {
						empty = empty || $.empty(this.data[field.name])
					}
				})

				return !empty
			},

			onlyOneField(){
				return this.fields.length == 1
			},

			/**
			 * Hauteur de la box
			 *
			 * @return  String
			 */
			height(){
				if(this.onlyOneField){
					return "110px"
				}

				return 166+(80*(this.fields.length-1))+"px"
			},

			payload(){
				return Object.assign({}, this.data, this.extraParams);
			}
		},

		methods:{
			resetData(){
				foreach(this.fields, field => {
					if(field.default){
						this.data[field.name] = field.default
					}else{
						this.$set(this.data,field.name,"")
					}
				})
			},

			openAdd(){
				this.isOpen = true
				document.querySelector('.addItem').style.height = this.height
				this.giveFocus()
			},

			/**
			* Annule l'ajout d'un élément
			*/
			cancelAdd(){
				this.isOpen = false
				document.querySelector('.addItem').style.height = '0px'
				this.resetData()
			},


			/**
			 * Ajoute l'entité
			 */
			addEntity(){
				if(this.hasEntity){
					axios.post(this.routeCreate, this.payload).then(({data}) => {
						notify(data)
						Event.fire('addCompleted')
						this.cancelAdd()
					}).catch(error => {
						notify(error.response.data)
					})
				}
			},


			/**
			 * Donne le focus au champ dont le focus a été défini
			 *
			 * @return  void
			 */
			giveFocus(){
				document.getElementById(this.fields[this.currentFocus].name).focus();
			},


			/**
			 * Désactive les boutons d'ajout
			 *
			 * @return {[type]} [description]
			 */
			disableButtonAdd(){
				this.isDisabled = true
			},

			/**
			 * Réactive les boutons d'ajout
			 *
			 * @return {[type]} [description]
			 */
			enableButtonAdd(){
				this.isDisabled = false
			}
		}

	}
</script>


<style lang='scss' scoped>
	// @import "../../../sass/core/variables";

	.add-section{
		margin-bottom: 30px;
		width:100%;
	}

	.addItem{
		margin-top: 15px;
		overflow: hidden;
		transition: all var(--speed) var(--ease);

		&.close{
			height: 0px;
		}

		.cancelButton{
			margin-right: 10px;
		}

		.libelle{
			flex: 1;
			box-shadow: none;
		}

		.box{
			background-color: #F8F8F8;
			border: 1px solid darken(#F8F8F8, 20);
			display: flex;
			flex-direction: column;

			.buttons{
				margin-top: 20px;
			}

			.fields{
				display: flex;
				flex-direction: column;
				flex: 1;

				.field{
					flex: 1;
				}
			}


			&.unique{
				flex-direction: row;

				.buttons{
					margin-top: 30px;
				}

				.fields{
					margin-right: 10px;
				}
			}
		}
	}

	@media screen and (max-width: 550px){
		.addItem{
			.inputs{
				flex-direction: column;

				.buttons{
					display: flex;
					margin-top: 10px;

					.button{
						margin:  0;
						flex:  1;
					}

					.cancelButton{
						margin-right: 10px;
					}
				}
			}
		}
	}
</style>
