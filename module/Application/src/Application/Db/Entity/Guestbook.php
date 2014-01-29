<?php

namespace Application\Db\Entity;

class Guestbook
{
	/**
	 * @var int
	 */
	protected $_id;
	
	/**
	 * @var string
	 */
	protected $_name;
	
	/**
	 * @var string
	 */
	protected $_message;
	
	public function exchangeArray(array $input)
	{
		$this->setId(isset($input['id']) ? $input['id'] : null)
			 ->setMessage(isset($input['message']) ? $input['message'] : null)
			 ->setName(isset($input['name']) ? $input['name'] : null);
	}
	
	public function toArray()
	{
		return array(
			'id' => $this->getId(),
			'message' => $this->getMessage(),
			'name' => $this->getName()
		);
	}
	
	/**
	 * @return the $_id
	 */
	public function getId() {
		return $this->_id;
	}

	/**
	 * @return the $_name
	 */
	public function getName() {
		return $this->_name;
	}

	/**
	 * @return the $_message
	 */
	public function getMessage() {
		return $this->_message;
	}

	/**
	 * @param number $_id
	 * @return self
	 */
	public function setId($_id) {
		$this->_id = $_id;
		return $this;
	}

	/**
	 * @param string $_name
	 * @return self
	 */
	public function setName($_name) {
		$this->_name = $_name;
		return $this;
	}

	/**
	 * @param string $_message
	 * @return self
	 */
	public function setMessage($_message) {
		$this->_message = $_message;
		return $this;
	}

}