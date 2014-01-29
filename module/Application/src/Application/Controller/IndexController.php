<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Db\Entity\Guestbook;
use Zend\Http\Request;
use Zend\Json\Json;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $oAuthToken = $this->getServiceLocator()->get('OAuth2\Token');
        
        $entries = $this->getServiceLocator()->get('Application\Db\Guestbook');
        
        $pagedEntries = $entries->fetchAll(true);
        $pagedEntries->setCurrentPageNumber(
            (int)$this->params()->fromQuery('page', 1)
        );
        $pagedEntries->setItemCountPerPage(10);
        
        return compact('oAuthToken', 'pagedEntries');
    }
    
    public function postAction()
    {
        $message = $this->getRequest()->getPost('message', null);
        
        if(is_null($message)) {
            return $this->redirect()->toRoute('home');
        }
        
        $entry = new Guestbook();
        
        $entry->setMessage($message);
        
        if(APPLICATION_ENV == 'development') {
            $entry->setName("Joe Developer");
        } else {
            $apiClient = $this->getServiceLocator()->get('OAuth2\Api\Client');
            
            $result = $apiClient->setUri('https://www.googleapis.com/oauth2/v1/userinfo')
                                ->setMethod(Request::METHOD_GET)
                                ->send();
            
            $userInfo = Json::decode($result->getBody(), Json::TYPE_ARRAY);
            
            $entry->setName(isset($userInfo['name']) ? $userInfo['name'] : "Unknown User");
        }
        
        $entries = $this->getServiceLocator()->get('Application\Db\Guestbook');
        
        $entries->save($entry);
        
        return $this->redirect()->toRoute('home');
    }
    
}
