<?php

namespace App\MessageHandler;

date_default_timezone_set('UTC');

use App\Message\NewsParser;
use App\Repository\NewsRepository;
use App\Entity\News;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use \DateTimeImmutable;

class NewsParserHandler implements MessageHandlerInterface
{

    

    /**
     * @var NewsRepository
     */
    private $newsRepository;


    /**
     * autowire the NewsRepository 
     */
    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }


    /**
     * actual handler which fetches from the queue and add to the database
     */
    public function __invoke(NewsParser $newsParser)
    {


        $title = $newsParser->getTitle();
        $shortDescription = $newsParser->getShortDescription();
        $picture = $newsParser->getPicture();


        $isNewsAvailable = $this -> loadNews( $title );

        if(is_null($isNewsAvailable )){
            $news =  new News();
            $news->setTitle($title);
            $news->setShortDescription($shortDescription);
            $news->setPicture($picture);
            $news->setDateAdded(new DateTimeImmutable('NOW'));
            $news->setLastUpdatedAt(new DateTimeImmutable('NOW'));
            $this->newsRepository->add($news);
        }else{
            $news =  new News();
            $news = $isNewsAvailable;
            $news->setLastUpdatedAt(new DateTimeImmutable('NOW'));
            $this->newsRepository->add($news);
        }

    }



    /**
     * @return Entity\News\null
     * 
     * check to see if news is available and returns null if not available
     */
    public function loadNews(string $title): ?News
    {
        $news = $this->newsRepository->findOneByTitle($title);
        return $news;
    }
}