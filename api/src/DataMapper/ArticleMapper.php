<?php

namespace App\DataMapper;

use App\Entity\Article;

class ArticleMapper
{
    private const MAX_POPULAR_ARTICLES = 7;

    /**
     * @param Article[] $articles
     * @return array
     */
    public function mapPopular(array $articles) : array
    {
        $mappedArticles = [];
        foreach ($articles as $article) {
            if ($article->getGame() === null) {
                continue;
            }
            $mappedArticles[$article->getGame()->getSlug()][] = $article;
        }

        $mergedArticles = [];
        foreach ($mappedArticles as &$articles) {
            $articles = array_slice($articles, 0, self::MAX_POPULAR_ARTICLES);
            $mergedArticles = array_merge($mergedArticles, $articles);
        }

        return $mergedArticles;
    }
}
