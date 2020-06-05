<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

class GerenciaNetBoletoController extends Controller
{
    //

    public function testeGnet()
    {

        $clientId = 'Client_Id_4c5d8faefbb36fce9b50c40656961ac2ed87aae8';
        // insira seu Client_Id, conforme o ambiente (Des ou Prod)
        $clientSecret = 'Client_Secret_dce0cf7f48befcc83c550fd8cd2272f143b58522';
        // insira seu Client_Secret, conforme o ambiente (Des ou Prod)

        $options = [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'sandbox' => true // altere conforme o ambiente (true = desenvolvimento e false = producao)
        ];

        $item_1 = [
            'name' => 'Iphone 11 pro', // nome do item, produto ou serviço
            'amount' => 1, // quantidade
            'value' => 50000 // valor (1000 = R$ 10,00) (Obs: É possível a criação de itens com valores negativos. Porém, o valor total da fatura deve ser superior ao valor mínimo para geração de transações.)
        ];
        $items = [
            $item_1
        ];
        $metadata = array('notification_url' => 'sua_url_de_notificacao_.com.br'); //Url de notificações
        $customer = [
            'name' => 'Gorbadoc Oldbuck', // nome do cliente
            'cpf' => '94271564656', // cpf válido do cliente
            'phone_number' => '5144916523', // telefone do cliente
        ];
        $discount = [ // configuração de descontos
            'type' => 'currency', // tipo de desconto a ser aplicado
            'value' => 599 // valor de desconto 
        ];
        $configurations = [ // configurações de juros e mora
            'fine' => 200, // porcentagem de multa
            'interest' => 33 // porcentagem de juros
        ];
        $conditional_discount = [ // configurações de desconto condicional
            'type' => 'percentage', // seleção do tipo de desconto 
            'value' => 500, // porcentagem de desconto
            'until_date' => '2019-08-30' // data máxima para aplicação do desconto
        ];
        $bankingBillet = [
            'expire_at' => '2019-09-01', // data de vencimento do titulo
            'message' => 'teste\nteste\nteste\nteste', // mensagem a ser exibida no boleto
            'customer' => $customer,
            'discount' => $discount,
            'conditional_discount' => $conditional_discount
        ];
        $payment = [
            'banking_billet' => $bankingBillet // forma de pagamento (banking_billet = boleto)
        ];
        $body = [
            'items' => $items,
            'metadata' => $metadata,
            'payment' => $payment
        ];
        try {
            $api = new Gerencianet($options);
            $pay_charge = $api->oneStep([], $body);
            echo '<pre>';
            print_r($pay_charge);
            echo '<pre>';
        } catch (GerencianetException $e) {
            print_r($e->code);
            print_r($e->error);
            print_r($e->errorDescription);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }
}
