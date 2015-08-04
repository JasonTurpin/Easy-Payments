<?php
namespace App\Http\Requests;
use App\Http\Requests\Request, \App\Role;

/**
 * UpdateUserRequest
 * File : /5.0/app/Http/Requests/UpdateUserRequest.php
 *
 * PHP version 5.5
 *
 * @category Easy Payments
 * @package  Easy Payments
 * @author   Jason Turpin <jasonaturpin@gmail.com>
 */

/**
 * UpdateUserRequest - Used for validating user accounts
 *
 * @category Easy Payments
 * @package  Easy Payments
 * @author   Jason Turpin <jasonaturpin@gmail.com>
 */
class UpdateUserRequest extends Request {
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
            'password'  => 'same:password2|regex:'.config('app.pwRegex'),
            'isActive'  => 'required|in:0,1',
            'firstName' => 'required',
            'lastName'  => 'required',
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
            'password.same:password2' => 'The password fields must match.',
        ];
    }
}
