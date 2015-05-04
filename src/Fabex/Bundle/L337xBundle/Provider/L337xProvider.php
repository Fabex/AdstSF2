<?php
/**
 * Created by PhpStorm.
 * User: fabex
 * Date: 03/05/15
 * Time: 01:21
 */

namespace Fabex\Bundle\L337xBundle\Provider;

use Fabex\Bundle\AppBundle\Provider\Torrent\TorrentProviderInterface;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Link;

/**
 * Class L337xProvider
 * @package Fabex\Bundle\L337xBundle\Provider
 */
class L337xProvider implements TorrentProviderInterface
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
        $bestTorrent = array('magnet' => '', 'seeder' => 0);
        $crawler = $this->client->request('GET', $this->url . '/' . $torrentName . '/seeders/desc/1/');
        $firstLi = $crawler->filter('.main-content > .search-result')->last()->filter('ul > li')->first();
        if ($firstLi->count()) {
            $firstLi->children()->each(
                function (Crawler $div, $index) use (&$bestTorrent) {
                    /** @var Crawler $div */
                    switch ($index) {
                        case 0 :
                            $bestTorrent['magnet'] = $this->findMagnet($div->filter('strong a')->link());
                            break;
                        case 1 :
                            $bestTorrent['seeder'] = (int)$div->filter('span')->first()->text();
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
     * @param Link $link
     * @return string
     */
    protected function findMagnet(Link $link)
    {
        $crawler = $this->client->click($link);

        return $crawler->filter('.magnet')->first()->attr('href');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '1337x';
    }
}
