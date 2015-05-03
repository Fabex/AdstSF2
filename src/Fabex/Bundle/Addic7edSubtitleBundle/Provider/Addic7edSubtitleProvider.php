<?php
/**
 * Created by PhpStorm.
 * User: fabex
 * Date: 03/05/15
 * Time: 01:21
 */

namespace Fabex\Bundle\Addic7edSubtitleBundle\Provider;

use Fabex\Bundle\AppBundle\Provider\Subtitle\SubtitleProviderInterface;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class Addic7edSubtitleProvider
 * @package Fabex\Bundle\Addic7edSubtitleBundle\Provider
 */
class Addic7edSubtitleProvider implements SubtitleProviderInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $url;

    /**
     * @param Client $client
     * @param string $url
     */
    public function __construct(Client $client, $url)
    {
        $this->client = $client;
        $this->url = $url;
    }

    /**
     * @param string $serie
     * @param string $season
     * @param string $episode
     * @param string $fullNameSerie
     * @return array|mixed
     */
    public function getSubtitle($serie, $season, $episode, $fullNameSerie)
    {
        $return = array();
        try {
            $fullNameSerie = urlencode(preg_replace("/\(\d+\) /", '', $fullNameSerie));
            $url = 'http://www.addic7ed.com/serie/' . $fullNameSerie . '/' . urlencode($season) . '/' . urlencode(
                    $episode
                ) . '/8';
            $crawler = $this->client->request('GET', $url);
            $subtitleLinks = $crawler->filter('.buttonDownload');
            $titles = array();
            $crawler->filter('.NewsTitle img[src$="/images/folder_page.png"]')->each(
                function (Crawler $e) use (&$titles) {
                    $titles[] = $e->parents()->text();
                }
            );
            foreach ($subtitleLinks as $key => $subtitleLink) {
                if (array_key_exists($key, $titles)) {
                    $return[] = array(
                        'name' => $titles[$key],
                        'file' => 'http://www.addic7ed.com' . $subtitleLink->getAttribute("href")
                    );
                }
            }
        } catch (\Exception $e) {
            return $return;
        }

        return $return;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Addic7ed';
    }
}
