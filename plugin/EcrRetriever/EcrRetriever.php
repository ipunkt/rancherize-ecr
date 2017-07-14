<?php namespace RancherizeEcr\EcrRetriever;
use Rancherize\Docker\DockerAccount;
use RancherizeEcr\EcrDockerAccount\EcrDockerAccount;
use RancherizeEcr\EcrRetriever\Exceptions\EcrLoginFailedException;
use RancherizeEcr\EcrTokenParser\Exceptions\EcrParseResponseException;
use RancherizeEcr\EcrTokenParser\GetTokenResponseParser;
use Symfony\Component\Console\Helper\ProcessHelper;
use Symfony\Component\Console\Tests\Fixtures\DummyOutput;
use Symfony\Component\Process\Process;

/**
 * Class EcrRetriever
 */
class EcrRetriever {
	/**
	 * @var GetTokenResponseParser
	 */
	private $tokenResponseParser;

	/**
	 * EcrRetriever constructor.
	 * @param GetTokenResponseParser $tokenResponseParser
	 */
	public function __construct( GetTokenResponseParser $tokenResponseParser) {
		$this->tokenResponseParser = $tokenResponseParser;
	}

	protected function getProcessHelper() {
		return container('process-helper');
	}

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
			"aws",
			"--output",
			"json",
			"ecr",
			"get-authorization-token",
		];
		$dummyOutput = new DummyOutput();

		$dockerAccount = new EcrDockerAccount();

		$processHelper = $this->getProcessHelper();
		$processHelper->run($dummyOutput, $command, '', function($type, $json) use ($dockerAccount) {
			if($type === Process::ERR)
				throw new EcrLoginFailedException("Aws ecr login failed", 21);

			try {
				$ecrAuthData = $this->tokenResponseParser->parse($json);
			} catch(EcrParseResponseException $e) {
				throw new EcrLoginFailedException('Failed to parse ecr login response');
			}

			$dockerAccount->setUsername( $ecrAuthData->getUsername() );
			$dockerAccount->setPassword( $ecrAuthData->getSecret() );
			$dockerAccount->setServer( $ecrAuthData->getEndpoint() );
		});
		return $dockerAccount;
	}

}