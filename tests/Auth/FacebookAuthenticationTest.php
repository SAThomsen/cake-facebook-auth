<?php
namespace SAThomsen\FacebookAuth\Auth\Test\TestCase\Auth;
use SAThomsen\FacebookAuth\Auth\FacebookAuthenticate;
use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;
/**
 * Test case for JwtAuthentication.
 */
class FacebookAuthenticateTest extends TestCase
{
    public $fixtures = [
        'plugin.SAThomsen\FacebookAuth.users',
        'plugin.SAThomsen\FacebookAuth.social_profiles',
    ];
}
