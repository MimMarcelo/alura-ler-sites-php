<?php

namespace mimmarcelo\BuscadorDeCursos;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador {

    private $httpClient;
    private $crawler;

    function __construct(ClientInterface $httpClient, Crawler $crawler) {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }

    public function buscar(string $url): array {
        $resposta = $this->httpClient->request('GET', $url);

        $html = $resposta->getBody();

        $this->crawler->addHtmlContent($html);
        $eCursos = $this->crawler->filter("span.card-curso__nome");

        $cursos = [];

        foreach ($eCursos as $curso) {
            $cursos[] = $curso->textContent;
        }
        
        return $cursos;
    }

}
