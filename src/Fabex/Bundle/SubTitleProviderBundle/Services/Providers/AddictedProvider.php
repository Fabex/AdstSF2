<?php
/**
 * Created by PhpStorm.
 * User: fabex
 * Date: 11/3/13
 * Time: 6:12 AM
 */

namespace Fabex\Bundle\SubTitleProviderBundle\Services\Providers;

use Goutte\Client;

class AddictedProvider extends SubTitleProviderAbstract
{
    public function __construct()
    {
        $this->goutte = new Client();
    }

    public function getSubTitle($serie, $fullNameSerie, $season, $episode)
    {
        $url = 'http://www.addic7ed.com/serie/'.urlencode($fullNameSerie).'/'.urlencode($season).'/'.urlencode($episode).'/8';
        $crawler = $this->goutte->request('GET', $url);
        $subtitleLinks = $crawler->filter('.buttonDownload');
        $titles = array();
        $crawler->filter('.NewsTitle img[src="/images/folder_page.png"]')->each(function($e) use (&$titles){$titles[] = $e->parents()->text();});
        foreach ($subtitleLinks as $key => $subtitleLink) {
            $this->addSubtitle($titles[$key], 'http://www.addic7ed.com'.$subtitleLink->getAttribute("href"));
        }
        return $this->subtiles;
    }
}