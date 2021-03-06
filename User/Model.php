<?php

/**
 * Description of User
 *
 * @author bajt
 */

namespace Wbengine\User;

use Wbengine\Db;
use Wbengine\Model\ModelAbstract;
use Wbengine\User;


class Model extends ModelAbstract
{


    /**
     * Should contain an user ID.
     * (1 => ANONIMOUS or 2 => an real user ID)
     * @var integer
     */
//    private $_userId = null;

    /**
     * User's data resource.
     * @var array
     */
//    private $_resource = array();

    /**
     * Site session.
     * @var array
     */
//    private $_session = null;

    /**
     * Instance of database connection
     * @var Zend_Db_Adapter_Pdo_Mysql
     */
//    private $_db = NULL;


    /**
     * This magis method set an value togivenindex.
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        if (is_array($value)) {
            $this->$key = $value;
        } else {
            $this->_resource[$key] = $value;
        }
    }


    /**
     * Return session instance
     * @return Class_Session_Abstract
     */
    public function getSessionxxxx()
    {
        if (NULL === $this->_session) {
            $this->_setSession();
        }

        return $this->_session;
    }


    /**
     * Return user's data record from database.
     * @param integer $userId
     * @throws UserException
     * @return array
     */
    public function loadUserDataFromModel($userId = NULL)
    {

        if (NULL === $userId) {
            throw new UserException(__METHOD__ . ': The users ID can no be null!.');
        } else {
//            $where = array($userId);

            $sql = sprintf('SELECT * FROM %s WHERE user_id = %d LIMIT 1'
                , S_TABLE_USERS
                , $userId
            );

            return Db::fetchAssoc($sql);      }
    }


    public function update($user){
        $query = Db::createUpdateQuery(
            S_TABLE_USERS,
            $user->toArray(),
            array(
                sprintf("user_id = %d", $user->getUserId())
            )
        );
        Db::query($query);

        return Db::getAffected();
    }



    /**
     * Return user's stored data as array
     * @return array
     */
    public function getIdentityxxxx()
    {
        $this->_userId = $this->getSession()->getValue('user_id', ANONYMOUS);

        if ($this->_userId === ANONYMOUS) {
            $this->getSession()->setValue('user_is_logged', FALSE);
        }

        return $this->_resource = $this->loadUserDataFromModel($this->_userId);
    }


    /**
     * We try authenticate user and return user's ID on success
     * or FALSE on failed authentisation.
     *
     * @param User $user
     * @return array
     */
    public function authenticate(User $user)
    {
        $sql = sprintf("SELECT * FROM %s
			WHERE MD5(email) = '%s'
			AND password = '%s' LIMIT 1;"
            , S_TABLE_USERS
            , $user->_getLoginName()
            , $user->_getPassword()
        );

        return Db::fetchAssoc($sql);

    }


    /**
     * This method do logout user from the existing
     * session and destroy them.
     * @void
     */
    public function logoutxxx()
    {
        $this->getSession()->destroy();
    }


    /**
     * Reaturn TRUE if user's IP is banned.
     * @return bollean
     */
    public function isUserBannedxxx()
    {
        $db = $this->_db;
        $sql = sprintf("SELECT ban_id FROM %s
                        WHERE banned_ip = %s LIMIT 1;"
            , S_TABLE_BANS
            , $this->getUserIp()
        );

        $result = $db->sql_query($sql);
        $row = $db->sql_fetchrow($result);

        return ($row)
            ? true
            : false;
    }


    /**
     * Create and store new session instance object to local variable.
     */
    private function _setSessionxxxx()
    {
        $this->_session = new Class_Session();

        if (!$this->_session instanceof Class_Session_Abstract) {
            require_once 'Class/User/SessionException.php';
            throw new Class_User_Exception('Invalid table data gateway provided');
        }
    }


}
