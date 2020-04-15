<template>
    <div class="user">
        <div class="draggable-handle">
            <span class="icon is-small">
                <i class="fa fa-bars"></i>
            </span>
        </div>

        <span class="name"  v-text="user.fullname"></span>
        <span class="email" v-text="user.email"></span>

        <div class="actions">
            <a class="button is-success" :class="{'is-danger': locked}" @click="toggleLock">
                <span class="icon is-small">
                    <i class="fa" :class="{'fa-unlock-alt': !locked, 'fa-lock': locked}"></i>
                </span>
            </a>

            <a class="button is-info" :href="`/admin/utilisateurs/${user.id}`">
                <span class="icon is-small">
                    <i class="fa fa-edit"></i>
                </span>
            </a>

            <a class="button is-danger" @click="deleteConfirmation">
                <span class="icon is-small">
                    <i class="fa fa-trash"></i>
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
        props : ['data'],

        data(){
            return {
                user: this.data,
                locked: !!Number(this.data.locked)
            }
        },

        /*
        |--------------------------------------------------------------------------
        | Méthodes du composant
        |--------------------------------------------------------------------------
        */
        methods:{
            /**
             * Alterne le statut d'un utilisateur
             *
             * @return  void
             */
            toggleLock(){
                axios.put(`/admin/utilisateurs/toggleLock/${this.user.id}`, {locked: !this.locked}).then(({data}) => {
                    notify(data)
                    this.locked = !this.locked
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
                Event.fire('confirmation', this.user)
            }
        }
    }
</script>


<style scoped lang='scss'>
  .user{
    display: flex;
    margin-bottom: 15px;
    justify-content: flex-start;
    align-items: center;

    .name, .email{
        flex: 1;
    }

    &:nth-child(even){
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
