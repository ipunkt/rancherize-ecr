<?php namespace RancherizeEcr\EcrDockerAccount;

use Rancherize\Docker\DockerAccount;

/**
 * Class EcrDockerAccount
 * @package RancherizeEcr\EcrDockerAccount
 */
class EcrDockerAccount implements DockerAccount {

	/**
	 * @var string
	 */
	protected $username = '';

	/**
	 * @var string
	 */
	protected $password = '';

	/**
	 * @var string
	 */
	protected $server = '';

	/**
	 * @return string
	 */
	public function getUsername(): string {
		return $this->username;
	}

	/**
	 * @param string $username
	 */
	public function setUsername( string $username ) {
		$this->username = $username;
	}

	/**
	 * @return string
	 */
	public function getPassword(): string {
		return $this->password;
	}

	/**
	 * @param string $password
	 */
	public function setPassword( string $password ) {
		$this->password = $password;
	}

	/**
	 * @return string
	 */
	public function getServer(): string {
		return $this->server;
	}

	/**
	 * @param string $server
	 */
	public function setServer( string $server ) {
		$this->server = $server;
	}

}