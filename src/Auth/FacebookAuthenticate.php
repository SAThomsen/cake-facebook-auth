<?php
namespace SAThomsen\FacebookAuth\Auth;

use Cake\Auth\BaseAuthenticate;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use FacebookAuth\Controller\Component\FacebookComponent;
use Cake\Log\Log;

class FacebookAuthenticate extends BaseAuthenticate
{

    /**
     * Parsed token.
     *
     * @var string|null
     */
    protected $_token;

    /**
     * Payload data.
     *
     * @var object|null
     */
    protected $_payload;

    /**
     * Exception.
     *
     * @var \Exception
     */
    protected $_error;

    public function __construct(ComponentRegistry $registry, $config)
    {
        $this->config([
            'header' => 'authorization',
            'prefix' => 'facebook',
            'parameter' => 'token',
            'fields' => ['username' => 'email'],
            'unauthenticatedException' => '\Cake\Network\Exception\UnauthorizedException',
            'key' => null,
        ]);

        parent::__construct($registry, $config);
    }

    /**
     * Get user record based on info available in JWT.
     *
     * @param \Cake\Network\Request $request The request object.
     * @param \Cake\Network\Response $response Response object.
     *
     * @return bool|array User record array or false on failure.
     */
    public function authenticate(Request $request, Response $response)
    {
        return $this->getUser($request);
    }

    public function getUser(Request $request)
    {
        $token = $this->getToken($request);

        if(empty($token)) {
            return false;
        }

        $fB = new FacebookComponent;
        $fBUser = $fB->getFacebookUser($token);
        if (empty($fBUser)) {
            return false;
        }

        $user = $this->_findUser($fBUser['email']);
        if ($user) {
            return $user['user'];
        }
        return false;
    }

    /**
     * Get token from header or query string.
     *
     * @param \Cake\Network\Request|null $request Request object.
     *
     * @return string|null Token string if found else null.
     */
    private function getToken($request = null)
    {
        $config = $this->_config;

        if (!$request) {
            return $this->_token;
        }
        $header = $request->header($config['header']);

        if ($header) {
            $subHeader = substr($header, 0, strlen($config['prefix']));
            if ($config['prefix'] == $subHeader) {
                return $this->_token = str_ireplace($config['prefix'] . ' ', '', $header);
            }
        }

        if (!empty($this->_config['parameter'])) {
            $token = $request->query($this->_config['parameter']);
        }

        return $this->_token = $token;
    }
}
