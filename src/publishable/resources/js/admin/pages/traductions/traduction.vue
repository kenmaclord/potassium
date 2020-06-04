<template>
	<div class="item">
		<div class="key" v-text="item.key"></div>
		<div class="fr">
			<edit-in-place
				:id="item.id"
				:url="updateUrl"
				:text="content('fr')"
				:emptyText="emptyText"
				message="Traduction mise à jour"
				field="fr"
				:textarea="true"
				input-class="input"
				:context="item.zone.slug"
				text-class="textToDisplay"
			></edit-in-place>
		</div>
		<div class="localized">
			<edit-in-place
				:id="item.id"
				:url="updateUrl"
				:text="content(store.state.currentLocalizedLang.code)"
				:emptyText="emptyText"
				message="Traduction mise à jour"
				:field="store.state.currentLocalizedLang.code"
				:textarea="true"
				input-class="input"
				:context="item.zone.slug"
				text-class="textToDisplay"
			></edit-in-place>
		</div>
	</div>

</template>

<script>
	import editInPlace from "../../app/editInPlace.vue"
	import store  from './TraductionsStore'

	export default {
		props : ['item'],

		components : {editInPlace},

		data(){
			return {
				store,
				emptyText: "Cliquer pour saisir une traduction..."
			}
		},

		computed: {
			updateUrl(){
				return `/admin/traductions/content/${this.item.id}`
			}
		},

		methods:{
			content(type){
				if (!$.empty(this.item.content)) {
					let content = JSON.parse(this.item.content)

					if (!$.empty(content[type])) {
						return content[type]
					}
				}

				return this.emptyText
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
			background-color: var(--color-gray-100);
		}

		.key{
			width: 22%;
			min-width: 250px;
		}

		.key, .fr{
			margin-right: 10px;
		}

		.fr, .localized{
			flex: 1;
		}
	}

</style>
