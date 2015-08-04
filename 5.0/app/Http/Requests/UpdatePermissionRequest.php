<?php
namespace App\Http\Requests;
use App\Http\Requests\Request, Route, \App\Role;

/**
 * UpdatePermissionRequest
 * File : /5.0/app/Http/Requests/UpdatePermissionRequest.php
 *
 * PHP version 5.4
 *
 * @category Easy Payments
 * @package  Easy Payments
 * @author   Jason Turpin <jasonaturpin@gmail.com>
 */

/**
 * UpdatePermissionRequest - Used for validating requests to add or edit a role permission group
 *
 * @category Easy Payments
 * @package  Easy Payments
 * @author   Jason Turpin <jasonaturpin@gmail.com>
 */
class UpdatePermissionRequest extends Request {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        // @todo add a role test for admin
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        // Validation rules
        $rules = array(
            'label'    => 'required|unique:Permissions,label,'.Route::current()->parameter('permission_id').',permission_id',
            'isActive' => 'required|in:0,1',
        );

        /** $var \Illuminate\Database\Eloquent\Collection $Roles */
        $Roles = Role::active()->get();

        // IF Roles exist, add roles condition
        if ($Roles->count() > 0) {
            // Gets the array of keys
            $keys = $Roles->modelKeys();

            // Add roles to the IN statement
            $rules['roles'] = 'array|in:'.implode(',', $keys);
        }
        return $rules;
    }

    /**
     * Sets the error messages to be returned
     *
     * @return array
     */
    public function messages() {
        return [
            'label.required'    => 'The permissions name field is required.',
            'isActive.required' => 'A valid "is active" value is required.',
            'isActive.in:0,1'   => 'A valid "is active" value is required.',
        ];
    }
}
