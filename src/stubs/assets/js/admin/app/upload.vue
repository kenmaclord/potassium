<template>
    <div class="dropzone" :id="id"></div>
</template>

<script>
	import Dropzone from 'dropzone'

	export default {
		props : {
      action: {
        type: String,
        required: true
      },
      message:{
        type: String,
        default: "Déposer une image ici ou cliquer pour parcourir le disque",
        required: false
      },
      filter: {
        type: String,
        default: "",
        required: false
      },

      id: {
        type: String,
        required: true
      },

      multiple: {
        type: Boolean,
        required: false,
        default: false
      },

      payload:{}
    },

		data(){
			return {}
		},

		mounted(){
			let vm = this;

      Dropzone.autoDiscover = false;

      new Dropzone(this.$el, {
        url: vm.action,
        maxFilesize: 500, // en Mo
				filesizeBase: 1000000,
  			acceptedFiles: vm.filter,
        uploadMultiple: vm.multiple,
        parallelUploads: 1,
  			dictDefaultMessage : "<div class='zone'><i class='fa fa-plus'></i><div class='text'>"+vm.message+"</div>",

        // Ajouter de token crsf à la requête
        sending: function(file, xhr, formData) {
          formData.append("_token", document.querySelector('#token').getAttribute('content'));

          /**
           * Ajoutes les extra parameters à la requête
           *
           * @param   Array payload
           *
           * @return  void
           */
          _.each(vm.payload, function(p, k){
            formData.append(Object.keys(p), Object.values(p));
          })
  		  },

  		  // Si le fichier est correctement uploadé
  			success(file, response){
          Event.fire('fileAdded', response)
          this.removeFile(file)

          if(this.files.length ===0){
            Event.fire('uploadCompleted', response)
          }
        },


        // S'il y a eu une erreur à l'upload ou à la validation avant
        error(errorResponse){
          let sizeMo = (errorResponse.size/(this.options.filesizeBase)).toFixed(2)

          if(!errorResponse.accepted){
            if(errorResponse.size>(this.options.maxFilesize*this.options.filesizeBase)){
              var response = {
                status : errorResponse.status,
                message : "Le fichier est trop gros ("+sizeMo+" Mo). Max "+this.options.maxFilesize+" Mo"
              }
            }else{
              var response = {
                status : errorResponse.status,
                message : "Fichier invalide. "+this.options.acceptedFiles+" seulement"
              }
            }
          }else{
            var response = JSON.parse(errorResponse.xhr.response)
          }

          notify({
            'status': 'error',
            'message': response.message
          })

  				// Retire le fichier de la liste après 5 secondes
  				let dp = this
  				setTimeout(function(){
  					dp.removeFile(errorResponse)
  				},5000)
  			}
			})
		},
	}
</script>


<style>

.dropzone{
  margin-bottom: 30px;
}

.dropzone .zone i.icon.add{
	font-size: 1.5rem;
	color : #777;
}

.dropzone .zone .text{
	color : #777;
	text-align: center;
}

.dropzone:hover .zone .text{
	color : #2c363f;
}

.dropzone:hover .zone i.icon.add{
	color : #2c363f;
}

.dropzone:hover{
	border: 6px dashed #2c363f;
}

.dropzone, .dropzone * {
  box-sizing: border-box; }

.dropzone {
  display: flex;
  justify-content: center;
  align-items: center;

  height: 150px;
  border: 6px dashed #777;
  background: white;
  padding: 20px 20px; }
  .dropzone.dz-clickable {
    cursor: pointer; }
    .dropzone.dz-clickable * {
      cursor: default; }
    .dropzone.dz-clickable .dz-message, .dropzone.dz-clickable .dz-message * {
      cursor: pointer; }
  .dropzone.dz-started .dz-message {
    display: none; }
  .dropzone.dz-drag-hover {
    border: 6px dashed #2c363f;}
    .dropzone.dz-drag-hover .dz-message {
      opacity: 0.5; }
  .dropzone .dz-message {
    text-align: center;
    margin: 2em 0; }
  .dropzone .dz-preview {
    position: relative;
    display: inline-block;
    vertical-align: top;
    margin: 16px;
    min-height: 100px; }
    .dropzone .dz-preview:hover {
      z-index: 1000; }
      .dropzone .dz-preview:hover .dz-details {
        opacity: 1; }
    .dropzone .dz-preview.dz-file-preview .dz-image {
      border-radius: 20px;
      background: #999;
      background: linear-gradient(to bottom, #eee, #ddd); }
    .dropzone .dz-preview.dz-file-preview .dz-details {
      opacity: 1; }
    .dropzone .dz-preview.dz-image-preview {
      background: white; }
      .dropzone .dz-preview.dz-image-preview .dz-details {
        -webkit-transition: opacity 0.2s linear;
        -moz-transition: opacity 0.2s linear;
        -ms-transition: opacity 0.2s linear;
        -o-transition: opacity 0.2s linear;
        transition: opacity 0.2s linear; }
    .dropzone .dz-preview .dz-remove {
      font-size: 14px;
      text-align: center;
      display: block;
      cursor: pointer;
      border: none; }
      .dropzone .dz-preview .dz-remove:hover {
        text-decoration: underline; }
    .dropzone .dz-preview:hover .dz-details {
      opacity: 1; }
    .dropzone .dz-preview .dz-details {
      z-index: 20;
      position: absolute;
      top: 0;
      left: 0;
      opacity: 0;
      font-size: 13px;
      min-width: 100%;
      max-width: 100%;
      padding: 2em 1em;
      text-align: center;
      color: rgba(0, 0, 0, 0.9);
      line-height: 150%; }
      .dropzone .dz-preview .dz-details .dz-size {
        margin-bottom: 1em;
        font-size: 16px; }
      .dropzone .dz-preview .dz-details .dz-filename {
        white-space: nowrap; }
        .dropzone .dz-preview .dz-details .dz-filename:hover span {
          border: 1px solid rgba(200, 200, 200, 0.8);
          background-color: rgba(255, 255, 255, 0.8); }
        .dropzone .dz-preview .dz-details .dz-filename:not(:hover) {
          overflow: hidden;
          text-overflow: ellipsis; }
          .dropzone .dz-preview .dz-details .dz-filename:not(:hover) span {
            border: 1px solid transparent; }
      .dropzone .dz-preview .dz-details .dz-filename span, .dropzone .dz-preview .dz-details .dz-size span {
        background-color: rgba(255, 255, 255, 0.4);
        padding: 0 0.4em;
        border-radius: 3px; }
    .dropzone .dz-preview:hover .dz-image img {
      -webkit-transform: scale(1.05, 1.05);
      -moz-transform: scale(1.05, 1.05);
      -ms-transform: scale(1.05, 1.05);
      -o-transform: scale(1.05, 1.05);
      transform: scale(1.05, 1.05);
      -webkit-filter: blur(8px);
      filter: blur(8px); }
    .dropzone .dz-preview .dz-image {
      border-radius: 20px;
      overflow: hidden;
      width: 120px;
      height: 120px;
      position: relative;
      display: block;
      z-index: 10; }
      .dropzone .dz-preview .dz-image img {
        display: block; }
    .dropzone .dz-preview .dz-success-mark, .dropzone .dz-preview .dz-error-mark {
      display :  none;}
    .dropzone .dz-preview.dz-processing .dz-progress {
      opacity: 1;
      -webkit-transition: all 0.2s linear;
      -moz-transition: all 0.2s linear;
      -ms-transition: all 0.2s linear;
      -o-transition: all 0.2s linear;
      transition: all 0.2s linear; }
    .dropzone .dz-preview.dz-complete .dz-progress {
      opacity: 0;
      -webkit-transition: opacity 0.4s ease-in;
      -moz-transition: opacity 0.4s ease-in;
      -ms-transition: opacity 0.4s ease-in;
      -o-transition: opacity 0.4s ease-in;
      transition: opacity 0.4s ease-in; }
    .dropzone .dz-preview:not(.dz-processing) .dz-progress {
      -webkit-animation: pulse 6s ease infinite;
      -moz-animation: pulse 6s ease infinite;
      -ms-animation: pulse 6s ease infinite;
      -o-animation: pulse 6s ease infinite;
      animation: pulse 6s ease infinite; }
    .dropzone .dz-preview .dz-progress {
      opacity: 1;
      z-index: 1000;
      pointer-events: none;
      position: absolute;
      height: 16px;
      left: 50%;
      top: 50%;
      margin-top: -8px;
      width: 80px;
      margin-left: -40px;
      background: rgba(255, 255, 255, 0.9);
      -webkit-transform: scale(1);
      border-radius: 8px;
      overflow: hidden; }
      .dropzone .dz-preview .dz-progress .dz-upload {
        background: #333;
        background: linear-gradient(to bottom, #666, #444);
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 0;
        -webkit-transition: width 300ms ease-in-out;
        -moz-transition: width 300ms ease-in-out;
        -ms-transition: width 300ms ease-in-out;
        -o-transition: width 300ms ease-in-out;
        transition: width 300ms ease-in-out; }
</style>
