<div class="header">

  <button class="hamburger hamburger--squeeze" :class="{'is-active': menuOpen}" type="button" @click="menuOpen= !menuOpen">
    <span class="hamburger-box">
      <span class="hamburger-inner"></span>
    </span>
  </button>

  <div class="avatar">
    <img src="{{asset(auth()->user()->avatarPath)}}" alt="">
    <span class="name">{{auth()->user()->fullname}}</span>
  </div>

  <div class="actions">
    <session-expiration idle-timeout="{{config('session.lifetime')}}"></session-expiration>

    <a href="/" class="button is-primary is-outlined site" target="_blank">
      <span class="icon">
        <i class="fa fa-share"></i>
      </span>
      <span>Voir le site</span>
    </a>



    <form action="/logout" id="logout" method="POST">
      {{ csrf_field()}}
      <button type="submit" class="button is-danger is-outlined">
        <span class="icon" style="margin-right: 5px">
          <i class="fa fa-sign-out"></i>
        </span>
        Se déconnecter
      </button>
    </form>

  </div>
</div>
