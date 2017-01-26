<?php
namespace SAThomsen\FacebookAuth\Test\Fixture;
use Cake\TestSuite\Fixture\TestFixture;
class SocialProfilesFixture extends TestFixture
{
    /**
     * fields property.
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'user_id' => ['type' => 'string', 'null' => false],
        'provider' => ['type' => 'string', 'null' => false],
        'identifier' => ['type' => 'string', 'null' => false],
        'email' => ['type' => 'string', 'null' => false],
        'name' => ['type' => 'string', 'null' => false],
        'first_name' => ['type' => 'string', 'null' => true],
        'middle_name' => ['type' => 'string', 'null' => true],
        'last_name' => ['type' => 'string', 'null' => true],
        'gender' => ['type' => 'string', 'null' => true],
        'birthday' => ['type' => 'string', 'null' => true],
        'created' => 'datetime',
        'updated' => 'datetime',
        '_constraints' => ['primary' => ['type' => 'primary', 'columns' => ['id']]],
    ];
    /**
     * records property.
     *
     * @var array
     */
    public $records = [
        [
            'user_name' => 'sathomsen',
            'email' => 'sathomsen@example.com',
            'password' => '12345678',
            'created' => '2014-03-17 01:18:23',
            'updated' => '2014-03-17 01:20:31',
        ],
    ];
}
