<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Spatie\Permission\Models\Role;

class SelectUserRole implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $rol = Role::where('name', $value)->first();
        $isValidRole = false;

        if (!is_null($value) && !is_null($rol)) {
            $isValidRole = true;
        }

        return $isValidRole;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Debe elegir un rol válido para el usuario.';
    }
}
