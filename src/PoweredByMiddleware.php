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
// Date:     07/03/2018
// Time:     01:56
// Project:  HttpHeadersMiddleware
//
declare(strict_types = 1);
namespace CodeInc\HttpHeadersMiddleware;
use CodeInc\HttpHeadersMiddleware\Tests\PoweredByMiddlewareTest;


/**
 * Class PoweredByMiddleware
 *
 * @see PoweredByMiddlewareTest
 * @package CodeInc\HttpHeadersMiddleware
 * @author Joan Fabrégat <joan@codeinc.fr>
 * @license MIT <https://github.com/CodeIncHQ/HttpHeadersMiddleware/blob/master/LICENSE>
 * @link https://github.com/CodeIncHQ/HttpHeadersMiddleware
 */
class PoweredByMiddleware extends AbstractHttpHeaderMiddleware
{
    /**
     * @var string
     */
    private $poweredBy;


    /**
     * PoweredByMiddleware constructor.
     *
     * @param null|string $poweredBy
     */
	public function __construct(string $poweredBy)
    {
        parent::__construct('X-Powered-By');
        $this->poweredBy = $poweredBy;
    }


    /**
     * @param string $poweredBy
     */
    public function setPoweredBy(string $poweredBy):void
    {
        $this->poweredBy = $poweredBy;
    }


    /**
     * @return string
     */
    public function getPoweredBy():string
    {
        return $this->poweredBy;
    }


    /**
     * @inheritdoc
     * @return string
     */
    public function getHeaderValue():string
    {
        return $this->poweredBy;
    }
}