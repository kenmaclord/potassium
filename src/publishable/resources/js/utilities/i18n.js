export default {
    data() {
        return {
            lang: 'fr',
            i18nContent: []
        }
    },

    mounted(){
        if (!_.isEmpty(this.store)) {
            if (!this.store.state.languesLoadedOnce) {
                this.store.state.languesLoadedOnce = true
                this.fetchLangs()
            }

            if (!this.store.state.translationsLoadedOnce) {
                this.store.state.translationsLoadedOnce = true
                this.loadTraductions()
            }
        }
    },

    methods: {

        /**
         * Récupère toutes les langues disponibles
         *
         * @return  void
         */
        fetchLangs(){
            axios.get('/api/langues/available').then(({data}) => {
                this.store.state.langues = data
            })
        },

        /**
         * Retourne le contenu localisé
         *
         * @param   String  attribute
         *
         * @return  String
         */
        localized(content, lang, attribute){
            lang = _.isEmpty(lang) ? this.store.state.lang : lang;

            let data = _.filter(content, (c) => {
                return c.lang == lang
            })


            if(data.length>0){
                return data[0][attribute]
            }

            return ""
        },


        /**
         * Assigne automatiquement les informations localisées à l'object courant
         *
         * @param   Array  attributes
         * @param   Json  object
         *
         * @return  Void
         */
        localizeContent(object, lang, attributes){
             lang = (typeof lang !== 'undefined') ? lang : this.store.state.lang

            // Si aucun attribut n'est précisé, on utilise les keys de l'objet en
            // enlevant les clés du système de form et d'error
            if (_.isEmpty(attributes)) {
                attributes = Object.keys(_.omit(object, ["originalData", "errors"]))
            }

            _.each(attributes, attribute =>{
                object[attribute] = this.localized(this.i18nContent, lang, attribute)
            })



            object['lang'] = lang
        },

        /**
         * Charge les fichies de traductions
         *
         * @return Void
         */
        loadTraductions(){
            axios.get('/front/traductions', {params:{lang:this.store.state.lang}}).then(({data:traductions}) => {
                this.store.state.traductions = traductions
                Event.fire('translationsLoaded')
            })
        },

        /**
         * Retourne la traduction correspondant à la clé
         *
         * @param   String  key
         *
         * @return  String
         */
        trans(key) {
            return $.nl2br(_.get(this.store.state.traductions, key, key))
        }
    }
}
