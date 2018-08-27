<?php

namespace App;

use Illuminate\Auth\Authenticatable;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
// !!! это я перезаписал https://github.com/laravel/framework/blob/5.6/src/Illuminate/Foundation/Auth/User.php, мне нужно было сделать наследование всех моделей от моей BaseModel

class AuthenticatableForUser extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     * https://github.com/tymondesigns/jwt-auth/issues/1316#issuecomment-330018396
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     * https://github.com/tymondesigns/jwt-auth/issues/1316#issuecomment-330018396
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
