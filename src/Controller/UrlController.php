<?php

namespace App\Controller;

use App\Form\UrlShortenType;
use App\Manager\UrlManager;
use App\Service\StatService;
use App\Service\UrlService;
use DateTime;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UrlController extends AbstractController
{
    /**
     * @Route("/", name="url_index")
     */
    public function index(Request $request, UrlManager $urlManager, UrlService $urlService)
    {
        $form = $this->createForm(UrlShortenType::class, $urlManager, [
            'attr' => ['class' => 'form pt-2'],
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $urlEntity = $urlManager->save();
            } catch (\Exception $e) {
                return $this->render('url/error.html.twig', [
                    'error_message' => "Can't save link",
                ]);
            }
            return $this->render('url/index.html.twig', [
                'form' => $form->createView(),
                'short_url' => $urlService->shorten($urlEntity),
            ]);
        }
        return $this->render('url/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{shortUrl}", name="url_enlarge")
     */
    public function enlarge(Request $request, UrlService $urlService, StatService $statService, LoggerInterface $logger)
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
        try {
            $statService->save($request, $urlEntity);
        } catch (\Exception $e) {
            // just log
            $logger->error("Can't save stat", [
                'short-url' => $request->get('shortUrl'),
                'exception' => $e->getMessage(),
            ]);
        }
        return $this->redirect($urlEntity->getUrl());
    }
}
