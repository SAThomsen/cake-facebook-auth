<?php
namespace SAThomsen\FacebookAuth\Test\Fixture;
use Cake\TestSuite\Fixture\TestFixture;
class UsersFixture extends TestFixture
{
    /**
     * fields property.
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'user_name' => ['type' => 'string', 'null' => false],
        'email' => ['type' => 'string', 'null' => false],
        'password' => ['type' => 'string', 'null' => false],
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
