<template>
    <div class="zone">
        <div class="draggable-handle">
            <span class="icon is-small">
                <i class="fa fa-bars"></i>
            </span>
        </div>

        <edit-in-place
            :id="zone.id"
            :url="`/admin/traductions/zones/${zone.id}`"
            :text="zone.nom"
            context="zones"
            emptyText="Cliquer pour saisir une légende..."
            message="Nom du filtre modifié"
            field="nom"
            input-class="input"
            text-class="textToDisplay"
        ></edit-in-place>

        <div class="actions">
            <a class="button is-danger" @click="deleteConfirmation">
                <span class="icon is-small">
                    <i class="fa fa-trash"></i>
                </span>
            </a>
        </div>
    </div>
</template>

<script>
    import editInPlace   from '../../app/editInPlace.vue'


    export default {
        components: {editInPlace},

        /*
        |--------------------------------------------------------------------------
        | Gestion des data du composant (props, data, computed et watch)
        |--------------------------------------------------------------------------
        */
        props : ['dataZone'],

        data(){
            return {
                zone: this.dataZone,
            }
        },


        /*
        |--------------------------------------------------------------------------
        | Méthode d'initialisation
        |--------------------------------------------------------------------------
        */
        created(){},

        mounted(){},

        /*
        |--------------------------------------------------------------------------
        | Méthodes du composant
        |--------------------------------------------------------------------------
        */
        methods:{
            deleteConfirmation(){
                Event.fire('confirmation', {'element': this.zone, 'context' : 'zones'})
            }
        }
    }
</script>


<style scoped lang='scss'>
  .zone{
    display: flex;
    margin-bottom: 15px;
    justify-content: space-between;
    align-items: center;

    &:nth-child(odd){
      background-color: var(--color-gray-100);
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

    .edit-in-place{
      flex: 1;
      margin-left: 15px;
    }

    .types{
        flex: 1;

        select{
            width: 100%;
        }
    }

    .actions{
        min-width: 40px;
        margin-left: 10px;

        a.button.is-success{
            margin-right: 5px;

            &.disable{
                opacity: 0.5;
                background-color: var(--color-disabled);
            }
        }
    }
  }

</style>
