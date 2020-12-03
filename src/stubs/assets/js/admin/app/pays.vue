<template>
    <div class="pays">
        <label class="label" v-text="label"></label>
        <p class="control">
            <span class="select is-fullwidth">
                <select class="is-fullwidth" v-model="value" @change="emit" v-if="!group_by_continent">
                    <option :value="pays.id" v-for="pays in countries" v-text="pays.name"></option>
                </select>

                <select class="is-fullwidth" v-model="value" @change="emit" v-if="group_by_continent">
                    <optgroup :label="continent.name" v-for="continent in countries">
                        <option :value="pays.id" v-for="pays in continent.pays" v-text="pays.name"></option>
                    </optgroup>
                </select>
            </span>
        </p>
    </div>
</template>

<script>
    export default {
        props : {
            label: {
                required: false,
                default: "Pays"
            },

            group_by_continent: {
                required: false,
                default: false
            }
        },

        data(){
            return {
                value: "",
                countries: []
            }
        },

        created(){
            this.value = this.$attrs.value

            axios.get('/api/pays', {params:{group_by_continent: this.group_by_continent}}).then(({data:pays}) => {
                this.countries = pays
            })

        },

        methods:{
            emit(){
                this.$emit('update:value', this.value)
                Event.fire('paysChanged')
            }
        }
    }
</script>
