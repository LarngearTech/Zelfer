<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;

	/**
	 * Get user id.
	 * @return integer user id.
	 */
	public function getId()
	{
		return $this->_id;
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
			$this->errorCode = self::ERROR_NONE;
		}
		return !$this->errorCode;
	}
}
