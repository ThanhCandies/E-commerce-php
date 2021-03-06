<?php

namespace App\core;

class Session
{
	protected const FLASH_KEY = 'flash_messages';
	public function __construct()
	{
		session_save_path(dirname(__DIR__, 2) . '/xampp/tmp');
		session_start();
		$flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
		foreach ($flashMessages as $key => $flashMessage) {
			$flashMessage['remove'] = true;
		}

		$_SESSION[self::FLASH_KEY] = $flashMessages;
	}

	public function setFlash($key, $message)
	{
		$_SESSION[self::FLASH_KEY][$key] = $message;
	}
	public function getFlash($key)
	{
		return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
	}

	public function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

    /**
     * @param $key
     * @return false|string
     */
	public function get($key)
    {
		return $_SESSION[$key] ?? false;
	}

	public function remove($key)
	{
		unset($_SESSION[$key]);
	}

	public function __destruct()
	{
		$flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
		foreach ($flashMessages as $key => $flashMessage) {
			if ($flashMessage['remove']) {
				unset($flashMessages[$key]);
			}
		}

		$_SESSION[self::FLASH_KEY] = $flashMessages;
	}
}
