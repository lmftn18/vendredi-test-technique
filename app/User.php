<?php

namespace App;

use Backpack\CRUD\CrudTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use MandrillMail;

class User extends Authenticatable
{
    use Notifiable;
    
    use CrudTrait;
    
    protected $guarded = ['id'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'firstname', 'lastname', 'email', 'password', 'is_admin'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      'password', 'remember_token',
    ];
    
    protected $attributes = [
      'is_admin' => false,
    ];
    
    public function candidate()
    {
        return $this->hasOne('App\Candidate');
    }
    
    public function hasRole($role)
    {
        if ($role === 'admin') {
            return $this->is_admin;
        } elseif ($role === 'candidate') {
            return $this->candidate !== null;
        }
        return false;
    }
    
    /**
     * Send the password reset notification.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        
        $template_name = 'mot-de-passe-oubli';
        $template_content = [];
        
        $message = [
          'subject' => 'Vendredi - Mot de passe oublié',
          'from_email' => config('mail.from.address'),
          'from_name' => config('mail.from.name'),
          'to' => [
            ['email' => $this->email]
          ],
          'merge_vars' => [
            [
              'rcpt' => $this->email,
              'vars' => [
                ['name' => 'RESET_PASSWORD_URL', 'content' => url('/password/reset', [$token])]
              ]
            ]
          ]
        ];
        
        MandrillMail::messages()->sendTemplate($template_name, $template_content, $message);
    }
    
    /**
     * Send the welcome email
     *
     * @return void
     */
    public function sendWelcomeEmail()
    {
        
        $template_name = 'bienvenue-aux-nouveaux-inscrits-sur-le-site';
        $template_content = [];
        
        $message = [
          'subject' => 'Vendredi - Bienvenue',
          'from_email' => config('mail.from.address'),
          'from_name' => config('mail.from.name'),
          'to' => [
            ['email' => $this->email]
          ],
        ];
        try {
            MandrillMail::messages()->sendTemplate($template_name, $template_content, $message);
        } catch (\Exception $e){
            // Do nothing if it fails
            \Log::alert("Welcome email not sent for : " . $this->email);
            return ;
        }
        
    }
    
    
    public function getNameAttribute()
    {
        return implode(' ', [$this->firstname, $this->lastname]);
    }
}
