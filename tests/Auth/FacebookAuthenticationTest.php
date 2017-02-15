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

    /**
     * Facebook token
     *
     * @var string
     **/
    protected $_token;


    /**
     * Setup general environment
     *
     * @return void
     */
    public function setUp() 
    {
        parent::setUp();

        Security::salt('secret-key');
        $this->Registry = $this->createMock('Cake\Controller\ComponentRegistry');
        $this->response = $this->createMock('Cake\Network\Response');
        $this->Auth = new FacebookAuthenticate($this->Registry, []);

        // Configure facebook
        Configure::write('facebook.appId', 'APP_ID');
        Configure::write('facebook.appSecret', 'APP_SECRET');
        Configure::write('facebook.graphVersion', 'v2.8');
        Configure::write('facebook.fields', 'id,name,first_name,middle_name,last_name,gender,email');

        $this->_token = "FACEBOOK_TOKEN";
    }

     /**
      * @test
      */
     public function getUserViaTokenInHeader()
     {
        $request = new Request('posts/index');
        $request->env('HTTP_AUTHORIZATION', 'facebook ' . $this->_token);
        $result = $this->Auth->getUser($request, $this->response);

        $expected = [
            'id' => 1,
            'active' => true
        ];

        $this->assertEquals($expected, $result);
     }

     /**
      * @test
      */
     public function getUserViaTokenInQueryParam()
     {
        $qParam = 'facebook';
        $this->Auth = new FacebookAuthenticate($this->Registry, ['parameter' => $qParam ]);
        $request = new Request('posts/index?'. $qParam . '=' . $this->_token);
        $result = $this->Auth->getUser($request, $this->response);

        $expected = [
            'id' => 1,
            'active' => true
        ];

        $this->assertEquals($expected, $result);
     }

     /**
      * @test
      */
     public function getUserQueryParameterNotSet()
     {
        $qParam = 'facebook';
        $this->Auth = new FacebookAuthenticate($this->Registry, []);
        $request = new Request('posts/index?'. $qParam . '=' . $this->_token);
        $result = $this->Auth->getUser($request, $this->response);

        $this->assertFalse($result);
     }

     /**
      * @test
      */
     public function getUserNoToken()
     {
        $this->Auth = new FacebookAuthenticate($this->Registry, []);
        $request = new Request('posts/index?');
        $result = $this->Auth->getUser($request, $this->response);

        $this->assertFalse($result);
     }
}
