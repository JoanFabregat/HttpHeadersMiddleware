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
// Time:     13:06
// Project:  HttpHeadersMiddleware
//
declare(strict_types=1);
namespace CodeInc\HttpHeadersMiddleware\Tests;
use CodeInc\HttpHeadersMiddleware\CacheMiddleware;
use CodeInc\HttpHeadersMiddleware\Tests\Assets\FakeRequestHandler;
use CodeInc\HttpHeadersMiddleware\Tests\Assets\FakeServerRequest;


/**
 * Class CacheMiddlewareTest
 *
 * @uses CacheMiddleware
 * @package CodeInc\HttpHeadersMiddleware\Tests
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
final class CacheMiddlewareTest extends AbstractHttpHeaderMiddlewareTestCase
{
    private const TEST_LAST_MODIFIED = 'Thu, 26 Apr 2018 12:00:00 GMT';
    private const TEST_ETAG = 'fake_etag_5ae3078a61bcb';

    public function testCacheControlPublic():void
    {
        $middleware = new CacheMiddleware(true, 3600);
        self::assertResponseHasHeaderValue(
            $middleware->process(FakeServerRequest::getSecureServerRequest(), new FakeRequestHandler()),
            'Cache-Control',
            ['public, max-age=3600']
        );
    }


    public function testCacheControlPrivate():void
    {
        $middleware = new CacheMiddleware(false, 3600);
        self::assertResponseHasHeaderValue(
            $middleware->process(FakeServerRequest::getSecureServerRequest(), new FakeRequestHandler()),
            'Cache-Control',
            ['private, max-age=3600']
        );
    }


    public function testCacheControlChange():void
    {
        $middleware = new CacheMiddleware(false, 3600);
        $middleware->setPublic(true);
        $middleware->setMaxAge(1800);
        self::assertResponseHasHeaderValue(
            $middleware->process(FakeServerRequest::getSecureServerRequest(), new FakeRequestHandler()),
            'Cache-Control',
            ['public, max-age=1800']
        );
    }


    public function testEtagViaSetEtag():void
    {
        $middleware = new CacheMiddleware();
        $middleware->setEtag(self::TEST_ETAG);
        $response = $middleware->process(FakeServerRequest::getSecureServerRequest(), new FakeRequestHandler());
        self::assertResponseHasHeader($response, 'Cache-Control');
        self::assertResponseHasHeaderValue($response, 'ETag', ['"'.self::TEST_ETAG.'"']);
    }


    public function testEtagViaTheConstructor():void
    {
        $middleware = new CacheMiddleware(false, 600, null,self::TEST_ETAG);
        $response = $middleware->process(FakeServerRequest::getSecureServerRequest(), new FakeRequestHandler());
        self::assertResponseHasHeader($response, 'Cache-Control');
        self::assertResponseHasHeaderValue($response, 'ETag', ['"'.self::TEST_ETAG.'"']);
    }


    public function testLastModifiedViaSetLastModified():void
    {
        $middleware = new CacheMiddleware();
        $middleware->setLastModified(new \DateTime(self::TEST_LAST_MODIFIED));
        $response = $middleware->process(FakeServerRequest::getSecureServerRequest(), new FakeRequestHandler());
        self::assertResponseHasHeader($response, 'Cache-Control');
        self::assertResponseHasHeaderValue($response, 'Last-Modified', [self::TEST_LAST_MODIFIED]);
    }


    public function testLastModifiedViaTheConstructor():void
    {
        $middleware = new CacheMiddleware(false, 600, new \DateTime(self::TEST_LAST_MODIFIED));
        $response = $middleware->process(FakeServerRequest::getSecureServerRequest(), new FakeRequestHandler());
        self::assertResponseHasHeader($response, 'Cache-Control');
        self::assertResponseHasHeaderValue($response, 'Last-Modified', [self::TEST_LAST_MODIFIED]);
    }


    public function testLastModifiedAndEtagViaSetEtagAndSetLastModified():void
    {
        $middleware = new CacheMiddleware();
        $middleware->setEtag(self::TEST_ETAG);
        $middleware->setLastModified(new \DateTime(self::TEST_LAST_MODIFIED));
        $response = $middleware->process(FakeServerRequest::getSecureServerRequest(), new FakeRequestHandler());
        self::assertResponseHasHeader($response, 'Cache-Control');
        self::assertResponseHasHeaderValue($response, 'Last-Modified', [self::TEST_LAST_MODIFIED]);
        self::assertResponseHasHeaderValue($response, 'ETag', ['"'.self::TEST_ETAG.'"']);
    }


    public function testLastModifiedAndEtagViaTheConstructor():void
    {
        $middleware = new CacheMiddleware(
            false,
            600,
            new \DateTime(self::TEST_LAST_MODIFIED),
            self::TEST_ETAG
        );
        $response = $middleware->process(FakeServerRequest::getSecureServerRequest(), new FakeRequestHandler());
        self::assertResponseHasHeader($response, 'Cache-Control');
        self::assertResponseHasHeaderValue($response, 'Last-Modified', [self::TEST_LAST_MODIFIED]);
        self::assertResponseHasHeaderValue($response, 'ETag', ['"'.self::TEST_ETAG.'"']);
    }
}