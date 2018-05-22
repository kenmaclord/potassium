import Vue              from 'vue';

import modal            from '../../app/modal.vue';
import addSection       from '../../app/addSection.vue';
import sortableMixin    from '../../../utilities/sortable'

import user             from './user.vue';

Vue.component('users', {
    components: {addSection, modal, user},

    mixins: [sortableMixin],

    data() {
        return {
            users: {},

            sortableOptions: {
                draggable: ".user",
                route: "/admin/utilisateurs/reorder/users",
                list: 'users'
            }
        }
    },

    created(){
        Event.listen('modal_validate', this.deleteUser)
        Event.listen('addCompleted', this.fetchUsers)

        this.fetchUsers()
    },

    methods: {
        fetchUsers(){
            axios.get('/admin/utilisateurs').then(({data}) => {
                this.users = data
            })
        },


        /**
         * Supprime un utilisateur
         *
         * @param   Json  user
         *
         * @return  void
         */
        deleteUser(user){
            axios.delete(`/admin/utilisateurs/${user.id}`).then(({data}) => {
                this.fetchUsers()
                notify(data)
            })
        }
    }
})
