<template>
	<div class="add-section-liste">
		<a class="button is-primary is-outlined" @click="openAdd">
			<span class="icon">
				<i class="fa fa-plus"></i>
			</span>
			<span>{{buttonText}}</span>
		</a>

		<div class="addItem_liste" :class="{open: isOpen}">
			<div class="box">
				<div class="inputs">
					<div class="field libelle">
						<label class="label">{{titre}}</label>
						<p class="control">
							<input class="input" ref='key' id="name" type="text" :autofocus="true" name="name" v-model="newEntity" @keyup.enter="addEntity">
						</p>
					</div>


					<div class="field drop">
						<label class="label">{{listeTitre}}</label>
						<div class="control">
							<div class="select">
								<select v-model="listeItem">
									<option v-for="item in selectItems" :value="item.id" v-text="item.nom"></option>
								</select>
							</div>
						</div>
					</div>

					<div class="field buttons">
							<button class="button is-success is-outlined addButton" :disabled="!isAddable" @click="addEntity">
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
	</div>

</template>



<script>
	export default {
		components : {},

		props : {
			buttonText:{type:String, default:"Ajouter"},
			routeCreate:{required:true, type:String, default:""},
			titre:{type:String, default:"Nouvelle entrée"},
			listeTitre:{type:String, default:"Liste de choix"},
			listeUrl:{required: true, type:String, default:""},
			inputName:{type:String, default:"name"},
			selectName:{type:String, default:"select"},
		},

		data(){
			return {
				isOpen: false,
				newEntity: "",
				selectItems: {},
				listeItem: ""
			}
		},

		created(){
			Event.listen('refreshSelectItemsList', this.getSelectItemsList)
		},


		computed: {
			hasEntity(){
				return this.newEntity!=""
			},

			hasItem(){
				return this.listeItem!=""
			},

			isAddable(){
				return this.hasItem && this.hasEntity
			}
		},

		mounted(){
			this.getSelectItemsList()
		},

		methods:{
			getSelectItemsList(data=null){
				if(data==null){
					axios.get(this.listeUrl).then(({data}) => {
						this.selectItems = data
					})
				}else{
					this.selectItems = data
				}
			},

			openAdd(){
				this.isOpen = true
				document.getElementById("name").focus();
			},


			/**
			* Annule l'ajout d'un élément
			*/
			cancelAdd(){
				this.isOpen = false
				this.newEntity=""
			},


			/**
			 * Ajoute la news
			 */
			addEntity(){
				if(this.hasEntity){
					axios.post(this.routeCreate, this.payload()).then(({data}) => {
						notify(data)
						Event.fire('entityAdded')
						this.cancelAdd()
					}).catch(({response: {data:{error}}}) => {
						notify(error)
						this.$refs.key.focus();
					})
				}
			},

			/**
			* Préparation des données à envoyer
			*/
			payload()
			{
				let payload = {}
				payload[this.inputName] = this.newEntity
				payload[this.selectName] = this.listeItem

				return payload
			}
		}
	}
</script>


<style lang='scss' scoped>
	@import "../../../sass/core/variables";

	.addItem_liste{
		margin-top: 15px;
		height: 0px;
		overflow: hidden;
		transition: height $speed ease;

		&.open{
			height: 122px;
		}

		.box{
			background-color: #F8F8F8;
			border: 1px solid darken(#F8F8F8, 20);
		}

		.inputs{
			display: flex;
			justify-content: space-between;

			.field.libelle, .field.drop{
				flex: 1;
				margin-right: 10px;
			}

			.select, .select select{
				width: 100%;
			}

			.buttons{
				width: 250px;
				margin-top: 20px;
			}
		}
	}

	@media screen and (max-width: 1024px){
		.addItem_liste{
			&.open{
				height: 260px;
			}

			.inputs{
				flex-direction: column;

				.field.libelle, .field.drop{
					margin-right: 0px;
				}

				.buttons{
					width: 100%;
					margin-top: 0px;

					.control{
						display: flex;
						width: 100%;
					}

					.button{
						flex: 1;
					}
				}
			}
		}
	}

</style>
