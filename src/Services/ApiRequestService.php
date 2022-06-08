<?php


namespace App\Services;


use App\Interfaces\ApiRequestInterface;

/**
 * Class ApiRequestService
 * @package App\Services
 */
class ApiRequestService
{

    private $apiRequest;
    const BASE_URL_REQUEST = 'http://api.icndb.com/';

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->apiRequest->sendApiRequest('categories');
    }

    /**
     * @param string $category
     * @return mixed
     */
    public function getJokesByCategory(string $category)
    {
        return $this->apiRequest->sendApiRequest("jokes/random?[$category]");
    }

    /**
     * @param ApiRequestInterface $apiRequest
     */
    public function setApiRequestHelper(ApiRequestInterface $apiRequest)
    {
        $this->apiRequest = $apiRequest;
    }
}