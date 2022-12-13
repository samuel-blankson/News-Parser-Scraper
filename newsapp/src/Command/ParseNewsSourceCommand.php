<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Scraper\Scraper;

class ParseNewsSourceCommand extends Command
{
    protected static $defaultName = 'parse-news-source';
    protected static $defaultDescription = 'Pass a news source to schedule scraping';


    private Scraper $scraper;

    public function __construct(Scraper $scraper)
    {
        $this->scraper = $scraper;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('url', InputArgument::OPTIONAL, 'The webpage url ')
            ->addArgument('wrapperSelector', InputArgument::OPTIONAL, 'The parent div of the news card')
            ->addArgument('titleSelector', InputArgument::OPTIONAL, 'The h1 element containing the header text')
            ->addArgument('descriptionSelector', InputArgument::OPTIONAL, 'The Paragraph element containing the news short description')
            ->addArgument('imageSelector', InputArgument::OPTIONAL, 'The img element containing a src attribute')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
       

        $io = new SymfonyStyle($input, $output);
        $url = $input->getArgument('url');

        $wrapperSelector = $input->getArgument('wrapperSelector');

        $titleSelector = $input->getArgument('titleSelector');

        $shortDescriptionSelector = $input->getArgument('descriptionSelector');

        $imageSelector = $input->getArgument('imageSelector');

         // creates a new object for news 
         $sourceObject = [
             'url' => $url,
             'wrapperSelector' => $wrapperSelector,
             'titleSelector' => $titleSelector,
             'shortDescriptionSelector' => $shortDescriptionSelector,
             'imageSelector' => $imageSelector,
            ];

        if ($url) {
            $io->note(sprintf('You passed a url argument: %s', $url));
        }

        if ($wrapperSelector) {
            $io->note(sprintf('You passed a wrapper argument: %s', $wrapperSelector));
        }

        if ($titleSelector) {
            $io->note(sprintf('You passed a titleSelector argument: %s', $titleSelector));
        }

        if ($shortDescriptionSelector) {
            $io->note(sprintf('You passed a shortDescriptionSelector argument: %s', $shortDescriptionSelector));
        }

        if ($imageSelector) {
            $io->note(sprintf('You passed a shortDescriptionSelector argument: %s', $imageSelector));
        }

       $newsData = $this->scraper->scrap($url,$wrapperSelector,$titleSelector,$shortDescriptionSelector,$imageSelector);

        
       $io->note(sprintf('data: %s', $newsData));

        $io->success($newsData);

        return Command::SUCCESS;
    }
}
