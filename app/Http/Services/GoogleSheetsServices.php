<?php 

namespace App\Http\Services;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;

class GoogleSheetsServices{
    
    public $client, $service, $documentId, $range;

    public function __construct($id)
    {
        
        $this->client = $this->getClient();
        $this->service = new Sheets($this->client);
        // $this->documentId = '1yXF5kZAX3mZF5X2j490kg6xA9WWpmoL37K0gp72szgo';
        $this->documentId = $id;
        
        $this->range = 'A:Z';
        
    }

    public function getClient(){
        $client = new Client();
        $client->setApplicationName('Dayim Google Sheets');
        $client->setRedirectUri('http://127.0.0.1:8000/googlesheet');
        $client->setScopes(Sheets::SPREADSHEETS);
        $client->setAuthConfig('../storage/credentials.json');
        $client->setAccessType('offline');
        
        return $client;
    }

    public function readSheets(){
        $doc = $this->service->spreadsheets_values->get($this->documentId, $this->range);
        // $doc = $this->service->spreadsheets->get($this->documentId);


        return $doc;
    }
}

