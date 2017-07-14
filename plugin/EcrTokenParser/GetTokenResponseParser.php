<?php namespace RancherizeEcr\EcrTokenParser;

use RancherizeEcr\EcrParser\Exceptions\EcrParserException;

/**
 * Class GetTokenResponseParser
 * @package RancherizeEcr\EcrTokenParser
 */
class GetTokenResponseParser {

	/**
	 * @param string $data
	 */
	public function parse( $data ) {

		$data = json_decode($data, true);

		$baseKey = 'authorizationData';
		$tokenKey = 'authorizationToken';
		$proxyKey = 'proxyEndpoint';

		if(!array_key_exists( $baseKey, $data))
			throw new EcrParserException('Missing '.$baseKey.' in answer');
		if( !array_key_exists(0, $data[$baseKey]) )
			throw new EcrParserException($baseKey.' is empty');
		if( !array_key_exists( $tokenKey, $data[$baseKey][0]) )
			throw new EcrParserException($tokenKey.' not found');
		if( !array_key_exists( $proxyKey, $data[$baseKey][0]) )
			throw new EcrParserException($proxyKey.' not found');

		$base64Token = $data[$baseKey][0][$tokenKey];
		$token = base64_decode($base64Token);
		$proxy = $data[$baseKey][0][$proxyKey];

		$parts = explode(':', $token, 2);
		if(count($parts) !== 2)
			throw new EcrParserException('Failed to split token into username and secret');
		list($username, $password) = $parts;


		$ecrAuthData = new EcrAuthData();
		$ecrAuthData->setUsername( $username );
		$ecrAuthData->setSecret( $password );
		$ecrAuthData->setEndpoint( $proxy );

		return $ecrAuthData;
	}
}