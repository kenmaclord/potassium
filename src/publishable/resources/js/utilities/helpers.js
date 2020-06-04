import moment   from 'moment'
import Easing   from './ease'

class ${
smoothScroll(containerSelector, targetSelector, duration=200, easing="easeInOutQuad", offset=0){
        return new Promise((resolve, reject) => {
            let target = document.querySelector(targetSelector)
            let container = document.querySelector(containerSelector)

            let targetPosition = target.getBoundingClientRect().top
            let startPosition = container.getBoundingClientRect().top
            let scrollPosition = container.scrollTop

            let distance = targetPosition - startPosition
            let startTime = null

            function animation(currentTime){
                if (startTime === null) startTime = currentTime
                let timeElapsed = currentTime - startTime
                container.scrollTo(0, Easing[easing](timeElapsed, scrollPosition - offset, distance, duration))
                if (timeElapsed < duration) {
                    requestAnimationFrame(animation)
                }else{
                    resolve()
                }
            }

            requestAnimationFrame(animation)
        })
    }



    /**
     * Assigne un cookie avec un nom en particulier
     *
     * @param String  name  : Nom de la clé du cookie à attribuer
     * @param String  cvalue : Valeur du cookie
     * @param Integer exhours : Durée de validité du cookie en heures
     */
    setCookie(name, cvalue, exhours) {
        var d = new Date();
        d.setTime(d.getTime() + (exhours*60*60*1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = name + "=" + cvalue + ";" + expires + ";path=/";
    }


    /**
     * Récupère un cookie en particulier
     *
     * @param  String cname: nom de la clé du cookie à récupérer
     *
     * @return String || null
     */
    getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length,c.length);
            }
        }
        return null;
    }


    /**
     * Vérifie l'existance d'un cookie
     *
     * @param  String name : nom de la clé du cookie à vérifier
     *
     * @return Boolean
     */
    hasCookie(name) {
        var cookie = this.getCookie(name);
        return  !this.empty(cookie)
    }


    /**
     * Supprime un cookie
     *
     * @param   String  name
     *
     * @return  Void
     */
    removeCookie(name) {
        this.setCookie(name,"",-1);
    }


    /**
    * Formate la date
    *
    * @param   {[type]}  date
    *
    * @return  {[type]}        [description]
    */
    format(date){
    return moment(date).format("DD.MM.YYYY");
    }


    /**
    * Génère un texte avec une ellipse
    *
    * @param   String  text : Texte à tronquer
    * @param   String  ellipsisText : Texte invitant à lire plus
    * @param   String  link : Lien vers la news à lire
    *
    * @return  String
    */
    truncate(text, ellipsisText="", link="", words=20){
    let truncated = _.take(text.split(' '), words).join(' ')

    if(this.empty(ellipsisText) || this.empty(link)){
      return truncated+' ...'
    }

    return truncated + `... <a class="black underlined" href="${link}">${ellipsisText}</a>`
    }

    /**
    * Retourne le contenu localisé
    *
    * @param   String  attribute
    *
    * @return  String
    */
    localized(content, attribute, lang){
      let data = _.filter(content, (c) => {
          return c.lang == lang
      })


      if(data.length>0){
        return this.nl2br(data[0][attribute])
      }

      return ""
    }

    /**
    * Retourne un tableau avec les éléments de l'url
    *
    * @return Array
    */
    segments(){
    return window.location.pathname.split('/')
    }

    /**
    * Retourne un élément particulier de l'url
    *
    * @return String
    */
    segment(index){
    return window.location.pathname.split('/')[index]
    }


    offset(elem) {
    // (1)
    var box = elem.getBoundingClientRect()

    var body = document.body
    var docElem = document.documentElement

    // (2)
    var scrollTop = window.pageYOffset || docElem.scrollTop || body.scrollTop
    var scrollLeft = window.pageXOffset || docElem.scrollLeft || body.scrollLeft

    // (3)
    var clientTop = docElem.clientTop || body.clientTop || 0
    var clientLeft = docElem.clientLeft || body.clientLeft || 0

    // (4)
    var top  = box.top +  scrollTop - clientTop
    var left = box.left + scrollLeft - clientLeft

    return { top: Math.round(top), left: Math.round(left) }
    }


    /**
    * Format une taille de fichier en octed en une chaîne facile à lire
    *
    * @param   {[type]}  size
    *
    * @return  {[type]}        [description]
    */
    humanReadableFilesize(size){
    if(size===null || empty(size) || size==0){
      let truncatedSize = 0;
      return "";
    }

    let s = ['o', 'ko', 'mo', 'go', 'to'];
    let e = Math.floor(Math.log(size)/Math.log(1024));
    let truncatedSize = (size/Math.pow(1024, e)).toFixed(2);

    return {
        size: truncatedSize,
        unit: s[e]
    }
    }

    /**
    * Retourne la valeur d'une propriété css d'un élément
    *
    * @param   String  element
    * @param   String  property
    *
    * @return  String
    */
    getCssValue(element, property){
       return window.getComputedStyle(document.querySelector(element)).getPropertyValue(property)
    }


    /**
    * Augmente ou diminue la valeur d'une propriété css d'un élément
    *
    * @param   String  element
    * @param   String  property
    * @param   Integer  value
    *
    * @return  void
    */
    changeValue(element, property, value){
    let currentValue = this.getCssValue('.box', 'margin-top').replace('px','')
    let newValue = parseInt(currentValue) + parseInt(value) + "px"

    document.querySelector(element).style[property] = newValue
    }

    /**
    * Assigne à la cible seulement les éléments de la source initialement définis dans la source
    *
    * @param   Object  obj
    * @param   Object  src
    *
    * @return  Object
    *
    *
    * Exemple:   obj = {a:"", b:""}
    *            src = {a:12, c: "Salut"}
    *
    *            assignStrict(obj, src) => {a:12, b:""}
    */
    assignStrict(obj, src){
    _.each(Object.keys(obj), key =>{
      if(src[key]!=undefined){
        obj[key] = src[key]
      }
    })

    return obj
    }


    /**
    * Vérifie si un élément possède une certaine classe
    *
    * @param  {String}  item : élément sur lequel chercher
    * @param  {String}  classToFind : classe à tester
    * @return {Boolean}
    */
    hasClass(item, classToFind) {
    return item.classList.contains(classToFind)
    }


    /**
    * Détermine si une variable est vide
    *
    * @param  String || Array || Object value
    * @return Boolean
    */
    empty(value){
        if (value === undefined){
            return true
        }

        if(value===null){
          return true
        }

        if (typeof value == "object"){
          return value.length==0
        }

        if (typeof value == "string"){
          return (value.trim()=="" || value==null)
        }

        return false
    }


    /**
    * QuerySelector avec ou sans élément parent
    *
    * @param  String elt : Élément à rechercher
    * @param  String initiator : Élément parent
    *
    * @return DomElement
    */
    qs(elt, initiator=null){
    if(initiator){
      return this.qs(initiator).querySelector(elt)
    }

    return document.querySelector(elt)
    }

    /**
    * QuerySelectorAll avec ou sans élément parent
    *
    * @param  String elt : Élément à rechercher
    * @param  String initiator : Élément parent
    *
    * @return DomElement
    */
    qsa(elt, initiator=null){
    if(initiator){
      return this.qs(initiator).querySelectorAll(elt)
    }

    return document.querySelectorAll(elt)
    }


    /**
    * GetElementById avec ou sans élément parent
    *
    * @param  String elt : Élément à rechercher
    * @param  String initiator : Élément parent
    *
    * @return DomElement
    */
    gebi(elt, initiator=null){
    if(initiator){
      return this.qs(initiator).getElementById(elt)
    }

    return document.getElementById(elt)
    }


    /**
    * Retourne la largeur d'un élément
    *
    * @param  DomElement elt : Élément dont on veut la largeur
    * @return Integer
    */
    width(elt){
    return elt.offsetWidth;
    }


    /**
    * Retourne la hauteur d'un élément
    *
    * @param  DomElement elt : Élément dont on veut la hauteur
    * @return Integer
    */

    height(elt){
    return elt.offsetHeight
    }



    /*
    |--------------------------------------------------------------------------
    | Raccourci vers la fonction console.log
    |--------------------------------------------------------------------------
    */
    log(str){
    console.log(str);
    }

    /*
    |--------------------------------------------------------------------------
    | Fonction permettant d'envoyer un message flash de succès
    |--------------------------------------------------------------------------
    |
    | @param $message
    |
    */
    // flashSuccess(message){
    //   var $divSuccess = '<div class="alert alert_success"/>';
    //   $('.alert_container').prepend($divSuccess);
    //   $('.alert_success').text(message);
    //   $('.alert_success').show().delay(6000).fadeOut(200, ){
    //     this.remove();
    //   });
    // }

    /*
    |--------------------------------------------------------------------------
    | Fonction permettant d'envoyer un message flash d'erreur
    |--------------------------------------------------------------------------
    |
    | @param $message
    |
    */
    // flashError(message){
    //   var $divError = '<div class="alert alert_error"/>';
    //   $('.alert_container').prepend($divError);
    //   $('.alert_error').text(message);
    //   $('.alert_error').show().delay(6000).fadeOut(200, ){
    //     this.remove();
    //   });
    // }

    /*
    |--------------------------------------------------------------------------
    | Simule la fonction in_array de php
    |--------------------------------------------------------------------------
    |
    | Cherche un élément (needle) dans un tableau (haystack) et retourne true
    | si il a été trouvé
    |
    */
    inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(typeof haystack[i] == 'object') {
            if(arrayCompare(haystack[i], needle)) return true;
        } else {
            if(haystack[i] == needle) return true;
        }
    }
    return false;
    }


    /*
    |--------------------------------------------------------------------------
    | Fonctions pour rendre le tri de tableau insensible à la casse.
    |--------------------------------------------------------------------------
    */
    charOrdA(a, b)
    {
    a = a.toLowerCase(); b = b.toLowerCase();
    if (a>b) return 1;
    if (a <b) return -1;
    return 0;
    }

    charOrdD(a, b)
    {
    a = a.toLowerCase(); b = b.toLowerCase();
    if (a<b) return 1;
    if (a >b) return -1;
    return 0;
    }


    /*
    |--------------------------------------------------------------------------
    | Ne conserve qu'un certain nombre de caractère d'une chaine à partir de
    | la droite
    |--------------------------------------------------------------------------
    */
    right(str,n)
    {
    if (n>=str.length){return str;}
    if (n<=0){return "";}
    var newStr=str.substring(str.length,str.length-n);
    return newStr;
    }

    /*
    |--------------------------------------------------------------------------
    | Supprime un certain nombre de caractères à la fin d'une chaine
    |--------------------------------------------------------------------------
    */
    cutRight(string,n)
    {
    if (n>=string.length){return "";}
    if (n<=0){return string;}
    var newStr=string.substring(0,string.length-n);
    return newStr;
    }

    /*
    |--------------------------------------------------------------------------
    | Fonction de slugification de chaîne de caractère. Fonctionne pour toutes
    | les langues avec un alphabet latin, y compris les langues possédant
    | des caractère accentués
    |--------------------------------------------------------------------------
    |
    */
    slugify(value) {

    value = this.neutralize(value)

    // 1) met en bas de casse
    // 2) remplace les espace par des tirets
    // 3) enleve tout les caratères non alphanumeriques
    // 4) enlève les doubles tirets
    return value.replace(/\s+/g, '-')
                .replace(/[^a-z0-9-]/g, '')
                .replace(/\-{2,}/g,'-');
    };


    /*
    |--------------------------------------------------------------------------
    | Fonction remplaçant les caractères accentués par leur équivalent sans
    | accent
    |--------------------------------------------------------------------------
    */
    removeAccents(value) {
    var rExps=[
    {re:/[\xC0-\xC6]/g, ch:'A'},
    {re:/[\xE0-\xE6]/g, ch:'a'},
    {re:/[\xC8-\xCB]/g, ch:'E'},
    {re:/[\xE8-\xEB]/g, ch:'e'},
    {re:/[\xCC-\xCF]/g, ch:'I'},
    {re:/[\xEC-\xEF]/g, ch:'i'},
    {re:/[\xD2-\xD6]/g, ch:'O'},
    {re:/[\xF2-\xF6]/g, ch:'o'},
    {re:/[\xD9-\xDC]/g, ch:'U'},
    {re:/[\xF9-\xFC]/g, ch:'u'},
    {re:/[\xC7-\xE7]/g, ch:'c'},
    {re:/[\xD1]/g, ch:'N'},
    {re:/[\xF1]/g, ch:'n'} ];

    // converti les caractères accentués en leurs équivalent alpha
    for(var i=0, len=rExps.length; i<len; i++)
    value=value.replace(rExps[i].re, rExps[i].ch);

    return value;
    };


    /*
    |--------------------------------------------------------------------------
    | Permet de rendre neutre une chaine de caractères en enlevant les
    | accents et en la mettant en minuscule
    |--------------------------------------------------------------------------
    */
    neutralize(str){
    return this.removeAccents(str).toLowerCase()
    }


    /*
    |--------------------------------------------------------------------------
    | Fonction déterminant si une string se trouve dans une autre
    |
    | @param needle
    | @param haystack
    |
    | @return boolean
    |--------------------------------------------------------------------------
    */
    in_str(needle, haystack){
    if(haystack.indexOf(needle)>-1){
      return true;
    }
    return false;
    }


    /*
    |--------------------------------------------------------------------------
    | Fonction permettant de connaitre la largeur de l'ascenseur du navigateur
    |--------------------------------------------------------------------------
    */
    getScrollbarWidth() {
    var outer = document.createElement("div");
    outer.style.visibility = "hidden";
    outer.style.width = "100px";
    document.body.appendChild(outer);

    var widthNoScroll = outer.offsetWidth;
    // force scrollbars
    outer.style.overflow = "scroll";

    // add innerdiv
    var inner = document.createElement("div");
    inner.style.width = "100%";
    outer.appendChild(inner);

    var widthWithScroll = inner.offsetWidth;

    // remove divs
    outer.parentNode.removeChild(outer);

    return widthNoScroll - widthWithScroll;
    }


    /*
    |--------------------------------------------------------------------------
    | Permet d'étendre des objets
    |--------------------------------------------------------------------------
    */
    extend() {
    // Variables
    var extended = {};
    var deep = false;
    var i = 0;
    var length = arguments.length;

    // Check if a deep merge
    if ( Object.prototype.toString.call( arguments[0] ) === '[object Boolean]' ) {
        deep = arguments[0];
        i++;
    }

    // Merge the object into the extended object
    var merge = function (obj) {
        for ( var prop in obj ) {
            if ( Object.prototype.hasOwnProperty.call( obj, prop ) ) {
                // If deep merge and property is an object, merge properties
                if ( deep && Object.prototype.toString.call(obj[prop]) === '[object Object]' ) {
                    extended[prop] = extend( true, extended[prop], obj[prop] );
                } else {
                    extended[prop] = obj[prop];
                }
            }
        }
    };

    // Loop through each object and conduct a merge
    for ( ; i < length; i++ ) {
        var obj = arguments[i];
        merge(obj);
    }

    return extended;
    };


    nl2br (str, is_xhtml) {
      var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
      return (str + '').replace(/([^>\\r\\n]?)(\\r\\n|\\n\\r|\\r|\\n)/g, '$1' + breakTag + '$2');
    }
}


export default new $()
