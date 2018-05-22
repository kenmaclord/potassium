class store{

    /**
     * Constructeur
     */
    constructor(){
        this.state = {
            page: "",
            lang: "",
            traductions: ""
        }
    }


    /**
     * Initialise le store
     *
     * @param  String href : Valeur de l'url
     * @return Void
     */
    initState(href){
        this.initSegments(href)
    }


    /**
     * Initialisation des paramètres à partir de l'url
     *
     * @param   String  href
     *
     * @return  Void
     */
    initSegments(href){
        let segments = href.split('/')

        /** Initialise la langue */
        this.state.lang = segments[3]

        /** Initialise la page courante en fonction de l'url */
        if(segments.length==4){ this.state.page = 'home' }

        if(segments.length>4){ this.state.page = this.trimParams(segments[4])}
    }

    /**
     * Retourne le nom de la page sans les paramètres
     *
     * @param   String  segment
     *
     * @return  String
     */
    trimParams(segment){
        return segment.split('?')[0]
    }


    /**
     * Charge les fichies de traductions
     *
     * @return Void
     */
    loadTraductions(){
        axios.get('/front/translations', {params:{lang:this.state.lang}}).then(({data}) => {
            this.state.translations = data
            Event.fire('translationsLoaded')
        })
    }

    /**
     * Retourne la langue courante
     *
     * @return String
     */
    getLocale(){
        return this.state.lang
    }


    /**
     * Assigne la langue courante
     *
     * @param String langue : langue courante
     */
    setLocale(lang){
        this.state.lang = lang
    }


    /**
     * Retourne la traduction correspondant à la clé
     *
     * @param   String  key
     *
     * @return  String
     */
    getTranslation(key){
        return _.get(this.state.translations, key, key);
    }
}

export default new store()
