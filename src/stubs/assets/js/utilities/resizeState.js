export default {
	data() {
		return {
			isDesktop: false,
			isMobile: false,
			isPhone: false,
			breakpoint: {
				tablet : 1024,
				phone : 575
			},
			width: window.innerWidth
		}
	},

	created(){
		this.initWidth()
	},

	mounted(){
		window.addEventListener('resize', this.updateWidth)
	},

	beforeDestroy: function () {
		window.removeEventListener('resize', this.updateWidth)
	},

	methods: {
		updateWidth(){
			this.width = window.innerWidth

			if(this.isPhone && this.width > this.breakpoint.phone){
				this.isPhone = false
				this.isMobile = true
				this.isDesktop = false

				Event.fire('becameMobile')
			}

			if(this.isMobile && this.width > this.breakpoint.tablet){
				this.isPhone = false
				this.isMobile = false
				this.isDesktop = true

				Event.fire('becameDesktop')
			}

			if(this.isDesktop && this.width <= this.breakpoint.tablet){
				this.isPhone = false
				this.isMobile = true
				this.isDesktop = false
				Event.fire('becameMobile')
			}

			if(this.isMobile && this.width <= this.breakpoint.phone){
				this.isPhone = true
				this.isMobile = false
				this.isDesktop = false

				Event.fire('becamePhone')
			}
		},

		initWidth(){
			this.width = window.innerWidth

			if(this.width > this.breakpoint.tablet){
				this.isDesktop = true
			}

			if(this.width <= this.breakpoint.tablet && this.width > this.breakpoint.phone){
				this.isMobile = true
			}

			if(this.width <= this.breakpoint.phone){
				this.isPhone = true
			}
		},

		optimalSize(photo){
			if(this.isPhone){
				return photo.s
			}

			if(this.isMobile){
				return photo.m
			}

			if(this.isDesktop){
				return photo.xxl
			}
		}
	}
}
