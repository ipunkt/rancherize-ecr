<?php namespace RancherizeEcr\EventHandler;

use Rancherize\Docker\Events\DockerRetrievingAccountEvent;
use RancherizeEcr\EcrParser\EcrParser;
use RancherizeEcr\EcrParser\Exceptions\EcrNotEnabledException;
use RancherizeEcr\EcrRetriever\EcrRetriever;

/**
 * Class EcrEventHandler
 */
class EcrEventHandler {
	/**
	 * @var EcrRetriever
	 */
	private $ecrRetriever;
	/**
	 * @var EcrParser
	 */
	private $ecrParser;

	/**
	 * EcrEventHandler constructor.
	 * @param EcrParser $ecrParser
	 * @param EcrRetriever $ecrRetriever
	 */
	public function __construct(EcrParser $ecrParser, EcrRetriever $ecrRetriever) {
		$this->ecrRetriever = $ecrRetriever;
		$this->ecrParser = $ecrParser;
	}

	/**
	 * @param DockerRetrievingAccountEvent $event
	 */
	public function retrievingDockerAccount( DockerRetrievingAccountEvent $event ) {

		$account = $event->getAccount();
		$dockerAccount = $event->getDockerAccount();
		try {
			$ecrAccount = $this->ecrParser->parse($dockerAccount, $account);
		} catch(EcrNotEnabledException $e) {
			return;
		}

		$ecrDockerAccount = $this->ecrRetriever->retrieve( $ecrAccount );
		$event->setDockerAccount($ecrDockerAccount);
	}


}