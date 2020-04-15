<template>
	<div class="photo" @dragstart="setDraggedPhoto">
		<img class="image draggable-handle" :src="photo.xs" alt="">

		<div class="legende" v-if="hasLegende">
			<edit-in-place
				:id="photo.id"
				:url="edit_legende_url_full"
				:text="photo.legende"
				emptyText="Cliquer pour saisir une légende..."
				message="Légende modifiée"
				field="legende"
				input-class="input"
				text-class="textToDisplay"
				:required="legende_required"
			></edit-in-place>
		</div>

		<div class="actions">
			<a class="button is-success" :class="{disable: !photo[toggle_field]}" @click="toggleVisibility">
				<span class="icon is-small">
					<i class="fa fa-eye" :class="toggleIcons"></i>
				</span>
			</a>

			<a class="button is-danger" @click="deleteConfirmation">
				<span class="icon is-small">
					<i class="fa" :class="delete_icon"></i>
				</span>
			</a>
		</div>
	</div>
</template>

<script>
	import editInPlace from './editInPlace.vue'

	export default {

		components: {editInPlace},

		props: {
			photo: {
				required: true
			},

			toggle_field: {
				required: false,
				default: ""
			},

			toggle_url: {
				required: false,
				default: ""
			},

			toggle_icons:{
                required: true,
                default: function () { return [] }
            },

			context: {
				required: false,
				default: ""
			},

			edit_legende_url: {
				required: false,
				default: ""
			},

			legende_required: {
				required: false,
				default: true
			},

            delete_icon: {
                required: true,
                default: ""
            },
		},

		computed: {
			edit_legende_url_full(){
				return `${this.edit_legende_url}/${this.photo.id}`
			},

			hasLegende(){
				return this.edit_legende_url != ""
			},

            toggleIcons(){
                if (this.toggle){
                    return this.toggle_icons[0]
                }

                return this.toggle_icons[1]
            }
		},

		methods: {
			toggleVisibility(){
				let payload = {}
				payload[this.toggle_field] = !this.photo[this.toggle_field]

				axios.put(`${this.toggle_url}/${this.photo.id}`, payload).then(({data}) =>{
					notify(data)
					this.photo[this.toggle_field] = !this.photo[this.toggle_field]
				}).catch(({response: {data}}) => {
                    notify(data)
                })
			},

			deleteConfirmation(){
				Event.fire('confirmation', {context: this.context, content: this.photo})
			},

			setDraggedPhoto(){
				Event.fire("photoDragging", this.photo)
			}
		}
	}
</script>

<style scoped lang='scss'>
	@import '../../../sass/core/variables';

	.photo{
		display: flex;
		margin-bottom: 10px;
		justify-content: space-between;
		align-items: center;
		padding-right: 5px;

		.image{
			max-width: 120px;
		}

		&.sortable{
			.image{
				cursor: move;
				cursor: -webkit-grabbing;
			}
		}

		&:nth-child(odd){
			background-color: var(--color-gray-400);
		}

		.legende{
			margin-left: 20px;
			flex: 1;
		}

		.actions{
			min-width: 70px;
			margin-left: 10px;

			.button{
				margin-right: 5px;

				&.disable{
					opacity: 0.5;
					background-color: #AAA;
				}
			}
		}
	}

</style>
