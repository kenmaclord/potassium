import Vue        from 'vue'
import Sortable   from 'sortablejs'

export default {
  data(){
    return {
      options: {},
      sortableRoute: "",
      liste: {}
    }
  },

  created: function () {
    this.initSortable()
  },


  methods: {
    initSortable(){
      let self = this

      let defaultSortableOptions = {
        group: "liste",
        handle: ".draggable-handle",  // Drag handle selector within list items
        draggable: ".photo",  // Specifies which items inside the element should be draggable

        onEnd(evt) {
          self.reorder(evt)
        }
      }

      /** Fusion des options */
      Object.assign(this.options, defaultSortableOptions, this.sortableOptions);

      /** Récupération de la route pour le reorder */
      this.sortableRoute = this.sortableOptions.route
    },

    /**
     * Permet de mettre à jour l'ordre du tableau et le champ order
     * de la liste des photos après un réarrangement
     *
     * @param  Integer oldIndex   : Index d'où vient l'élément déplacé
     * @param  Integer newIndex   : Index d'où est arrivé l'élément déplacé
     * @return void
     */
    reorder: function ({oldIndex, newIndex}) {
      this.list = this.$data[this.sortableOptions.list]

      this.list.splice(newIndex, 0, this.list.splice(oldIndex, 1)[0])

      _.each(this.list,(item, index) => {
        item.order = index
      })

      let newOrder = _.map(this.list, 'id')

      axios.put(this.sortableRoute,{newOrder:newOrder}).then(({data}) =>{
        notify(data)
      })
    }
  }
}


/**
* Directive permettant de définir une liste comme sortable
*/
Vue.directive('sortable', {
  inserted: function (el, binding) {
    var sortable = new Sortable(el, binding.value || {});
  }
});
