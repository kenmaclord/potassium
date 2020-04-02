<template>
    <div class="item">
        <div class="draggable-handle" v-if="sortable">
            <span class="icon is-small">
                <i class="fa fa-bars"></i>
            </span>
        </div>

        <slot></slot>

        <div class="actions">
            <a class="button is-success" :class="{'is-danger': !toggle}" @click="toggleItem" v-if="toggle_url">
                <span class="icon is-small">
                    <i class="fa" :class="toggleIcons"></i>
                </span>
            </a>

            <a class="button is-info" :href="`${this.edit_url}/${item.id}`" v-if="edit_url">
                <span class="icon is-small">
                    <i class="fa" :class="edit_icon"></i>
                </span>
            </a>

            <a class="button is-info" href="#" v-if="over_load_edit_event" @click.prevent="editEvent">
                <span class="icon is-small">
                    <i class="fa" :class="edit_icon"></i>
                </span>
            </a>

            <a class="button is-danger" @click="deleteConfirmation" v-if="destroy">
                <span class="icon is-small">
                    <i class="fa" :class="delete_icon"></i>
                </span>
            </a>
        </div>
    </div>
</template>

<script>
    export default {

        /*
        |--------------------------------------------------------------------------
        | Gestion des data du composant (props, data, computed et watch)
        |--------------------------------------------------------------------------
        */
        props : {
            data: {
                required: true,
                default: {}
            },

            sortable: {
                required: false,
                default: false
            },

            toggle_url: {
                required: false,
                default: false
            },

            toggle_icons: {
                required: true,
                default: ""
            },

            edit_url: {
                required: false,
                default: false
            },

            over_load_edit_event: {
                required: false,
                default: false
            },

            edit_icon: {
                required: true,
                default: ""
            },

            toggle_field: {
                required: false
            },

            destroy: {
                required: false,
                default: false
            },

            delete_icon: {
                required: true,
                default: ""
            },

            context: {
                required: true,
                default: ""
            }
        },

        data(){
            return {
                item: this.data,
                toggle: this.data[this.toggle_field]
            }
        },

        computed: {
            toggleIcons(){
                if (this.toggle){
                    return this.toggle_icons[0]
                }

                return this.toggle_icons[1]
            }
        },

        /*
        |--------------------------------------------------------------------------
        | Méthodes du composant
        |--------------------------------------------------------------------------
        */
        methods:{
            /**
             * Alterne le statut d'un évènement
             *
             * @return  void
             */
            toggleItem(){
                let payload = {}
                payload[this.toggle_field] = !this.toggle

                axios.put(`${this.toggle_url}/${this.item.id}`, payload).then(({data}) => {
                    notify(data)
                    this.toggle = !this.toggle
                }).catch(({response: {data}}) => {
                    notify(data)
                })
            },

            /**
             * Demande la confirmation de suppression
             *
             * @return  void
             */
            deleteConfirmation(){
                Event.fire('confirmation', {context: this.context, content: this.item})
            },

            editEvent(){
                Event.fire('editEvent', this.item)
            }
        }
    }
</script>


<style scoped lang='scss'>

  @import '../../../sass/core/variables';

  .item{
    display: flex;
    margin-bottom: 15px;
    justify-content: flex-start;
    align-items: center;


    .champ{
        flex: 1;
    }

    &:nth-child(even){
      background-color: $grey-lighter;
    }

    .draggable-handle .icon.is-small, .draggable-handle .icon.is-small .fa, .draggable-handle{
        cursor: grab;

        &:active {
            cursor: grabbing;
        }
    }

    .draggable-handle{
        width: 25px;
        text-align: center;
    }

    .actions{
        min-width: 40px;
        margin-left: 10px;

        a.button.is-success{
            margin-right: 5px;

            &.disable{
                opacity: 0.5;
                background-color: #AAA;
            }
        }
    }
  }

</style>
