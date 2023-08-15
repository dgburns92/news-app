<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\Article\SearchFilters;
use App\ApiResource\Article;
use App\Transformer\GuardianArticleCollectionTransformer;
use App\Transformer\GuardianArticleTransformer;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GuardianArticleRepository implements ArticleRepositoryInterface
{
    private const GUARDIAN_API_URL = 'https://content.guardianapis.com/';

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly GuardianArticleTransformer $transformer,
        private readonly GuardianArticleCollectionTransformer $collectionTransformer,
        private readonly string $apiKey
    ) {
    }

    public function search(SearchFilters $filters): array
    {
        try {
            $response = $this->client->request(
                'GET',
                self::GUARDIAN_API_URL . "search",
                [ 'query' => [ 'q' => $filters->keyword, 'api-key' => $this->apiKey ] ]
            );

            $data = $response->toArray();
        } catch (ExceptionInterface $exception) {
            /**
             * TODO: handle failure according to client requirements
             * (e.g. throw exception, or alternatively return 0 results)
             * @see \Symfony\Contracts\HttpClient\ResponseInterface for exception types
             */
            throw $exception;
        }

        return $this->collectionTransformer->transform($data);
    }

    public function findById(string $id): Article
    {
        try {
            $response = $this->client->request(
                'GET',
                self::GUARDIAN_API_URL . $id,
                [ 'query' => ['api-key' => $this->apiKey ] ]
            );

            $data = $response->toArray();
        } catch (ExceptionInterface $exception) {
            /**
             * TODO: handle failure according to client requirements
             * (e.g. throw exception, or alternatively return 0 results)
             * @see \Symfony\Contracts\HttpClient\ResponseInterface for exception types
             */
            throw $exception;
        }

        return $this->transformer->transform($data);
    }
}
