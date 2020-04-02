import Vue from 'vue'
import _ from 'lodash'

export default {
	data() {
		return {
			largestDevice : "desktopXl",
			currentDevice : "desktopXl",
			previousDevice : "desktopXl",
			width: window.innerWidth,

			is: {
				phone : false,
				tabletPortrait : false,
				tablet : false,
				desktop : false,
				desktopXl : false,
			},

			resetState: {
				phone : false,
				tabletPortrait : false,
				tablet : false,
				desktop : false,
				desktopXl : false,
			},

			breakpoint: {
				phone : {
					size: 576,
					optimalPhotoSize: 's',
					sizeBelow: {
						device: 'phone',
						size : 0
					}
				},
				tabletPortrait : {
					size: 768,
					optimalPhotoSize: 'l',
					sizeBelow: {
						device: 'phone',
						size : 575
					}
				},
				tablet : {
					size: 1024,
					optimalPhotoSize: 'l',
					sizeBelow: {
						device: 'tabletPortrait',
						size : 768
					}
				},
				desktop : {
					size: 1200,
					optimalPhotoSize: 'xl',
					sizeBelow: {
						device: 'tablet',
						size : 1024
					}
				},
				desktopXl : {
					size: 1366,
					optimalPhotoSize: 'xxl',
					sizeBelow: {
						device: 'desktop',
						size : 1200
					}
				}
			}
		}
	},

	created(){
		window.addEventListener('resize', this.setDevice)
	},

	mounted(){
		this.setDevice()
	},

	beforeDestroy: function () {
		window.removeEventListener('resize', this.setDevice)
	},

	methods: {
		/**
		 * Détermine le device courant en fonction de la taille de la fenêtre.
		 * Met à jour des propriétés et déclenche un évènement de passage d'un device à l'autre
		 */
		setDevice(){
			this.width = window.innerWidth
			this.currentDevice = this.largestDevice

			_.assign(this.is, this.resetState)

			_.each(this.breakpoint, (b, index) => {
				if (this.width <= b.size && this.width > b.sizeBelow.size) {
					this.currentDevice = b.sizeBelow.device
				}
			})

			Vue.set(this.is, this.currentDevice, true)
			if (this.previousDevice != this.currentDevice) {
				Event.fire('became_' + this.currentDevice, this.currentDevice)
				this.previousDevice = this.currentDevice
			}
		},


		/**
		 * Retourne la photo à la taille la plus adaptée au device courant
		 *
		 * @param   Object photo
		 *
		 * @return  String
		 */
		optimalSize(photo){
			return photo[this.breakpoint[this.currentDevice].optimalPhotoSize]
		}
	}
}
