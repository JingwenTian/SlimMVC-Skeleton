<?php 

namespace App\middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Doing ....
 */
class SessionDistributedMeddleware
{

	public function __construct( $settings = array() )
	{

		$this->settings = array_merge(array(
			'session.name'		=> 'slim_session',
			'session.id'		=> '',
			'session.expires'	=> ini_get('session.gc_maxlifetime'),
			'cookie.lifetime'	=> 43200,
			'cookie.path'		=> '/',
			'cookie.domain'		=> '',
			'cookie.secure'		=> false,
			'cookie.httponly'	=> true,
		), $settings);

		if ( is_string($this->settings['session.expires']) )
			$this->settings['session.expires'] = intval($this->settings['session.expires']);

		session_name($this->settings['session.name']);
	
		session_set_cookie_params(
			$this->settings['cookie.lifetime'],
			$this->settings['cookie.path'],
			$this->settings['cookie.domain'],
			$this->settings['cookie.secure'],
			$this->settings['cookie.httponly']
		);

		// overwrite the default session handler 
		session_set_save_handler(
			array($this, 'open'),
			array($this, 'close'),
			array($this, 'read'),
			array($this, 'write'),
			array($this, 'destroy'),
			array($this, 'gc')
		);
	}

	public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
	{		

		if (!empty($this->settings['session.id']))	session_id($this->settings['session.id']);

		// start our session
		session_start();

		// tell slim it's ok to continue!
		return $next($request, $response);

	}



}