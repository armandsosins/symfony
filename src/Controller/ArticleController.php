<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ArticleController extends AbstractController
{
    private ValidatorInterface $validator;
    private UserRepository $userRepository;

    public function __construct(ValidatorInterface $validator, UserRepository $userRepository)
    {
        $this->validator = $validator;
        $this->userRepository = $userRepository;
    }

    public function __invoke(Request $request, ArticleRepository $articles, NormalizerInterface $normalizer): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        $title = $requestData['title'] ?? null;
        $body = $requestData['body'] ?? null;
        $email = $requestData['author'] ?? null;
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        if (!$title) {
            return new JsonResponse(['message' => 'Title is required'], Response::HTTP_BAD_REQUEST);
        }
        if (!$body) {
            return new JsonResponse(['message' => 'Body is required'], Response::HTTP_BAD_REQUEST);
        }

        $article = new Article();
        $article->setTitle($title);
        $article->setBody($body);
        $article->setAuthor($user);

        $errors = $this->validator->validate($article);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = ucfirst($error->getPropertyPath()) . ':' . $error->getMessage();
            }

            return new JsonResponse(['message' => 'Failed to create Article', 'errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
        }

        $articles->add($article, true);

        $normalizedArticle = $normalizer->normalize($article, null, ['groups' => ['create']]);

        return new JsonResponse(
            ['message' => 'Article created successfully', 'article' => $normalizedArticle]
        );
    }
}
