<?php namespace RancherizeEcr\EcrParser;

use Rancherize\Docker\DockerAccount;
use RancherizeEcr\EcrParser\Exceptions\EcrNotEnabledException;

/**
 * Class EcrParser
 * @package RancherizeEcr\EcrParser
 */
class EcrParser {

	/**
	 * @param DockerAccount $dockerAccount
	 * @param array $accountConfig
	 * @return EcrAccount
	 */
	public function parse( DockerAccount $dockerAccount, array $accountConfig ) {

		if( !array_key_exists('ecr', $accountConfig) )
			throw new EcrNotEnabledException('ecr not set');
		if( !$accountConfig['ecr'] )
			throw new EcrNotEnabledException('ecr set to false');

		$accessId = $dockerAccount->getUsername();
		$secretKey = $dockerAccount->getPassword();

		$region = 'eu-central-1';
		if( array_key_exists('region', $accountConfig) )
			$region = $accountConfig['region'];


		$ecrAccount = new EcrAccount();

		$ecrAccount->setId($accessId)
			->setSecret($secretKey)
			->setRegion($region);

		return $ecrAccount;
	}

}