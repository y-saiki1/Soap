<?php

namespace App\Domain\ValueObjects;

trait BaseSoapClientTrait
{
    private $wsdl;
    private $apiEndpoint;
    private $soapClient;

    public function setSoapClient(string $wsdl, string $endpoint): void
    {
        $this->soapClient = new \SoapClient($wsdl, [
            'location' => $endpoint,
            'uri'      => API_NS,
            'trace'    => true,
        ]);

        $this->wsdl = $wsdl;
        $this->apiEndpoint = $endpoint;
    }

    public function setHeader(array ...$headers): void
    {
        $soapHeaders = [];
        foreach ($headers as $header) {
            $soapHeaders[] = new \SoapHeader(
                $header['namespace'],
                $header['xml_header_name'],
                $header['header_body'],
                false
            );
        }
        $this->__setSoapHeaders($soapHeaders);
    }

    /**
     * execute SOAP Function.
     *
     * @param string YDNドキュメントに記載されているServiceの持つMethodを使用すること
     * @param array RequestParams
     * @return array SOAP Response
     */
    public function run(string $function, array $param): array
    {
        $response = $this->soapClient->__soapCall($function, [
            $function => $param
        ]);

        $doc = new DOMDocument();
        $doc->loadXML($this->soapClient->__getLastResponse());
        $doc->formatOutput = true;
        dump($doc->saveXML());

        return $response;
    }
}
