<?php

namespace App\Scraper;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Panther\Client;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Message\NewsParser;

class Scraper
{


    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }
    

    public function scrap(
        $url,$WrapperSelector,
        $titleSelector,
        $shortDescriptionSelector,
        $ImageSelector)
    {
        $titles = array('Gemini','Fiifi');

        $client = Client::createChromeClient();
        $crawler = $client->request('GET', $url);
        $crawler->filter($WrapperSelector)->each(function (Crawler $c) use (
            $WrapperSelector,
            $titleSelector,
            $shortDescriptionSelector,
            $ImageSelector) {
               

            /// this line by passes the ads
            // if (!$c->filter($source->getLinkSelector())->count()) {
            //     return;
            // }

            // creates a new object for news 
            // $newsData = new stdClass();


            /// Find and filter the title
            $title = $c->filter($titleSelector)->text();

            
            // $newsData->dateAdded(date("Y-m-d H:i:s"));
            // $newsData->lastUpdatedAt(date("Y-m-d H:i:s"));

            $picture = $c->filter($ImageSelector)->attr('src');
            // $picture = $c->filter($ImageSelector)->text();

            $shortDescription = ($c->filter($shortDescriptionSelector)->text());

            $this->messageBus->dispatch(new NewsParser($title,$shortDescription,$picture));
            

            
        });

        return new Response($titles[1]);
    }

    // php bin/console parse-news-source "https://highload.today/uk/category/novyny/" "body div.hfeed div.site-content div.container div.content-area main.site-main div.row div.sidebar-center div.lents-item" "a h2" "p" "a div.lenta-image img"
}