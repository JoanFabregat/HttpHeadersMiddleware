<?php
//
// +---------------------------------------------------------------------+
// | CODE INC. SOURCE CODE                                               |
// +---------------------------------------------------------------------+
// | Copyright (c) 2017 - Code Inc. SAS - All Rights Reserved.           |
// | Visit https://www.codeinc.fr for more information about licensing.  |
// +---------------------------------------------------------------------+
// | NOTICE:  All information contained herein is, and remains the       |
// | property of Code Inc. SAS. The intellectual and technical concepts  |
// | contained herein are proprietary to Code Inc. SAS are protected by  |
// | trade secret or copyright law. Dissemination of this information or |
// | reproduction of this material  is strictly forbidden unless prior   |
// | written permission is obtained from Code Inc. SAS.                  |
// +---------------------------------------------------------------------+
//
// Author:   Joan Fabrégat <joan@codeinc.fr>
// Date:     23/02/2018
// Time:     18:37
// Project:  HttpHeadersMiddleware
//
declare(strict_types = 1);
namespace CodeInc\HttpHeadersMiddleware;
use CodeInc\HttpHeadersMiddleware\Tests\HttpVersionCheckMiddlewareTest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


/**
 * Class HttpVersionCheckMiddleware
 *
 * @see HttpVersionCheckMiddlewareTest
 * @package CodeInc\HttpHeadersMiddleware
 * @author Joan Fabrégat <joan@codeinc.fr>
 * @license MIT <https://github.com/CodeIncHQ/HttpHeadersMiddleware/blob/master/LICENSE>
 * @link https://github.com/CodeIncHQ/HttpHeadersMiddleware
 */
class HttpVersionCheckMiddleware implements MiddlewareInterface
{
	/**
	 * @inheritdoc
	 * @return ResponseInterface
	 */
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler):ResponseInterface
	{
		$response = $handler->handle($request);

		// checks the HTTP version
		if ($request->getProtocolVersion() != $response->getProtocolVersion()) {
			return $response->withProtocolVersion($request->getProtocolVersion());
		}

		return $response;
	}
}