<?php namespace RancherizeEcr\EcrTokenParser;

/**
 * Class EcrAuthData
 * @package RancherizeEcr\EcrTokenParser
 */
class EcrAuthData {

	/**
	 * @var string
	 */
	protected $username = '';

	/**
	 * @var string
	 */
	protected $secret = '';

	/**
	 * @var float
	 */
	protected $expiresAt = 0.0;

	/**
	 * @var string
	 */
	protected $endpoint = '';

	/**
	 * @return string
	 */
	public function getSecret(): string {
		return $this->secret;
	}

	/**
	 * @param string $secret
	 * @return EcrAuthData
	 */
	public function setSecret( string $secret ): EcrAuthData {
		$this->secret = $secret;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getExpiresAt(): float {
		return $this->expiresAt;
	}

	/**
	 * @param float $expiresAt
	 * @return EcrAuthData
	 */
	public function setExpiresAt( float $expiresAt ): EcrAuthData {
		$this->expiresAt = $expiresAt;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getEndpoint(): string {
		return $this->endpoint;
	}

	/**
	 * @param string $endpoint
	 * @return EcrAuthData
	 */
	public function setEndpoint( string $endpoint ): EcrAuthData {
		$this->endpoint = $endpoint;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUsername(): string {
		return $this->username;
	}

	/**
	 * @param string $username
	 * @return $this
	 */
	public function setUsername( string $username ) {
		$this->username = $username;
		return $this;
	}

}