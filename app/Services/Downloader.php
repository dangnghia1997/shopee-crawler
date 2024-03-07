<?php
declare(strict_types=1);

namespace App\Services;

use App\Interfaces\DownloaderInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class Downloader implements DownloaderInterface
{
    public function __construct(
        readonly private Client $client
    ) {}

    /**
     * @param string $url
     * @return string|null
     */
    public function execute(string $url): string | null
    {
        try {
            $response = $this->client->get($url);
            $body = (string)$response->getBody();
            $url = preg_replace('/\/$/', '', $url);
            $this->saveContent($body, $url);
            return $body;
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            //if we fail, we return with a error status code
            // TODO: Handle Log
            return null;
        }
    }

    protected function saveContent(string $body, $url): void
    {
        $fileName = $this->getFileName($url);
        $version = date('Y_m_d');
        $dir = 'json_data/'. $version . "/";
        $path = $dir . $fileName;

        $json = json_decode($body);
        $data = json_encode($json?->data ?? []);
        $saved = Storage::put($path, $data);

        if ($saved) {
            // TODO: Publish to queue with saved file path
        }
    }

    /**
     * @param string $url
     * @return string
     */
    protected function getFileName(string $url): string
    {
        $parsedLink = parse_url($url);
        $query = $parsedLink['query'] ?? '';
        parse_str($query, $params);
        $page = $params['page'] ?? 1;
        $ext = '.json';
        return sprintf("url_key_%s_cat_%s_page_%s%s", $params['urlKey'], $params['category'], $page, $ext);
    }
}
