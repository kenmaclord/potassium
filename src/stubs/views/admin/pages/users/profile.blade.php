<div class="profile-page">
	<div class="columns">
		<div class="column">
			<div class="field">
				<label class="label">Prénom</label>
				<div class="control has-icons-left">
					<input class="input" :class="{'is-danger': user.errors.has('first_name')}" type="text" placeholder="Prénom" v-model="user.first_name">
					<span class="icon is-small is-left">
						<i class="fa fa-user"></i>
					</span>
				</div>
				<span class="help is-danger" v-if="user.errors.has('first_name')" v-text="user.errors.get('first_name')"></span>
			</div>
	  	</div>
		<div class="column">
			<div class="field">
				<label class="label">Nom</label>
				<div class="control has-icons-left">
					<input class="input" :class="{'is-danger': user.errors.has('last_name')}" type="text" placeholder="Nom de famille" v-model="user.last_name">
					<span class="icon is-small is-left">
							<i class="fa fa-users"></i>
					</span>
				</div>
				<span class="help is-danger" v-if="user.errors.has('last_name')" v-text="user.errors.get('last_name')"></span>
			</div>
		</div>
	</div>

	<div class="columns">
		<div class="column">
			<div class="field">
				<label class="label">Adresse email</label>
				<div class="control has-icons-left">
					<input class="input" :class="{'is-danger': user.errors.has('email')}" type="email" placeholder="Adresse email" v-model="user.email">
					<span class="icon is-small is-left">
							<i class="fa fa-at"></i>
					</span>
				</div>
				<span class="help is-danger" v-if="user.errors.has('email')" v-text="user.errors.get('email')"></span>
			</div>
		</div>

		<div class="column">
			<div class="field">
				<label class="label">Genre</label>
				<div class="control">
					<div class="select is-fullwidth">
						<select v-model="user.genre">
							<option value="masculin">Masculin</option>
							<option value="feminin">Féminin</option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="field">
		<label class="label">Avatar</label>
	</div>

	<div class="box">
		<div class="avatars">
			<img
				v-for="avatar in avatars"
				:src="avatar"
				class="avatar-choice"
				:class="{active: isActive(avatar)}"
				@click="setAvatar(avatar)">
		</div>
	</div>


	<div class="field">
		<div class="control">
			<a href="#" class="button is-primary is-outlined is-fullwidth" @click.prevent="save">
				<span class="icon">
					<i class="fa fa-download" :class="{'fa-circle-o-notch fa-spin fa-fw': isLoading}"></i>
				</span>
			  <span>Sauvegarder le profile</span>
			</a>
		</div>
	</div>
</div>
