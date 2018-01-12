<?php

namespace Frontuser\Integration\Helper;

/**
 * Class Data
 * @package Frontuser\Integration\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	/**
	 * @var string
	 */
	public $secretKey = '!@#$%^&*';

	/**
	 * @var string
	 */
	public $secretIV = 'Frontuser';

	/**
	 * @var string
	 */
	public $method = 'AES-256-CBC';

	/**
	 * Simple method to encrypt a plain text string
	 *
	 * @param $string string to encrypt
	 * @return bool|string
	 */
	public function encrypt($string)
	{
		$output = false;
		$key = hash('sha256', $this->secretKey);

		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $this->secretIV), 0, 16);
		$output = openssl_encrypt($string, $this->method, $key,0, $iv);
		$output = base64_encode($output);

		return $output;
	}

	/**
	 * Decrypt encrypted string
	 *
	 * @param $string string to decrypt
	 * @return bool|string
	 */
	public function decrypt($string)
	{
		$output = false;
		$key = hash('sha256', $this->secretKey);

		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $this->secretIV), 0, 16);
		$output = openssl_decrypt(base64_decode($string), $this->method, $key,0, $iv);

		return $output;
	}
}