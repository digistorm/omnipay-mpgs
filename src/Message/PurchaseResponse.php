<?php

namespace Omnipay\Mpgs\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class PurchaseResponse extends AbstractResponse
{
    const GATEWAY_CODES = [
        'ABORTED' => 'Transaction aborted by payer',
        'ACQUIRER_SYSTEM_ERROR' => 'Acquirer system error occurred processing the transaction',
        'APPROVED' => 'Transaction Approved',
        'APPROVED_AUTO' => 'The transaction was automatically approved by the gateway. it was not submitted to the acquirer.',
        'APPROVED_PENDING_SETTLEMENT' => 'Transaction Approved - pending batch settlement',
        'AUTHENTICATION_FAILED' => '3D Secure authentication failed',
        'AUTHENTICATION_IN_PROGRESS' => 'The operation determined that payer authentication is possible for the given card, but this has not been completed, and requires further action by the merchant to proceed.',
        'BALANCE_AVAILABLE' => 'A balance amount is available for the card, and the payer can redeem points.',
        'BALANCE_UNKNOWN' => 'A balance amount might be available for the card. Points redemption should be offered to the payer.',
        'BLOCKED' => 'Transaction blocked due to Risk or 3D Secure blocking rules',
        'CANCELLED' => 'Transaction cancelled by payer',
        'DECLINED' => 'The requested operation was not successful. For example, a payment was declined by issuer or payer authentication was not able to be successfully completed.',
        'DECLINED_AVS' => 'Transaction declined due to address verification',
        'DECLINED_AVS_CSC' => 'Transaction declined due to address verification and card security code',
        'DECLINED_CSC' => 'Transaction declined due to card security code',
        'DECLINED_DO_NOT_CONTACT' => 'Transaction declined - do not contact issuer',
        'DECLINED_INVALID_PIN' => 'Transaction declined due to invalid PIN',
        'DECLINED_PAYMENT_PLAN' => 'Transaction declined due to payment plan',
        'DECLINED_PIN_REQUIRED' => 'Transaction declined due to PIN required',
        'DEFERRED_TRANSACTION_RECEIVED' => 'Deferred transaction received and awaiting processing',
        'DUPLICATE_BATCH' => 'Transaction declined due to duplicate batch',
        'EXCEEDED_RETRY_LIMIT' => 'Transaction retry limit exceeded',
        'EXPIRED_CARD' => 'Transaction declined due to expired card',
        'INSUFFICIENT_FUNDS' => 'Transaction declined due to insufficient funds',
        'INVALID_CSC' => 'Invalid card security code',
        'LOCK_FAILURE' => 'Order locked - another transaction is in progress for this order',
        'NOT_ENROLLED_3D_SECURE' => 'Card holder is not enrolled in 3D Secure',
        'NOT_SUPPORTED' => 'Transaction type not supported',
        'NO_BALANCE' => 'A balance amount is not available for the card. The payer cannot redeem points.',
        'PARTIALLY_APPROVED' => 'The transaction was approved for a lesser amount than requested. The approved amount is returned in order.totalAuthorizedAmount.',
        'PENDING' => 'Transaction is pending',
        'REFERRED' => 'Transaction declined - refer to issuer',
        'SUBMITTED' => 'The transaction has successfully been created in the gateway. It is either awaiting submission to the acquirer or has been submitted to the acquirer but the gateway has not yet received a response about the success or otherwise of the payment.',
        'SYSTEM_ERROR' => 'Internal system error occurred processing the transaction',
        'TIMED_OUT' => 'The gateway has timed out the request to the acquirer because it did not receive a response. Points redemption should not be offered to the payer.',
        'UNKNOWN' => 'The transaction has been submitted to the acquirer but the gateway was not able to find out about the success or otherwise of the payment. If the gateway subsequently finds out about the success of the payment it will update the response code.',
        'UNSPECIFIED_FAILURE' => 'Transaction could not be processed',
    ];

    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, json_decode($data, true));
    }

    public function isSuccessful()
    {
        if (!isset($this->data['result'])) {
            return false;
        }

        if ($this->data['result'] != 'SUCCESS') {
            return false;
        }

        if (!isset($this->data['response']['gatewayCode'])) {
            return false;
        }

        $approvedCodes = [
            'APPROVED',
            'APPROVED_AUTO',
            'APPROVED_PENDING_SETTLEMENT',
        ];

        if (!in_array($this->data['response']['gatewayCode'], $approvedCodes)) {
            return false;
        }

        return true;
    }


    /**
     * Get the error message from the response.
     *
     * Returns null if the request was successful.
     *
     * @link https://bendigo.ap.gateway.mastercard.com/api/documentation/apiDocumentation/rest-json/version/latest/operation/Transaction%3a%20%20Pay.html?locale=en_US
     *
     * @return string|null
     */
    public function getMessage()
    {
        if ($this->isSuccessful()) {
            return null;
        }

        if (isset($this->data['response']['gatewayCode'])) {
            return self::GATEWAY_CODES[$this->data['response']['gatewayCode']];
        }

        if (isset($this->data['error'])) {
            return sprintf('[%s] %s', $this->data['error']['cause'], $this->data['error']['explanation']);
        }

        return 'Unknown Error';
    }

    /**
     * Get the payment gateway code
     * @return mixed|string|null
     */
    public function getCode()
    {
        if (isset($this->data['response']['gatewayCode'])) {
            return $this->data['response']['gatewayCode'];
        }

        return null;
    }


    /**
     * Gateway Reference
     *
     * @return null|string A reference provided by the gateway to represent this transaction
     */
    public function getTransactionReference()
    {
        if (isset($this->data['transaction']['id'])) {
            return $this->data['transaction']['id'];
        }
    }
}
