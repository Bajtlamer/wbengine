<?php
/**
 * Created by PhpStorm.
 * User: roza
 * Date: 04/07/2018
 * Time: 21:19
 */

namespace Wbengine\Api;


use Wbengine\Api;
use Wbengine\Api\Routes\ApiRoutesAbstract;
use Wbengine\Api\WbengineRestapiAbstract;
use Wbengine\Api\Model\Exception\ApiModelException;

class Auth extends WbengineRestapiAbstract implements WbengineRestapiInterface
{

//    public function getInstanceOfApiRoutes(){
//        $class = $this->createNameSpace($this->getLastPartFromNamespace(__CLASS__));
//        return new $class($this);
//    }
}