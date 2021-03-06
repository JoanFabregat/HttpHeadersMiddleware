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
// Date:     27/04/2018
// Time:     13:24
// Project:  HttpHeadersMiddleware
//
declare(strict_types=1);
namespace CodeInc\HttpHeadersMiddleware\Tests;
use CodeInc\HttpHeadersMiddleware\NoCacheMiddleware;
use CodeInc\HttpHeadersMiddleware\Tests\Assets\FakeRequestHandler;
use CodeInc\HttpHeadersMiddleware\Tests\Assets\FakeServerRequest;


/**
 * Class NoCacheMiddlewareTest
 *
 * @uses NoCacheMiddleware
 * @package CodeInc\HttpHeadersMiddleware\Tests
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
final class NoCacheMiddlewareTest extends AbstractHttpHeaderMiddlewareTestCase
{
    public function testMiddleware():void
    {
        $middleware = new NoCacheMiddleware();
        self::assertResponseHasHeaderValue(
            $middleware->process(FakeServerRequest::getSecureServerRequest(), new FakeRequestHandler()),
            'Cache-Control',
            ['no-cache, no-store, must-revalidate']
        );
    }
}