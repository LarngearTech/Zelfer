<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	private $_role;

	/**
	 * Get user id.
	 * @return integer user id.
	 */
	public function getId()
	{
		return $this->_id;
	}

	/**
	 * Get user role.
	 * @return integer user role.
	 */
	public function getRole()
	{
		return $this->_role;
	}

	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$email = strtolower($this->username);
		$record = User::model()->find('LOWER(email)=?', array($email));
		$ph = new PasswordHash(Yii::app()->params['phpass']['iteration_count_log2'], Yii::app()->params['phpass']['portable_hashes']);
		if ($record === null)
		{
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}
		else if (!$ph->CheckPassword($this->password, $record->password))
		{
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		}
		else
		{
			$this->_id = $record->id;
			$this->username = $record->email;
			$this->setState('fullname', $record->fullname);
			$this->_role = $record->role;
			$this->setState('role', $record->role);
			$this->errorCode = self::ERROR_NONE;
		}
		return !$this->errorCode;
	}
}
