<?php
namespace App\Http\Requests;
use App\Http\Requests\Request, Route;

/**
 * UpdateRoleRequest
 * File : /5.0/app/Http/Requests/UpdateRoleRequest.php
 *
 * PHP version 5.5
 *
 * @category Easy Payments
 * @package  Easy Payments
 * @author   Jason Turpin <jasonaturpin@gmail.com>
 */

/**
 * UpdateRoleRequest - Used for validating requests to add or edit a role
 *
 * @category Easy Payments
 * @package  Easy Payments
 * @author   Jason Turpin <jasonaturpin@gmail.com>
 */
class UpdateRoleRequest extends Request {
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
        return [
            'label'    => 'required|unique:Roles,label,'.Route::current()->parameter('role_id').',role_id',
            'isActive' => 'required|in:0,1'
        ];
    }

    /**
     * Sets the error messages to be returned
     *
     * @return array
     */
    public function messages() {
        return [
            'label.required'    => 'The role name field is required.',
            'isActive.required' => 'A valid "is active" value is required.',
            'isActive.in:0,1'   => 'A valid "is active" value is required.',
        ];
    }

}
