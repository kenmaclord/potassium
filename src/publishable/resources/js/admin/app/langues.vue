<template>
    <div class="langues">
        <label class="label" v-text="label"></label>
        <p class="control">
            <span class="select is-fullwidth">
                <select class="is-fullwidth" v-model="value" @change="emit">
                    <option :value="langue.code" v-for="langue in langues" v-text="langue.nom"></option>
                </select>
            </span>
        </p>
    </div>
</template>

<script>
    export default {
        props : {
            langues: {
                required: true
            },
            label: {
                required: false,
                default: "Langue du contenu"
            }
        },

        data(){
            return {
                value: "fr"
            }
        },

        methods:{
            emit(){
                this.$emit('update:value', this.value)
                Event.fire('langChanged')
            }
        }
    }
</script>
