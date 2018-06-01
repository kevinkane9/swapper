<?php

namespace Sapper;

class User {

    public static function can($permission) {
        $permissions = Auth::token('permissions');
        return in_array('super-admin', $permissions) || in_array($permission, $permissions);
    }
}