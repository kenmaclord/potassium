<template>
    <div class="liste">
        <transition appear name="fade" mode="out-in">
            <div class="items" v-if="!loading" v-sortable="options">
                <item
                    v-for="item in liste"
                    :key="item.id"
                    :data="item"
                    :toggle_url="toggle_url"
                    :edit_url="edit_url"
                    :over_load_edit_event="over_load_edit_event"
                    :edit_icon="edit_icon"
                    :toggle_field="toggle_field"
                    :toggle_icons="toggle_icons"
                    :destroy="hasDeleteButton"
                    :delete_icon="delete_icon"
                    :sortable="sortable"
                    :context="context">
                        <div class="champ" :class="field" v-for="field in fields"><span>{{content(item, field)}}</span></div>
                </item>
            </div>
        </transition>


        <transition appear name="fade" mode="out-in">
            <div class="spinner" v-if="loading">
                <span class="icon">
                    <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
                </span>
            </div>
        </transition>

        <modal :context="context">
            <template slot="message">{{modal_message(modal_title_message)}}</template>
            <template slot="warning">{{modal_message(modal_warning_message)}}</template>
        </modal>
    </div>
</template>

<script>
    import item             from './item.vue'
    import modal            from './modal.vue'
    import modalData        from './modalData'
    import sortableMixin    from '../../utilities/sortable'

    export default {
        props : {
            fetch_url: {
                required: true,
                default: ""
            },

            toggle_url: {
                required: false,
                default: ""
            },

            toggle_field:{
                required: false,
                default: "visible"
            },

            toggle_icons:{
                required: false,
                default: function () { return ['fa-eye', 'fa-eye-slash'] }
            },

            edit_url: {
                required: false,
                default: ""
            },

            over_load_edit_event: {
                required: false,
                default: false
            },

            edit_icon: {
                required: false,
                default: 'fa-edit'
            },

            delete_url: {
                required: false,
                default: ""
            },

            delete_icon: {
                required: false,
                default: 'fa-trash'
            },

            sortable: {
                required: false,
                default: false
            },

            sortable_url: {
                required: false,
                default: ""
            },

            fields: {
                required: false,
                default: () => []
            },

            context: {
                required: false,
                default: ""
            },

            modal_title_message: {
                required: false,
                default: "Êtes-vous sûr de vouloir supprimer cet élément ?"
            },

            modal_warning_message: {
                required: false,
                default: "Cette action est irréversible"
            }
        },

        components : {modal, item},

        mixins: [sortableMixin, modalData],

        data() {
            return {
                loading: false,
                liste : [],

                sortableOptions: {
                    handle: ".draggable-handle",
                    draggable: ".item",
                    route: this.sortable_url,
                    list: 'liste'
                }
            }
        },

        created(){
            Event.listen('modal_validate', this.destroy)
            Event.listen('addCompleted', this.fetch)
            Event.listen('uploadCompleted', this.fetch)

            this.fetch()
        },

        computed: {
            hasDeleteButton(){
                return this.delete_url!=false
            }
        },

        methods: {
            /**
             * Récupère la liste
             *
             * @return  void
             */
            fetch(){
                this.loading = true

                axios.get(this.fetch_url).then(({data}) => {
                    this.loading = false
                    this.liste = data
                })
            },


            /**
             * Construit le message à afficher dans la boite modale
             *
             * @param   String  str
             *
             * @return  String
             */
            modal_message(str){
                var re = /%[A-Za-z0-9\-_]+%/gi;

                _.each(str.match(re), message => {
                    str = str.replace(message, this.content(message.replace(/[%]+/g,'')))
                })

                return $.nl2br(str)
            },


            /**
             * Supprime un élément
             *
             * @param   Json  evenement
             *
             * @return  void
             */
            destroy(data){
                if (this.context==data.context) {
                    if (data.content === undefined) {
                        var url = `${this.delete_url}/${data.id}`
                    }else{
                        var url = `${this.delete_url}/${data.content.id}`
                    }

                    axios.delete(url).then(({data:response}) => {
                        this.fetch()
                        notify(response)
                    })
                }
            },

            /**
             * Retourne le contenu d'un élément
             *
             * Si field vaut une simple valeur, on retourne la propriété correspondante de l'objet
             * Si field vaut une valeur combinée, comme i18n.name, on retourne la propriété localisée correspondante de la propriété de l'objet
             *
             * @param   Object  item
             * @param   String  field
             *
             * @return  String
             */
            content(item, field){
                let segments = field.split('.')

                if (segments.length == 1){
                    return item[field]
                }

                if (segments.length == 2){
                    return $.localized(item[segments[0]], segments[1], 'fr')
                }
            }
        }
    }
</script>


<style lang="scss" scoped>

</style>
