<?php

namespace App\Entities;

use Illuminate\Notifications\Notifiable;
use Potassium\App\Notifications\CustomerPasswordResetEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'last_name', 'first_name', 'locked'
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
        'password', 'remember_token'
    ];



    /**
    * Surcharge de la méthode 'sendPasswordResetNotification'
    * Envoi une notification de réinitialisation de password
    *
    * @param  string  $token
    * @return void
    */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomerPasswordResetEmail($token));
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
}
