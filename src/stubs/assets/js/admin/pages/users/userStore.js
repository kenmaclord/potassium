class userStore{

	constructor(){
		this.state = {
			currentUser: {}
		}
	}

	/**
	 * Assigne l'onglet courant
	 *
	 * @param  Json  tab
	 */
	setTab(tab){
		this.state.currentTab = tab
	}

	/**
	 * Assigne l'utilisateur courant
	 *
	 * @param  Json  user
	 */
	setUser(user){
		this.state.currentUser = user
		this.state.currentUser.locked = !!Number(this.state.currentUser.locked)
	}
}


export default new userStore()
