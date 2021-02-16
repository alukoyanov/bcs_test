<?php

use yii\db\Migration;

/**
 * Class m210215_161116_add_users
 */
class m210215_161116_add_users extends Migration
{
    private $_usersToAdd = [
        1 => [
            'username'             => 'admin',
            'password_hash'        => '$2y$10$c2NbEBdzPBgiQZ6av2UlkOYO8jlFV9P.2CEU/3T1JUtqr/f3cRs4q',
            'auth_key'             => '523cdd2d3b4c574062c0d7fb70a3a0af',
            'password_reset_token' => '519f7d77bdb180095d9e823cd67224b9',
            'email'                => 'admin@test.com',
        ],
        2 => [
            'username'             => 'moderator',
            'password_hash'        => '$2y$10$DVKcf35bC49v8WIESOa20OOcggdBlM3sX8zkO72Od6/OjctpXCezu',
            'auth_key'             => '9c2762c89b50530577634c6ea8fc1b78',
            'password_reset_token' => '0faa8714db35e86c8ec3252ef086357f',
            'email'                => 'moderator@test.com',
        ],
        3 => [
            'username'             => 'user',
            'password_hash'        => '$2y$10$YgOYZGefXyQjGpBSDh7ZJO/ueyN09sc9hbS3ygo.FE4ETUZjr7O.G',
            'auth_key'             => 'cc7c1df84fae547f797f572c566b0f2e',
            'password_reset_token' => '8c84badd4750df073cd3d60c4a6a40e5',
            'email'                => 'user@test.com',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        foreach ($this->_usersToAdd as $id => $data) {
            $this->insert('{{%user}}', \yii\helpers\ArrayHelper::merge(
                [
                    'id' => $id,
                    'created_at' => time(),
                    'updated_at' => time(),
                ],
                $data
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        foreach ($this->_usersToAdd as $id => $data) {
            $this->delete('{{%user}}', ['id' => $id]);
        }
    }
}
