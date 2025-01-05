<?php

namespace common\tests\Unit;

use common\models\Sale;
use common\models\User;
use common\models\Invoice;
use common\tests\UnitTester;
use Yii;

class SaleTest extends \Codeception\Test\Unit
{
    private const VALID_CLIENT_ID = 1;
    private const VALID_ADDRESS = 'Test Address 123';
    private const VALID_ZIP_CODE = '12345678';
    private const VALID_STATUS = 'Processing';
    private const SEND_EMAIL = false;

    protected UnitTester $tester;
    private $sale;
    private $invoice;
    private $client;

    protected function _before()
    {
        Sale::deleteAll();
        User::deleteAll();
        Invoice::deleteAll();

        $this->client = new User();
        $this->client->setScenarioBasedOnRole('client');
        $this->client->email = 'test@drjgouveia.dev';
        $this->client->username = 'testclient';
        $this->client->password = 'Test123@pass';
        $this->client->setPassword('Test123@pass');
        $this->client->name = 'Test Client';
        $this->client->status = User::STATUS_ACTIVE;
        $this->client->nif = '123456789';
        $this->client->address = 'Test Address 123';
        $this->client->contact = '123456789';
        $this->client->generateAuthKey();
        $this->client->save();

        $this->invoice = new Invoice();
        $this->invoice->client_id = $this->client->id;
        $this->invoice->total = 0;
        $this->invoice->items = json_encode([]);
        $this->invoice->save();
    }

    protected function _after()
    {
    }

    public function testRequiredFields()
    {
        $sale = new Sale();
        $this->assertFalse($sale->validate());
        $this->assertTrue($sale->hasErrors('client_id'));
    }

    public function testStatusValidation()
    {
        $sale = $this->createValidSale();

        $sale->status = 'InvalidStatus';
        $this->assertFalse($sale->validate(['status']));

        $sale->status = Sale::STATUS_PROCESSING;
        $this->assertTrue($sale->validate(['status']));

        $sale->status = Sale::STATUS_SENT;
        $this->assertTrue($sale->validate(['status']));
    }

    public function testForeignKeyValidation()
    {
        $sale = $this->createValidSale();

        $sale->client_id = 999999;
        $this->assertFalse($sale->validate(['client_id']));

        $sale->invoice_id = 999999;
        $this->assertFalse($sale->validate(['invoice_id']));
    }

    public function testZipCodeValidation()
    {
        $sale = $this->createValidSale();

        $sale->zip_code = '123456789'; // 9 characters
        $this->assertFalse($sale->validate(['zip_code']));

        $sale->zip_code = self::VALID_ZIP_CODE;
        $this->assertTrue($sale->validate(['zip_code']));
    }

    public function testRelationships()
    {
        $sale = $this->createValidSale();
        $sale->save(sendEmail: self::SEND_EMAIL);

        $this->assertNotNull($sale->client);
        $this->assertNotNull($sale->invoice);
        $this->assertNotNull($sale->saleProducts);
    }

    private function createValidSale()
    {
        $sale = new Sale();
        $sale->client_id = $this->client->id;
        $sale->invoice_id = $this->invoice->id;
        $sale->address = self::VALID_ADDRESS;
        $sale->zip_code = self::VALID_ZIP_CODE;
        $sale->status = Sale::STATUS_PROCESSING;
        return $sale;
    }
}