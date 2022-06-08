<?php


namespace App\Controller;


use App\Services\JokeHelperService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class JokeController
 * @package App\Controller
 */
class JokeController extends AbstractController
{
    /**
     * @var JokeHelperService
     */
    private $jokeHelperService;

    /**
     * MainController constructor.
     * @param JokeHelperService $jokeHelperService
     */
    public function __construct(JokeHelperService $jokeHelperService)
    {
        $this->jokeHelperService = $jokeHelperService;
    }

    /**
     * @Route("/joke", methods={"GET"})
     * @param Request $request
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function sendJokeEmailByCategory(Request $request)
    {
        $view = $this->jokeHelperService->getView($request);
        return $this->renderForm('joke.send.html.twig', [
            'form' => $view
        ]);
    }
}