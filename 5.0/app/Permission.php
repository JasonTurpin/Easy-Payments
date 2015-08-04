<?php
namespace app;
use \Illuminate\Database\Eloquent\Model;

/**
 * Permissions Model
 * File : /5.0/app/Permission.php
 *
 * PHP version 5.4
 *
 * @category Easy Payments
 * @package  Easy Payments
 * @author   Jason Turpin <jasonaturpin@gmail.com>
 */

/**
 * Permission - Base model for permission levels
 *
 * @category Easy Payments
 * @package  Easy Payments
 * @author   Jason Turpin <jasonaturpin@gmail.com>
 */
class Permission extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'Permissions';

    /**
     * Primary key
     *
     * @var string
     */
    protected $primaryKey = 'permission_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['label', 'isActive'];

    /**
     * Joins with Roles
     *
     * @return Object
     */
    public function roles() {
        return $this->belongsToMany('\App\Role', 'PermissionsRoles', 'permission_id', 'role_id');
    }

    /**
     * Fetches active permissions
     *
     * @param Object $query Query object
     *
     * @return Object
     */
    public function scopeActive($query) {
        return $query->where('isActive', '=', '1');
    }

    /**
     * Syncs permission level role data
     *
     * @param array $permissionRoleData Array of Role IDs
     *
     * @return array
     */
    public function syncRoles($permissionRoleData) {
        return $this->roles()->sync($permissionRoleData);
    }
}
/*
+---------------+----------------------+------+-----+---------------------+-----------------------------+
| Field         | Type                 | Null | Key | Default             | Extra                       |
+---------------+----------------------+------+-----+---------------------+-----------------------------+
| permission_id | smallint(5) unsigned | NO   | PRI | NULL                | auto_increment              |
| label         | varchar(100)         | NO   |     | NULL                |                             |
| isActive      | tinyint(1)           | NO   |     | 1                   |                             |
| created_at    | timestamp            | NO   |     | CURRENT_TIMESTAMP   | on update CURRENT_TIMESTAMP |
| updated_at    | timestamp            | NO   |     | 0000-00-00 00:00:00 |                             |
+---------------+----------------------+------+-----+---------------------+-----------------------------+
*/
