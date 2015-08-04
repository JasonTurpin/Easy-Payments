<?php
namespace app;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Hash;
use \Illuminate\Database\Eloquent\Model;

/**
 * User Model
 * File : /5.0/app/User.php
 *
 * PHP version 5.4
 *
 * @category Easy Payments
 * @package  Easy Payments
 * @author   Jason Turpin <jasonaturpin@gmail.com>
 */

/**
 * User - Base model for user details
 *
 * @category Easy Payments
 * @package  Easy Payments
 * @author   Jason Turpin <jasonaturpin@gmail.com>
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract {
    use Authenticatable, CanResetPassword;

    /**
     * @var string - The database table used by the model
     */
    protected $table = 'Users';

    /**
     * @var string - Primary key
     */
    protected $primaryKey = 'user_id';

    /**
     * @var array - Fields allowed for mass assignment
     */
    protected $fillable = array('firstName', 'lastName', 'isActive');

    /**
     * Adds an email address condition to the WHERE statement
     *
     * @param \Illuminate\Database\Eloquent\Builder $query Query Object
     * @param string                                $email Email being searched for
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEmail($query, $email) {
        return $query->where('email', '=', $email);
    }

    /**
     * Adds a username condition to the WHERE statement
     *
     * @param \Illuminate\Database\Eloquent\Builder $query  Query Object
     * @param string                                $pwHash Password hash being searched for
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePwHash($query, $pwHash) {
        return $query->where('pwHash', '=', $pwHash);
    }

    /**
     * Fetches active users
     *
     * @param \Illuminate\Database\Eloquent\Builder $query Query Object
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query) {
        return $query->where('isActive', '=', '1');
    }

    /**
     * IF the current user has the given role
     *
     * @param string $roleStr Role string
     *
     * @return bool
     */
    public function roleTest($roleStr) {
        // Loop over the user's roles
        foreach ($this->roles as $role) {
            // IF the current role matches the test string
            if ($role->label == $roleStr) {
                return true;
            }
        }
        return false;
    }

    /**
     * Syncs user role data
     *
     * @param array $userRoleData Array of User Roles
     *
     * @return array
     */
    public function syncRoles($userRoleData) {
        return $this->roles()->sync($userRoleData);
    }

    /**
     * Returns the login hash for the user
     *
     * @return string
     */
    public function fetchHash() {
        return hash("sha256", $this->user_id.$this->email.config('app.loginSalt'));
    }

    /**
     * Joins with Roles
     *
     * @return Object
     */
    public function roles() {
        return $this->belongsToMany('\App\Role', 'UsersRoles', 'user_id', 'role_id');
    }

    /**
     * Sets password hash
     *
     * @param string $password Password
     *
     * @return void
     */
    public function setPassword($password) {
        $this->password = Hash::make($password);
    }
}
/*
+------------+------------------+------+-----+---------------------+-----------------------------+
| Field      | Type             | Null | Key | Default             | Extra                       |
+------------+------------------+------+-----+---------------------+-----------------------------+
| user_id    | int(11) unsigned | NO   | PRI | NULL                | auto_increment              |
| firstName  | varchar(100)     | NO   |     | NULL                |                             |
| lastName   | varchar(100)     | NO   |     | NULL                |                             |
| email      | varchar(100)     | NO   | UNI | NULL                |                             |
| password   | varchar(255)     | NO   |     | NULL                |                             |
| isActive   | tinyint(1)       | NO   |     | 1                   |                             |
| created_at | timestamp        | NO   |     | CURRENT_TIMESTAMP   | on update CURRENT_TIMESTAMP |
| updated_at | timestamp        | NO   |     | 0000-00-00 00:00:00 |                             |
+------------+------------------+------+-----+---------------------+-----------------------------+
*/
