<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\News;
use App\Repository\NewsRepository;
use Twig\Environment;
use App\Message\NewsParser;

class NewsController extends AbstractController
{
    

    /**
     * @Route("/news/delete/{title}", name="delete_news")
     */
    public function removeNews($title, Environment $twig, NewsRepository $newsRepository): Response
    {
        $news = $this->getDoctrine() ->getRepository(News::class)
                                ->findOneByTitle($title);

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if(!is_null($news )){
            $this->getDoctrine()
                        ->getRepository(News::class)
                        ->remove($news);
        }
        
        $paginator = $newsRepository->getNewsPaginator(0);                

        return new Response($twig->render('news/index.html.twig', [
            'newsList' => $paginator,
            'previous' => 0 - NewsRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), 0 + NewsRepository::PAGINATOR_PER_PAGE),
            ]));

    }



    // #[Route('/news', name: 'conference')]
    /**
     * @Route("/news", name="app_news")
     */
    public function show(Request $request, Environment $twig, NewsRepository $newsRepository): Response
         {
            
            $offset = max(0, $request->query->getInt('offset', 0));
            $paginator = $newsRepository->getNewsPaginator($offset);
    
             return new Response($twig->render('news/index.html.twig', [
                'newsList' => $paginator,
                'previous' => $offset - NewsRepository::PAGINATOR_PER_PAGE,
                'next' => min(count($paginator), $offset + NewsRepository::PAGINATOR_PER_PAGE),
             ]));
         }



    //      // #[Route('/news', name: 'conference')]
    // /**
    //  * @Route("/news", name="app_news")
    //  */
    // public function show(Request $request, Environment $twig, NewsRepository $newsRepository): Response
    // {
    //    $offset = max(0, $request->query->getInt('offset', 0));
    //    $paginator = $newsRepository->getNewsPaginator($offset);

    //     return new Response($twig->render('news/index.html.twig', [
    //        'newsList' => $paginator,
    //        'previous' => $offset - NewsRepository::PAGINATOR_PER_PAGE,
    //        'next' => min(count($paginator), $offset + NewsRepository::PAGINATOR_PER_PAGE),
    //     ]));
    // }


         
}



    

