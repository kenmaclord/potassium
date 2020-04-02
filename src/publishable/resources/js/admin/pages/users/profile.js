import Vue          from 'vue';
import store from './userStore'

Vue.component('profile', {
	data() {
		return {
			isLoading: false,
			store,
			avatarsData: {},
			user: new Form({
				'id'		: store.state.currentUser.id,
				'first_name': store.state.currentUser.first_name,
				'last_name'	: store.state.currentUser.last_name,
				'email'		: store.state.currentUser.email,
				'locked'	: store.state.currentUser.locked,
				'genre'		: store.state.currentUser.genre,
				'avatar'	: store.state.currentUser.avatar,
				'error'		: {}
			})

		}
	},

	created(){
		this.getAvatars()
	},


	computed: {
		avatars(){
			return this.avatarsData[this.user.genre]
		}
	},

	methods: {
		/**
		 * Récupère la liste des avatars
		 *
 		 * @return  void
		 */
		getAvatars(){
			axios.get('/admin/utilisateurs/avatars').then(({data}) => {
				this.avatarsData = data
			})
		},

		/**
		 * Change l'avatar dans la vue et dans les infos à envoyer au serveur
		 *
		 * @param  String  avatar
		 */
		setAvatar(avatar){
			this.store.state.currentUser.avatarPath = avatar
			this.user.avatar = avatar
		},


		/**
		 * Détermine si l'avatar passé en paramètre est celui qui est attribué à l'utilisateur
		 *
		 * @param   String   avatar
		 *
		 * @return  Boolean
		 */
		isActive(avatar){
			return avatar == this.store.state.currentUser.avatarPath
		},


		/**
		 * Soumet le formulaire avec les données
		 * @return {[type]}       [description]
		 */
		save(){
			this.isLoading = true

			this.user.put(`/admin/utilisateurs/${this.user.id}`, this.user).then(response =>{
				notify(response)
				this.isLoading = false
			}).catch( response =>{
				notify({
					'status': 'error',
					'message': 'Données non sauvergardées. Vérifiez les champs de données.'
				})

				this.isLoading = false
		  	})
		},
	}
})
