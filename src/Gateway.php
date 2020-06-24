<?php

namespace Omnipay\Mpgs;

use Omnipay\Common\AbstractGateway;
use Omnipay\Mpgs\Message\PurchaseRequest;

/**
 * MPGS gateway
 *
 * @link https://bendigo.ap.gateway.mastercard.com/api/documentation/apiDocumentation/index.html?locale=en_US
 *
 * @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())         (Optional method)
 *         Authorize an amount on the customers card
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array()) (Optional method)
 *         Handle return from off-site gateways after authorization
 * @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())           (Optional method)
 *         Capture an amount you have previously authorized
 * @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = array())  (Optional method)
 *         Handle return from off-site gateways after purchase
 * @method \Omnipay\Common\Message\RequestInterface refund(array $options = array())            (Optional method)
 *         Refund an already processed transaction
 * @method \Omnipay\Common\Message\RequestInterface void(array $options = array())              (Optional method)
 *         Generally can only be called up to 24 hours after submitting a transaction
 * @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())        (Optional method)
 *         The returned response object includes a cardReference, which can be used for future transactions
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())        (Optional method)
 *         Update a stored card
 * @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())        (Optional method)
 *         Delete a stored card
 * @method \Omnipay\Common\Message\RequestInterface fetchTransaction(array $options = [])       (Optional method)
 *         Fetch a transaction
 * @method \Omnipay\Common\Message\RequestInterface acceptNotification(array $options = [])     (Optional method)
 *         Accept a notification
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'MPGS';
    }

    public function getDefaultParameters()
    {
        return [
            'endpointBase' => 'https://bendigo.ap.gateway.mastercard.com',
            'merchantId' => '',
            'password' => '',
        ];
    }

    public function getEndpointBase()
    {
        return $this->getParameter('endpointBase');
    }

    public function setEndpointBase($value)
    {
        return $this->setParameter('endpointBase', $value);
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Mpgs\Message\PurchaseRequest
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function purchase(array $parameters = [])
    {
        $parameters['endpointBase'] = $this->getEndpointBase();
        $parameters['merchantId'] = $this->getMerchantId();
        $parameters['password'] = $this->getPassword();

        $request = $this->createRequest(PurchaseRequest::class, $parameters);

        // Validate required parameters
        $request->validate('endpointBase', 'merchantId', 'password');

        return $request;
    }
}
