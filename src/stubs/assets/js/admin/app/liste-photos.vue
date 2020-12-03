<template>
    <div class="liste-photos">
        <transition appear name="fade" mode="out-in">
            <div id="photos" class="photos" v-if="!loading" v-sortable="options">
                <photo
                    v-for="photo in liste"
                    :key="photo.id"
                    :photo="photo"
                    :toggle_field="toggle_field"
                    :toggle_url="toggle_url"
                    :toggle_icons="toggle_icons"
                    :context="context"
                    :delete_icon="delete_icon"
                    :edit_legende_url="edit_legende_url"
                    :class="{'sortable':sortable}"
                    >
                </photo>
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
    import photo            from './photo.vue'
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

            context: {
                required: false,
                default: ""
            },

            edit_legende_url: {
                required: false,
                default: ""
            },

            modal_title_message: {
                required: false,
                default: "Êtes-vous sûr de vouloir supprimer cette image ?"
            },

            modal_warning_message: {
                required: false,
                default: "Cette action est irréversible"
            }
        },

        components : {modal, photo},

        mixins: [sortableMixin, modalData],

        data() {
            return {
                loading: false,
                liste : [],

                sortableOptions: {
                    handle: ".draggable-handle",
                    draggable: ".photo",
                    route: this.sortable_url,
                    list: 'liste',
                    disabled: !this.sortable,
                }
            }
        },

        created(){
            Event.listen('modal_validate', this.destroy)
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

                return str
            },


            /**
             * Supprime un élément
             *
             * @param   Json  evenement
             *
             * @return  void
             */
            destroy(data){
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
        }
    }
</script>
