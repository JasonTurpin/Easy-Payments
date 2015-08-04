<?php
namespace app;
use \Illuminate\Database\Eloquent\Model;

/**
 * Role Model
 * File : /5.0/app/Role.php
 *
 * PHP version 5.4
 *
 * @category Easy Payments
 * @package  Easy Payments
 * @author   Jason Turpin <jasonaturpin@gmail.com>
 */

/**
 * Role - Base model for role logic
 *
 * @category Easy Payments
 * @package  Easy Payments
 * @author   Jason Turpin <jasonaturpin@gmail.com>
 */
class Role extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'Roles';

    /**
     * Primary key
     *
     * @var string
     */
    protected $primaryKey = 'role_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['label', 'isActive'];

    /**
     * Joins with Users
     *
     * @return Object
     */
    public function users() {
        return $this->belongsToMany('User', 'UsersRoles', 'role_id', 'user_id');
    }

    /**
     * Fetches active roles
     *
     * @param Object $query Query object
     *
     * @return Object
     */
    public function scopeActive($query) {
        return $query->where('isActive', '=', '1');
    }
}
/*
+------------+----------------------+------+-----+---------------------+-----------------------------+
| Field      | Type                 | Null | Key | Default             | Extra                       |
+------------+----------------------+------+-----+---------------------+-----------------------------+
| role_id    | smallint(5) unsigned | NO   | PRI | NULL                | auto_increment              |
| label      | varchar(100)         | NO   |     | NULL                |                             |
| isActive   | tinyint(1)           | NO   |     | 1                   |                             |
| created_at | timestamp            | NO   |     | CURRENT_TIMESTAMP   | on update CURRENT_TIMESTAMP |
| updated_at | timestamp            | NO   |     | 0000-00-00 00:00:00 |                             |
+------------+----------------------+------+-----+---------------------+-----------------------------+
*/
