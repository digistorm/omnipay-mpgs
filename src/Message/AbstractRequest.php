<?php

declare(strict_types=1);

namespace Omnipay\Mpgs\Message;

use Money\Currency;
use Money\Money;
use Money\Number;
use Money\Parser\DecimalMoneyParser;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest as CommonAbstractRequest;
use Omnipay\Common\Message\ResponseInterface;

/**
 * MPGS Abstract Request.
 *
 * This is the parent class for all Mpgs requests.
 */
abstract class AbstractRequest extends CommonAbstractRequest
{
    public function getEndpointBase(): ?string
    {
        return $this->getParameter('endpointBase');
    }

    public function setEndpointBase(string $value): self
    {
        return $this->setParameter('endpointBase', $value);
    }

    public function getMerchantId(): ?string
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId(string $value): self
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getPassword(): string
    {
        return $this->getParameter('password');
    }

    public function setPassword(string $value): self
    {
        return $this->setParameter('password', $value);
    }

    abstract protected function createResponse(mixed $data): ResponseInterface;

    /**
     * Get HTTP Method.
     *
     * This is nearly always POST but can be over-ridden in sub classes.
     */
    public function getHttpMethod(): string
    {
        return 'POST';
    }

    /**
     * {@inheritdoc}
     */
    public function sendData(mixed $data): ResponseInterface
    {
        $authString = 'merchant.' . $this->getMerchantId() . ':' . $this->getPassword();
        $headers = [
            'Authorization' => base64_encode($authString),
            'Content-Type' => 'application/json; charset=utf-8',
        ];
        $body = json_encode($data);
        /** @var PurchaseRequest $this */
        $httpResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            $headers,
            $body ?: null,
        );

        return $this->createResponse($httpResponse->getBody()->getContents());
    }

    /**
     * @throws InvalidRequestException
     */
    public function getMoney(string $amount = 'amount'): ?Money
    {
        $amount = $this->getParameter($amount);

        if ($amount instanceof Money) {
            return $amount;
        }

        if ($amount !== null) {
            $moneyParser = new DecimalMoneyParser($this->getCurrencies());
            $currencyCode = $this->getCurrency() ?: 'USD';
            $currency = new Currency($currencyCode);

            $number = Number::fromString($amount);

            // Check for rounding that may occur if too many significant decimal digits are supplied.
            $decimal_count = strlen($number->getFractionalPart());
            $subunit = $this->getCurrencies()->subunitFor($currency);
            if ($decimal_count > $subunit) {
                throw new InvalidRequestException('Amount precision is too high for currency.');
            }

            $money = $moneyParser->parse((string) $number, $currency);

            // Check for a negative amount.
            if (!$this->negativeAmountAllowed && $money->isNegative()) {
                throw new InvalidRequestException('A negative amount is not allowed.');
            }

            // Check for a zero amount.
            if (!$this->zeroAmountAllowed && $money->isZero()) {
                throw new InvalidRequestException('A zero amount is not allowed.');
            }

            return $money;
        }

        return null;
    }

    /**
     * Filter a string value, so it will not break the API request.
     */
    protected function filter(string $string, int $maxLength = 50): string
    {
        return substr(preg_replace('/[^a-zA-Z0-9 \-]/', '', (string) $string), 0, $maxLength);
    }
}
