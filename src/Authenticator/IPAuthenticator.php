<?php
    declare(strict_types=1);

    namespace IPAuthenticator\Authenticator;

    use Authentication\Authenticator\AbstractAuthenticator;
    use Authentication\Authenticator\PersistenceInterface;
    use Authentication\Authenticator\Result;
    use Authentication\Authenticator\ResultInterface;
    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;

    class IPAuthenticator extends AbstractAuthenticator implements PersistenceInterface {
        /**
         * Default config for this object.
         * - `sessionKey` Session key.
	     * - `domains` Array with domain(s) config
	     *
         * @var array
         */
        protected $_defaultConfig = [
            'sessionKey' => 'Auth',
            'auth' => [],
        ];

        /**
         * Authenticate a user using NTLM server data.
	     * Server params:
	     * - `AUTH_TYPE` NTLM
	     * - `REMOTE_USER` domain\username
         *
         * @param \Psr\Http\Message\ServerRequestInterface $request The request to authenticate with.
         * @return \Authentication\Authenticator\ResultInterface
         */
        public function authenticate (ServerRequestInterface $request) : ResultInterface {
            $auth_ips = $this->getConfig('auth', []);
            $user = $auth_ips[$request->clientIp()] ?? null;

            if (empty($user)) {
                return new Result(null, Result::FAILURE_CREDENTIALS_MISSING);
            }

            return new Result($user, Result::SUCCESS);
        }

        /**
         * @inheritDoc
         */
        public function persistIdentity (ServerRequestInterface $request, ResponseInterface $response, $identity) : array {
            $sessionKey = $this->getConfig('sessionKey');
            /** @var \Cake\Http\Session $session */
            $session = $request->getAttribute('session');

            if (!$session->check($sessionKey)) {
                $session->renew();
                $session->write($sessionKey, $identity);
            }

            return [
                'request' => $request,
                'response' => $response,
            ];
        }

        /**
         * @inheritDoc
         */
        public function clearIdentity (ServerRequestInterface $request, ResponseInterface $response) : array {
            $sessionKey = $this->getConfig('sessionKey');
            /** @var \Cake\Http\Session $session */
            $session = $request->getAttribute('session');
            $session->delete($sessionKey);
            $session->renew();

            return [
                        'request' => $request->withoutAttribute($this->getConfig('identityAttribute')),
                        'response' => $response,
            ];
        }
    }
