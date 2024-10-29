<?php

declare(strict_types=1);

namespace Omnipay\Mpgs\Message;

use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    private PurchaseRequest $request;

    public function setUp(): void
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            [
                'endpointBase' => 'https://bendigo.ap.gateway.mastercard.com',
                'merchantId' => 'TEST123',
                'password' => 'pass654321',
                'transactionId' => uniqid(),
                'amount' => '10.00',
                'currency' => 'USD',
                'card' => $this->getValidCard(),
            ]
        );
    }

    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getMessage());
    }

    public function testSendError(): void
    {
        $this->setMockHttpResponse('PurchaseFailure.txt');
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('[INVALID_REQUEST] Value \'ABCD1234\' is invalid. No valid Merchant Acquirer Relationship available', $response->getMessage());
    }
}
