<?php

namespace App\Services;

use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class ImageParser
{
    #[ArrayShape(['data' => "string[]", 'totalCount' => "int", 'totalSizeMb' => "int"])]
    public function execute(string $url): array
    {
        $client = HttpClient::create();

        $preparedListImages = [];
        $totalSizeBits = 0;

        $listImages = $this->getFilteredImages($url, $client);

        foreach($listImages as $imageUrl) {
            if ((int)$client->request('GET', $imageUrl)->getStatusCode() !== 200) {
                continue;
            }

            $size = $this->getRemoteFilesize($imageUrl);

            if ((int)$size > 0) {
                $totalSizeBits += $size;
                $preparedListImages[] = $imageUrl;
            }
        }

        return [
          'data' => $preparedListImages,
          'totalCount' => count($preparedListImages),
          'totalSizeMb' => round($totalSizeBits / 1048576,3)
        ];
    }

    private function getFilteredImages(string $url, $client): array
    {
        $response = $client->request('GET', $url);

        $imagesResult = [];

        if ((int)$response->getStatusCode() !== 200) {
            return $imagesResult;
        }

        $content = $response->getContent();
        $crawler = new Crawler($content);

        $images = $crawler
            ->filterXpath('//img')
            ->extract([('src')]);

        foreach($images as $image) {
            if (strpos($image, '.svg')) {
                continue;
            }

            if ((str_contains($image, 'http://')) || (str_contains($image, 'https://'))) {
                $imagesResult[] = $image;
                continue;
            }

            $imagesResult[] = $url . '/' . $image;
        }

        return $imagesResult;
    }

    // The function may not be completely accurate.
    private function getRemoteFilesize($file_url)
    {
        $head = array_change_key_case(get_headers($file_url, 1));
        $contentLength = $head['content-length'] ?? 0; // content-length of download (in bytes), read from Content-Length: field

        // cannot retrieve file size, return “-1”
        if (!$contentLength) {
            return 0;
        }

        return $contentLength;
    }
}