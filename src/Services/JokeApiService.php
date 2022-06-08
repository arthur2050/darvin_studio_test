<?php


namespace App\Services;

/**
 * Class JokeApiService
 * @package App\Services
 */
class JokeApiService
{
    private $apiRequestService;

    /**
     * JokeApiService constructor.
     * @param ApiRequestService $apiRequestService
     */
    public function __construct(ApiRequestService $apiRequestService)
    {
        $this->apiRequestService = $apiRequestService;
        $this->apiRequestService->setApiRequestHelper(new GuzzleHelperService($this->apiRequestService::BASE_URL_REQUEST));
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return json_decode($this->apiRequestService->getCategories()->getBody()->getContents(), true);
    }

    /**
     * @param string $category
     * @return mixed
     */
    public function getJokesByCategory(string $category)
    {
        return json_decode($this->apiRequestService->getJokesByCategory($category)->getBody()->getContents(), true);
    }
}