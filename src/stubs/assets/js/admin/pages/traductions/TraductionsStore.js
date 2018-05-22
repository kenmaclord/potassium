import axios from 'axios'

class TraductionsStore{

	constructor(){
		this.state = {
			currentTab: "content",
			currentLocalizedLang: {},
			frenchLang: {},
		}

		this.setLang('en');
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
	 * Assigne la langue courante
	 *
	 * @param  Json  tab
	 */
	setLang(lang){
		this.localizedLangInfos(lang)
	}

	/**
	 * Récupère les informations sur la langue demandée
	 *
	 * @param   String  lang
	 *
	 * @return  void
	 */
	localizedLangInfos(lang){
		axios.get('/admin/traductions/langue', {params: {'lang': lang}}).then(({data}) => {
			this.state.currentLocalizedLang = data.localized
			this.state.frenchLang = data.fr
			Event.fire('langueChanged')
		})
	}

}


export default new TraductionsStore()
