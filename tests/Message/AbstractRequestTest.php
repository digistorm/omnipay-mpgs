<?php

declare(strict_types=1);

namespace Omnipay\Mpgs\Message;

use Mockery;
use Mockery\LegacyMockInterface;
use Omnipay\Tests\TestCase;

class AbstractRequestTest extends TestCase
{
    private LegacyMockInterface $request;

    public function setUp(): void
    {
        $this->request = Mockery::mock(AbstractRequest::class)->makePartial();
        $this->request->initialize();
    }

    public function testEndpointBase(): void
    {
        $this->assertSame($this->request, $this->request->setEndpointBase('https://bendigo.ap.gateway.mastercard.com'));
        $this->assertSame('https://bendigo.ap.gateway.mastercard.com', $this->request->getEndpointBase());
    }

    public function testPassword(): void
    {
        $this->assertSame($this->request, $this->request->setPassword('abc123'));
        $this->assertSame('abc123', $this->request->getPassword());
    }

    public function testMerchantId(): void
    {
        $this->assertSame($this->request, $this->request->setMerchantId('abc123'));
        $this->assertSame('abc123', $this->request->getMerchantId());
    }
}
