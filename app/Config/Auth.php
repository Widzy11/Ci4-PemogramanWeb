<?php

namespace Config;

use Myth\Auth\Config\Auth as AuthConfig;

class Auth extends AuthConfig
{
    /**
     * Landing page after successful login.
     *
     * @var string
     */
    public $landingRoute = '/';

    /**
     * Allow user registration.
     *
     * @var bool
     */
    public $allowRegistration = true;

    /**
     * Default role assigned when a user registers via /register.
     *
     * @var string
     */
    public $defaultUserGroup = 'pengawas';

    /**
     * Disable email activation so newly registered users can log in immediately
     * on localhost without needing an SMTP mail server.
     *
     * @var string|null
     */
    public $requireActivation = null;

    /**
     * Disable email password resetter on localhost (matches video #8-1;
     * password resets are handled by Admin via Data User -> Reset Password).
     *
     * @var string|null
     */
    public $activeResetter = null;

    /**
     * Allow users to use "Remember Me" when logging in.
     *
     * @var bool
     */
    public $allowRemembering = true;

    /**
     * Redirect unauthorized users back to landingRoute with error flashdata
     * instead of throwing an unhandled PermissionException.
     *
     * @var bool
     */
    public $silent = true;
}
