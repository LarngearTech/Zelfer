<?php
class WebUser extends CWebUser
{
	// Store model to not repeat query
	private $_model;

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
