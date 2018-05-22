import Vue     from 'vue';

import profile from './profile'
import droits  from './droits'

import userStore from './userStore'

Vue.component('user', {
    props: ['data'],

    data() {
        return {
            user: JSON.parse(this.data),
            userStore
        }
    },

    created(){
        this.userStore.setUser(this.user)
        this.user.locked = !!Number(this.user.locked)
    },

    computed: {
        accountStatus() {
            if (this.user.locked) {
                return "Déverrouiller le compte"
            }

            return "Verrouiller le compte"
        }
    },


    methods: {
		/**
		 * Alterne le statut d'un utilisateur
		 *
		 * @return  void
		 */
        toggleLock() {
            axios.put(`/admin/utilisateurs/toggleLock/${this.user.id}`, { locked: !this.user.locked }).then(({ data }) => {
                notify(data)
                this.user.locked = !this.user.locked
            }).catch(({ response: { data } }) => {
                notify(data)
            })
        },
    }
})
