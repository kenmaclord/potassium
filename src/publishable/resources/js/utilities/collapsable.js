export default{
	data(){
		return {
			openState: false
		}
	},

	methods:{
		collapse(element=null, minHeight) {
			if ($.empty(element)){
				element = this.$el
			}

			if ($.empty(minHeight)) {
				minHeight = 0
			}

			// get the height of the element's inner content, regardless of its actual size
			var sectionHeight = element.scrollHeight

			// temporarily disable all css transitions
			var elementTransition = element.style.transition;
			element.style.transition = '';

			// on the next frame (as soon as the previous style change has taken effect),
			// explicitly set the element's height to its current pixel height, so we
			// aren't transitioning out of 'auto'
			requestAnimationFrame(function() {
				element.style.height = sectionHeight + 'px';
				element.style.transition = elementTransition;

			    // on the next frame (as soon as the previous style change has taken effect),
			    // have the element transition to height: 0
			    requestAnimationFrame(function() {
			      element.style.height = minHeight + 'px';
			    });
		  });
		},

		expand(element=null) {
			if($.empty(element)){
		  		element = this.$el
			}

			// get the height of the element's inner content, regardless of its actual size
			var sectionHeight = element.scrollHeight;

			// have the element transition to the height of its inner content
			element.style.height = sectionHeight + 'px';
		},

		openOrClose(el, minHeight){
			if (this.openState){
			  this.collapse(el, minHeight)
			}else{
			  this.expand(el)
			}

			this.openState = !this.openState
		},

		open(el){
			this.expand(el)
			this.openState = true
		},

		close(el, minHeight){
			this.collapse(el, minHeight)
			this.openState = false
		},


		/**
		 * Augmente la hauteur d'un élément après une modification du contenu
		 *
		 * @return  {[type]}          [description]
		 */
		expandContent(el){
			if (!$.empty(el)) {
				el.style.height = el.scrollHeight + 'px';
			}
		},

		/**
		 * Diminue la hauteur d'un élément après une modification du contenu
		 *
		 * @return  {[type]}          [description]
		 */
		shrinkContent(el, itemClass){
			if (!$.empty(el)) {
				let items  = this.$el.querySelectorAll(itemClass)
				var contentHeight = 0

				_.each(items, item => contentHeight += this.dimension(item))
				el.style.height = contentHeight + 'px';
			}
		},

		/**
		 * Calcul la hauteur d'un élément incluant ses marges
		 *
		 * @param   {[type]}  elm
		 *
		 * @return  {[type]}       [description]
		 */
		dimension(elm) {
		    var elmHeight, elmMargin
		    if(document.all) {// IE
		        elmHeight = parseInt(elm.currentStyle.height);
		        elmMargin = parseInt(elm.currentStyle.marginTop, 10) + parseInt(elm.currentStyle.marginBottom, 10)
		    } else {// Mozilla
		        elmHeight = parseInt(document.defaultView.getComputedStyle(elm, '').getPropertyValue('height'));
		        elmMargin = parseInt(document.defaultView.getComputedStyle(elm, '').getPropertyValue('margin-top')) + parseInt(document.defaultView.getComputedStyle(elm, '').getPropertyValue('margin-bottom'));
		    }
		    return (elmHeight+elmMargin);
		}
	}
}
