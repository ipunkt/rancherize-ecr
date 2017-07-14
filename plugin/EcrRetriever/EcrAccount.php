<?php namespace RancherizeEcr\EcrRetriever;

/**
 * Interface EcrAccount
 */
interface EcrAccount {

	/**
	 * @return string
	 */
	function getId();

	/**
	 * @return string
	 */
	function getSecret();

	/**
	 * @return string
	 */
	function getRegion();

}