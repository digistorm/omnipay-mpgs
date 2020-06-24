<?php

namespace Omnipay\Mpgs\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class PurchaseRequest extends AbstractRequest
{

    public function getData()
    {
        $this->validate('transactionId', 'amount', 'currency');

        if (!$this->getParameter('card')) {
            throw new InvalidRequestException('You must pass a "card" parameter.');
        }

        /* @var $card \OmniPay\Common\CreditCard */
        $card = $this->getParameter('card');
        $card->validate();

        $data = [
            'apiOperation' => 'PAY',
            'order' => [
                'amount' => $this->getAmount(),
                'currency' => $this->getCurrency(),
            ],
            'sourceOfFunds' => [
                'type' => 'CARD',
                'provided' => [
                    'card' => [
                        'number' => $card->getNumber(),
                        'securityCode' => $card->getCvv(),
                        'expiry' => [
                            'month' => $card->getExpiryMonth(),
                            'year' => $card->getExpiryDate('y'),
                        ],
                    ],
                ],
            ],
        ];

        if ($this->getDescription()) {
            $data['order']['reference'] = $this->filter($this->getDescription(), 40);
        }

        return $data;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        $url = parent::getEndpointBase();

        // Add API path & version
        $url .= '/api/rest/version/56';

        // Add merchant ID
        $url .= '/merchant/' . parent::getMerchantId();

        // Add order ID
        $url .= '/order/' . parent::getTransactionId();

        // Add order transaction ID
        $url .= '/transaction/' . parent::getTransactionId() . '-1';

        return $url;
    }

    /**
     * @return string
     */
    public function getHttpMethod()
    {
        return 'PUT';
    }

    /**
     * @param $data
     *
     * @return \Omnipay\Mpgs\Message\PurchaseResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }
}
