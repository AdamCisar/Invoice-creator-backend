<?php

namespace App\Http\Controllers;

use Goutte\Client;

class ScraperController extends Controller
{
    public function show(string $query): Array
    {
        $items = array ();
        $client = new Client();
        
        $crawler = $client->request('GET', 'XXXXXXXXXXXXX');

        $searchInput = $crawler->filter('#tbSearch')->first();

        // Set the value of the input field
        $searchInput->getNode(0)->setAttribute('value', $query);
        
        // Find the search button element
        $searchButton = $crawler->filter('.form-search__submit')->first()->form();
        
        // Submit the form by clicking the search button
        $crawler = $client->submit($searchButton);

        $crawler->filter('.horizontal-wr')->each(function ($node) use (&$items){

            //getting number
            $price =  preg_replace('/[^0-9.,]/', '', $node->filter('.card__price')->first()->filter('span')->first()->text());
            $name = $node->filter('a')->first()->text();
            $url = $node->filter('a')->first()->link()->getUri();
            array_push($items, ['name' => $name, 'price' => $price, 'url' => $url]);
        });
        
       return $items;
    }      
} 
