<?php

namespace App\Domain\ValueObjects;

interface ISoapClient
{
    /**
     * @param string
     * @param string 
     * @return void
     */
    public function setSoapClient(string $wsdl, string $endpoint): void;

    /**
     * @param array 可変長引数 配列の中身もarrayにすること
     * @return void
     */
    public function setHeader(array ...$headers): void;

    /**
     * 指定サービスの指定メソッドを実行する
     * @param string 各APIごとに存在するAPIサービスのメソッド ex: AccountAdProductサービスの場合は get が使用可能なので 'get' と入力する
     * @param array RequestBodyを配列形式でまとめたもの
     * @return array
     */
    public function run(string $function, array $param): array;

    /**
     * APIが提供するサービスの設定
     * @param string サービス名 ex: 'AccountAdProduct'
     * @return
     */
    public function setService(string $serviceName): void;
}