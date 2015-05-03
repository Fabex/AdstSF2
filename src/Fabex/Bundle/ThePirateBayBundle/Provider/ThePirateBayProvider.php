<?php
/**
 * Created by PhpStorm.
 * User: fabex
 * Date: 03/05/15
 * Time: 01:21
 */

namespace Fabex\Bundle\ThePirateBayBundle\Provider;

use Fabex\Bundle\AppBundle\Provider\Torrent\TorrentProviderInterface;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class ThePirateBayProvider
 * @package Fabex\Bundle\ThePirateBayBundle\Provider
 */
class ThePirateBayProvider implements TorrentProviderInterface
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
     * @param string $torrentName
     * @return mixed|void
     */
    public function getBestTorrent($torrentName)
    {
        $crawler = $this->client->request('GET', $this->url . '/' . $torrentName . '/0/7/0');

        $bestTorrent = array('magnet' => '', 'seeder' => 0);

        $firstTr = $crawler->filter('#searchResult > tr')->first();
        if ($firstTr->count()) {
            $firstTr->children()->each(
                function ($td, $index) use (&$bestTorrent) {
                    /** @var Crawler $td */
                    switch ($index) {
                        case 1 :
                            $bestTorrent['magnet'] = $td->children()->first()->siblings()->attr('href');
                            break;
                        case 2 :
                            $bestTorrent['seeder'] = (int)$td->text();
                            break;
                        default:
                            break;
                    }
                }
            );
        }

        return $bestTorrent;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'The Pirate Bay';
    }
}
