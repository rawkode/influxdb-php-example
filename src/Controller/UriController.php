<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Uri;

class UriController extends AbstractController
{
    /**
     * @Route("/uri", methods={"POST"}, name="uri_create")
     */
    public function createUri(Request $request)
    {
        if (!$longUri = $request->request->get('longUri', null)) {
            return $this->json(["error" => "Failed to provide `longUri` parameter"], Response::HTTP_BAD_REQUEST);
        }

        if (!$shortUri = $request->request->get('shortUri', null)) {
            return $this->json(["error" => "Failed to provide `shortUri` parameter"], Response::HTTP_BAD_REQUEST);
        }

        $uri = Uri::create($shortUri, $longUri);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($uri);
        $entityManager->flush();

        return $this->json(["short" => $uri->shortUri(), "long" => $uri->longUri()]);
    }

    /**
     * @Route("/uri/{shortUri}", methods={"GET"}, name="uri_get")
     */
    public function getUri(Uri $uri)
    {
        if (empty($uri)) {
            return $this->json(['message' => "Failed to find shortened Uri"], Response::HTTP_NOT_FOUND);
        }

        return $this->json(['short' => $uri->shortUri(), 'long' => $uri->longUri()]);
    }
}
