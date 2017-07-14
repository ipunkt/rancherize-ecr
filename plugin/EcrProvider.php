<?php namespace RancherizeEcr;

use Rancherize\Docker\Events\DockerRetrievingAccountEvent;
use Rancherize\Plugin\Provider;
use Rancherize\Plugin\ProviderTrait;
use RancherizeEcr\EcrParser\EcrParser;
use RancherizeEcr\EcrRetriever\EcrRetriever;
use RancherizeEcr\EcrTokenParser\GetTokenResponseParser;
use RancherizeEcr\EventHandler\EcrEventHandler;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class EcrProvider
 */
class EcrProvider implements Provider {
	use ProviderTrait;

	/**
	 */
	public function register() {
		$this->container['ecr-parser'] = function($c) {
			return new EcrParser();
		};
		$this->container['get-token-response-parser']= function($c) {
			return new GetTokenResponseParser();
		};
		$this->container['ecr-retriever'] = function($c) {
			return new EcrRetriever( $c['get-token-response-parser'] );

		};
		$this->container['ecr-event-handler'] = function ($c) {
			return new EcrEventHandler(  $c['ecr-parser'], $c['ecr-retriever'] );
		};
	}

	/**
	 */
	public function boot() {
		/**
		 * @var EventDispatcher $event
		 */
		$event = container('event');
		/**
		 * @var EcrEventHandler
		 */
		$listener = container('ecr-event-handler');

		$event->addListener(DockerRetrievingAccountEvent::NAME, [$listener, 'retrievingDockerAccount']);
	}
}