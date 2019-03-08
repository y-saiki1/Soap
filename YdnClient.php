<?php

namespace App\Infrastructures\Entities\External;

use App\Domain\ValueObjects\ISoapClient;
use App\Domain\ValueObjects\BaseSoapClientTrait;

class YdnClient implements ISoapClient
{
    use BaseSoapClientTrait;

    private $license;
    private $apiAccountId;
    private $apiAccountPassword;

    private $ydnWsdlUrl;
    private $ydnEndPointlUrl;
    
    private $apiVersion;
    private $servicePath;

    private $ydnServiceList;

    public function __construct()
    {
        // techloco APIアカウント設定
        $this->license = config('ydn.techloco_license');
        $this->apiAccountId = config('ydn.api_account_id');
        $this->apiAccountPassword = config('ydn.api_account_password');;

        // YDN エンドポイント設定
        $this->ydnWsdlUrl = config('ydn.env');
        $this->ydnEndPointlUrl = config('ydn.env');
        
        $this->apiVersion = config('ydn.api_version');
        $this->servicePath = config('ydn.service_path');
        
        $this->ydnServiceList = config('ydn.services');
    }

    /**
     * @param string YDNサービス名 ex: AccountAdProductService
     * @return void
     * @throws Exception
     */
    public function setService(string $serviceName): void
    {
        if (empty($this->ydnServiceList[$serviceName])) throw new Exception($serviceName . ' is not available');
        
        $wsdl = $this->ydnWsdlUrl . $this->servicePath . $this->apiVersion . $serviceName . '?wsdl';
        $endpoint = $this->ydnEndPointlUrl . $this->servicePath . $this->apiVersion . $serviceName;

        $serviceConfigList = $this->ydnServiceList[$serviceName];
        $header = [
            'namespace'         => $serviceConfigList['namespace'] . '/' . $this->apiVersion . '/' . $serviceName,
            'xml_header_name'   => $serviceConfigList['xml_header_name'],
            'header_body'       => [
                'license'            => $this->license,
                'apiAccountId'       => $this->apiAccountId,
                'apiAccountPassword' => $this->apiAccountPassword,
            ],
        ];

        $this->setSoapClient($wsdl, $endpoint);
        $this->setHeader($header);
    }
}