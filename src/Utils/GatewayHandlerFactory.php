<?php

namespace Arbory\Merchant\Utils;

use Faker\Provider\bn_BD\Utils;
use Omnipay\Common\GatewayInterface;
use Arbory\Merchant\Utils\Handlers\FirstDataLatviaHandler;
use Arbory\Merchant\Utils\Handlers\SwedbankBanklinkHandler;
use Arbory\Merchant\Utils\Handlers\DnbLinkHandler;

class GatewayHandlerFactory
{
    private $classMap = [
        'Omnipay\FirstDataLatvia\Gateway' => FirstDataLatviaHandler::class,
        'Omnipay\SwedbankBanklink\Gateway' => SwedbankBanklinkHandler::class,
        'Omnipay\DnbLink\Gateway' => DnbLinkHandler::class
    ];

    public function create(GatewayInterface $gatewayInterface): GatewayHandler
    {
        $gatewayClassName = get_class($gatewayInterface);

        if(isset($this->classMap[$gatewayClassName])) {
            $formatterClass = $this->classMap[$gatewayClassName];
            return new $formatterClass();
        }

        throw new \InvalidArgumentException('Unknown gateway type given');
    }

    public function addHandler($gatewayName, $formatterClass){
        $this->classMap[$gatewayName] = $formatterClass;
    }
}