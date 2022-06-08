<?php


namespace App\Services;


use App\Form\JokeCategoryForm;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

/**
 * Class JokeHelperService
 * @package App\Services
 */
class JokeHelperService
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    private $jokeApiService;
    private $mailerHelperService;
    private $fileHelperService;

    /**
     * JokeHelperService constructor.
     * @param FormFactoryInterface $formFactory
     * @param JokeApiService $jokeApiService
     * @param MailerHelperService $mailerHelperService
     */
    public function __construct(FormFactoryInterface $formFactory,
                                JokeApiService $jokeApiService,
                                MailerHelperService $mailerHelperService,
                                FileHelperService $fileHelperService)
    {
        $this->formFactory = $formFactory;
        $this->jokeApiService = $jokeApiService;
        $this->mailerHelperService = $mailerHelperService;
        $this->fileHelperService = $fileHelperService;
    }

    /**
     * @param Request $request
     * @return FormInterface
     * @throws TransportExceptionInterface
     */
    public function getView(Request $request)
    {
        $jokeCategories = $this->jokeApiService->getCategories();
        $jokeCategories = array_combine($jokeCategories['value'], $jokeCategories['value']);
        $form = $this->formFactory->create(JokeCategoryForm::class, null, [
            'form_choices' => $jokeCategories
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $jokeCategory = $form->get('category')->getData();
            $jokeByCategory = $this->jokeApiService->getJokesByCategory($jokeCategory);
            $this->fileHelperService->writeData(realpath(__DIR__ . '/..' . '/..') . "/var/log/joke.data", FileManagerService::APPEND_EXTENDED, $jokeByCategory['value']);
            $this->mailerHelperService->sendMail($form->get('email')->getData(), $jokeByCategory['value']['joke'], $jokeCategory);
            return $form;
        }

        return $form;

    }
}