<?php namespace RancherizeEcr;

use Rancherize\Docker\Events\DockerRetrievingAccountEvent;
use Rancherize\Plugin\Provider;
use Rancherize\Plugin\ProviderTrait;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class EcrProvider
 */
class EcrProvider implements Provider {
	use ProviderTrait;

	/**
	 */
	public function register() {
		$this->container['ecr-event-handler'] = function () {
			return new \EcrEventHandler();
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
		 * @var \EcrEventHandler
		 */
		$listener = container('ecr-event-handler');

		$event->addListener(DockerRetrievingAccountEvent::NAME, [$listener, 'retrievingDockerAccount']);
	}
}