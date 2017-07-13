<?php namespace RancherizeEcr\EventHandler;
use Rancherize\Docker\DockerAccount;
use RancherizeEcr\EcrDockerAccount\EcrDockerAccount;

/**
 * Class EcrRetriever
 */
class EcrRetriever {

	/**
	 * @param EcrAccount $account
	 * @return DockerAccount
	 */
	public function retrieve( EcrAccount $account ) {

		$id = $account->getId();
		$secret =  $account->getSecret();
		$region = $account->getRegion();

		$command = [
			'docker',
			'run',
			'--rm',
			'-t',
			'-e', 'AWS_ACCESS_KEY_ID='.$id,
			'-e', 'AWS_SECRET_ACCESS_KEY='.$secret,
			'-e', 'AWS_DEFAULT_REGION='.$region,
			'-v', getcwd().':/project',
			'mesosphere/aws-cli',
		];

		$dockerAccount = new EcrDockerAccount();
		//$dockerAccount->setUsername();
		//$dockerAccount->setPassword();
		//$dockerAccount->setServer();
		return $dockerAccount;
	}

}