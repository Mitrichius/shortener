<?php

namespace App\Controller;

use App\Service\UrlService;
use DateTime;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StatController extends AbstractController
{
    /**
     * @Route("/stat/{shortUrl}", name="url_stat")
     */
    public function stat(Request $request, UrlService $urlService, PaginatorInterface $paginator)
    {
        $shortUrl = $request->get('shortUrl');
        $urlEntity = $urlService->enlarge($shortUrl);
        if (
            $urlEntity === null ||
            ($urlEntity->getValidTill() &&
                $urlEntity->getValidTill() <= new DateTime())
        ) {
            return $this->render('url/error.html.twig', [
                'error_message' => 'Link is invalid or expired',
            ]);
        }
        $pagination = $paginator->paginate(
            $urlEntity->getStats(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('stat/index.html.twig', [
            'short_url' => $shortUrl,
            'stats' => $pagination,
        ]);
    }
}
