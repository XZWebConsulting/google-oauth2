<?php

namespace Application\Db\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Application\Db\Entity\Guestbook;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\Adapter\Exception\InvalidQueryException;
use Zend\Db\Adapter\Adapter;

class GuestbookTable implements FactoryInterface
{
	/**
	 * @var \Zend\Db\TableGateway\TableGateway
	 */
	protected $_tableGateway;
	
	public function createSchema()
	{
		$schema = "CREATE TABLE `guestbook` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`name` varchar(50) DEFAULT NULL,
					`message` text,
					PRIMARY KEY (`id`)
					) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;";
		
		try {
			$this->getTableGateway()->select(array('id' => 0));
		} catch(\Exception $e) {
			$this->getTableGateway()->getAdapter()->query($schema, Adapter::QUERY_MODE_EXECUTE);
		}
	}
	
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
		
		$resultSetPrototype = new ResultSet();
		$resultSetPrototype->setArrayObjectPrototype(new Guestbook());
		
		$tg = new TableGateway('guestbook', $dbAdapter, null, $resultSetPrototype);
		
		$retval = new static();
		$retval->setTableGateway($tg);
		
		return $retval;
	}
	
	/**
	 * @return \Zend\Db\TableGateway\TableGateway
	 */
	public function getTableGateway() {
		return $this->_tableGateway;
	}
	
	/**
	 * @param \Zend\Db\TableGateway\TableGateway $_tableGateway
	 * @return self
	 */
	public function setTableGateway(\Zend\Db\TableGateway\TableGateway $_tableGateway) {
		$this->_tableGateway = $_tableGateway;
		return $this;
	}
	
	public function save(Guestbook $guestBook)
	{
		$data = $guestBook->toArray();
		
		$id = $data['id'];
		unset($data['id']);
		
		if(!is_null($id) && $this->fetchById($id)) {
			return $this->getTableGateway()->update($data, array('id' => $id));
		}
		
		return $this->getTableGateway()->insert($data);
	}
	
	public function fetchById($id)
	{
		return $this->getTableGateway()->select(array('id' => $id));
	}
	
	public function fetchAll($paginated = false)
	{
		if(!$paginated) {
			return $this->getTableGateway()->select();
		}
		
		
		$rsp = new ResultSet();
		$rsp->setArrayObjectPrototype(new Guestbook());
		
		$select = new Select();
		$select->from('guestbook');
		
		$paginationAdapter = new DbSelect(
			$select, 
			$this->getTableGateway()->getAdapter(),
			$rsp
		);
		
		return new Paginator($paginationAdapter);
	}
}