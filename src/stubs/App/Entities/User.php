<?php

namespace Entities;

use Entities\Droit;
use Illuminate\Support\Facades\Cache;
use Illuminate\Notifications\Notifiable;
use App\Notifications\UserPasswordResetEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'email', 'password', 'last_name', 'first_name', 'locked', 'genre', 'avatar', 'order'
	];

	protected $casts = [
        'locked' => 'boolean'
    ];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token', 'api_token'
	];


	protected $appends = [
		'fullname', 'avatarPath'
	];

	protected $avatarsPath = 'data/app/avatars';


	public static function boot() {
      parent::boot();

      self::creating(function($users) {
        $users->api_token = \Hash::make(\Carbon\Carbon::now()->toRfc2822String());
      });
    }

	/**
	 * Relation liant un utilisateur et ses droits
	 *
	 * @return  Illuminate\Database\Eloquent\Builder
	 */
	public function droits()
	{
		return $this->belongsToMany(Droit::class);
	}

	/**
	* Surcharge de la méthode 'sendPasswordResetNotification'
	* Envoi une notification de réinitialisation de password
	*
	* @param  string  $token
	* @return void
	*/
	public function sendPasswordResetNotification($token)
	{
		$this->notify(new UserPasswordResetEmail($token));
	}


	/**
	 * Construit le nom complet de l'utilisateur
	 *
	 * @return  String
	 */
	public function getFullnameAttribute()
	{
		return sprintf('%s %s', $this->first_name, $this->last_name);
	}


	/**
	 * Construit l'avatar de l'utilisateur
	 *
	 * @return  String
	 */
	public function getAvatarPathAttribute()
	{
		return sprintf('/%s/%s/%s.png', $this->avatarsPath, $this->genre, $this->avatar);
	}


	/**
	 * Calcul le numéro à partir du nom de fichier fourni
	 *
	 * @param  String  $value
	 */
	public function setAvatarAttribute($value)
	{
		$this->attributes['avatar'] = pathinfo($value, PATHINFO_FILENAME);
	}


	/**
	 * Retourne le statut du compte de l'utilisateur
	 *
	 * @return  Boolean
	 */
	public function isLocked()
	{
		return $this->locked;
	}


	/**
	 * Indique si l'utilisateur à le droit de faire l'action donnée
	 * et met en cache le résultat
	 *
	 * @param   String $action
	 *
	 * @return  Boolean
	 */
	public function canManage($action)
	{
		return $this->load(['droits' => function($query) use($action){
			$query->where('slug', $action);
		}])->droits->count()>0;
	}


	/**
	 * Attribue un droit à un utilisateur
	 *
	 * @param   String $right
	 *
	 * @return  void
	 */
	public function grant($right)
	{
		$droit = Droit::where('slug', $right)->first();

		$this->droits()->sync($droit->id, false);
	}


	/**
	 * Supprime un droit à un utilisateur
	 *
	 * @param   String $right
	 *
	 * @return  void
	 */
	public function revoke($right)
	{
		$droit = Droit::where('slug', $right)->first();

		$this->droits()->detach($droit->id, false);

		$this->bustCache($right);
	}


	/**
	 * Supprime le cache pour cet utilisateur et ce droit
	 *
	 * @param   String  $right
	 *
	 * @return  void
	 */
	public function bustCache($right)
	{
		Cache::forget($this->user_right_cache_key($right));
	}

	/**
	 * Retourne la clé du cache pour un droit et un utilisateur
	 *
	 * @param   String  $right
	 *
	 * @return  String
	 */
	public function user_right_cache_key($right)
	{
		return "user-".$this->id.'-droits-'.$right;
	}
}
