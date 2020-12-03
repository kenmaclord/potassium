<h1 class="user-name">
	<div class="identite">
		<img :src="user.avatarPath" alt="">
		@{{user.fullname}}
	</div>

	<div class="field">
		<div class="control">
					<a href="#" class="button is-fullwidth" :class="{'is-success': !user.locked, 'is-danger': user.locked}" @click.prevent="toggleLock">
				<span class="icon">
					<i class="fa" :class="{'fa-unlock-alt': !user.locked, 'fa-lock': user.locked}"></i>
				</span>
						<span v-text="accountStatus"></span>
					</a>
		</div>
	</div>
</h1>
