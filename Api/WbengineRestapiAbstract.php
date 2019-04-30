<?php
/**
 * Created by PhpStorm.
 * User: roza
 * Date: 04/07/2018
 * Time: 20:59
 */
namespace Wbengine\Api;

use Wbengine\Api;
use Wbengine\Api\Model\ApiSectionModel;
use Wbengine\Box\WbengineBoxAbstract;

class WbengineRestapiAbstract
{
    /**
     * @var Api
     */
    private $_api;

    public function __construct(Api $api) {
        $this->_api = $api;
    }

    public function Api() {
        if($this->_api){
            return $this->_api;
        }else{
            return $this->_api = new Api();
        }
    }


    public function getApiError($msg){
        return $this->Api()->getApiError($msg);
    }

    /**
     * @return Api\Routes\ApiRoutesInterface
     */
    public function getRoutes(){
        return $this->getInstanceOfApiRoutes();
    }

    public function getSectionModel() {
        return new ApiSectionModel();
    }


    public function createNameSpace($namespace){
        $name = 'Wbengine\\Api\\'.ucfirst($namespace).'\\Routes';
        if(class_exists($name, true)){
            return $name;
        }else{
            throw new Api\Exception\ApiException('Can not instantinate Api module: '.$name.'. Class not found.');
        }
    }

    public function getLastPartFromNamespace($namespace){
        return end(explode('\\', $namespace));
    }

}