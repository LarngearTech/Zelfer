<?php
class WebUser extends CWebUser
{
	// Store model to not repeat query
	private $_model;

	/**
	 * Returns whether the user is loggined as admin or not
	 * @return bool true if user is an admin, false otherwise.
	 */
	function isAdmin()
	{
		return $this->role == 3;
	}

	/**
	 * Returns the role for the user.
	 * @return int a number represents role of the user, if the user is not login this will return 0.
	 */
	function getRole()
	{
		if (($role = $this->getState('__role')) !== null)
			return $this->role;
		else
			return 0;
	}

	/**
	 * Sets the role for the user.
	 * @param int $value represents user's role.
	 */
	function setRole($value)
	{
		$this->setState('__role', $value);
	}

	/**
	 * Returns the full name for the user.
	 * @return string the full name. If the user is not logged in, this will be {@link guestName}.
	 */
	function getFullName()
	{
		if (($fullname = $this->getState('__fullname')) !== null)
		//$user = $this->loadUser(Yii::app()->user->id);
			return $this->fullname;
		else
			return $this->guestName;
	}

	/**
	 * Sets the full name for the user.
	 * @param string $value the user full name.
	 * @see getFullName
	 */
	public function setFullName($value)
	{
		$this->setState('__fullname', $value);
	}
}
