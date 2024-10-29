<?php

declare(strict_types=1);

namespace Omnipay\Mpgs;

use Carbon\Carbon;
use Omnipay\Common\CreditCard;
use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Mpgs\Message\PurchaseRequest;
use Omnipay\Tests\GatewayTestCase;

/**
 * @property Gateway gateway
 */
class GatewayTest extends GatewayTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setTestMode(true);
        $this->gateway->setEndpointBase('https://bendigo.ap.gateway.mastercard.com');
        $this->gateway->setMerchantId('TEST123');
        $this->gateway->setPassword('pass654321');
    }

    /**
     * @throws InvalidCreditCardException
     * @throws InvalidRequestException
     */
    public function testPurchase(): void
    {
        $request = $this->gateway->purchase([
            'transactionId' => uniqid(),
            'amount' => '10.00',
            'currency' => 'AUD',
            'description' => 'Here is a description that is over 40 characters long. It will get truncated to 40 characters.',
            'card' => new CreditCard([
                'firstName' => 'John',
                'lastName' => 'Doe',
                'number' => '5999999789012346',
                'expiryMonth' => '03',
                'expiryYear' => Carbon::now()->addYears()->format('Y'),
                'cvv' => '123',
            ]),
        ]);

        $this->assertInstanceOf(PurchaseRequest::class, $request);
        $this->assertSame('10.00', $request->getAmount());

        $data = $request->getData();

        $expectedData = [
            'apiOperation' => 'PAY',
            'order' => [
                'amount' => '10.00',
                'currency' => 'AUD',
                'reference' => 'Here is a description that is over 40 ch',
            ],
            'sourceOfFunds' => [
                'type' => 'CARD',
                'provided' => [
                    'card' => [
                        'number' => '5999999789012346',
                        'securityCode' => '123',
                        'expiry' => [
                            'month' => '3',
                            'year' => Carbon::now()->addYears()->format('y'),
                        ],
                    ],
                ],
            ],
        ];

        $this->assertEquals($expectedData, $data);
    }
}
