<?php
namespace SAThomsen\FacebookAuth\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Facebook\Facebook;

class FacebookComponent extends Component {

    /**
     * Facebook app id
     *
     * Can be found under app settings on facebook.
     *
     * @var string|null
     */
    protected $_appId;

    /**
     * Facenbook app secret
     *
     * Can be found under app settings on facebook, requires login.
     *
     * @var string|null
     */
    protected $_appSecret;

    /**
     * Facenbook app secret
     *
     * Describes the version of the graph API in use. It's important that the format is correct.
     * ie. 'v2.4'.
     *
     * @var string|null
     */
    protected $_graphVersion;

    /**
     * Facenbook fields
     *
     * The data fields that is fetched in the call to the graph.
     *
     * @var string|null
     */
    protected $_fields;

    public function __construct() {
        $fBConfig = Configure::read('facebook');
        $this->_appId = $fBConfig['appId'];
        $this->_appSecret = $fBConfig['appSecret'];
        $this->_graphVersion = $fBConfig['graphVersion'];
        $this->_fields = $fBConfig['fields'];
    }

    /**
     *  Fetches an profile that has authori
     *
     */
    public function getFacebookUser($token)
    {
        $fb = $this->getFacebookObject();
        try {
            $response = $fb->get('/me?fields=' . $this->_fields, $token);
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $userArray = $response
                ->getGraphUser()
                ->uncastItems();

        $userArray['identifier'] = $userArray['id'];
        unset($userArray['id']);

        return $userArray;
    }

    private function getFacebookObject()
    {
        $fBConfig = Configure::read('facebook');
        return new Facebook([
            'app_id' => $this->_appId,
            'app_secret' => $this->_appSecret,
            'default_graph_version' => $this->_graphVersion,
        ]);
    }
}
