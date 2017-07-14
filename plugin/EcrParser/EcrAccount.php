<?php namespace RancherizeEcr\EcrParser;

/**
 * Class EcrAccount
 * @package RancherizeEcr\EcrParser
 */
class EcrAccount implements \RancherizeEcr\EcrRetriever\EcrAccount {

	/**
	 * @var string
	 */
	protected $id = '';

	/**
	 * @var string
	 */
	protected $secret = '';

	/**
	 * @var string
	 */
	protected $region = '';

	/**
	 * @return string
	 */
	public function getId(): string {
		return $this->id;
	}

	/**
	 * @param string $id
	 * @return EcrAccount
	 */
	public function setId( string $id ): EcrAccount {
		$this->id = $id;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getSecret(): string {
		return $this->secret;
	}

	/**
	 * @param string $secret
	 * @return EcrAccount
	 */
	public function setSecret( string $secret ): EcrAccount {
		$this->secret = $secret;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getRegion(): string {
		return $this->region;
	}

	/**
	 * @param string $region
	 * @return EcrAccount
	 */
	public function setRegion( string $region ): EcrAccount {
		$this->region = $region;
		return $this;
	}


}