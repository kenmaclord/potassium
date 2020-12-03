export default {
    data() {
        return {
            modalData: ''
        }
    },

    created(){
        Event.listen('confirmation', this.initData)
    },

    methods: {
        initData(data){
            this.modalData = data
        },

        content(field){
            if (this.modalData !='') {
                return this.modalData.content[field]
            }
            return ''
        }
    }
}
