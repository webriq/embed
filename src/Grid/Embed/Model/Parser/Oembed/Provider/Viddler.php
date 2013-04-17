<?php

namespace Grid\Embed\Model\Parser\Oembed\Provider;

use Grid\Embed\Model\Parser\Oembed;
use Grid\Embed\Model\Parser\Oembed\ProviderAbstract;

/**
 * Viddler Oembed provider adapter
 *
 * @author Kristof Matos <kristof.matos@megaweb.hu>
 */
class Viddler extends ProviderAbstract
{

    /**
     * API endpoint
     */
    const API_ENDPOINT = 'http://lab.viddler.com/services/oembed/';

    /**
     * @see \Embed\Model\Parser\Oembed\ProviderAbstract::getFeedUrl()
     *
     * @param string $contentUrl
     * @return string|false
     */
    public function getFeedUrl($contentUrl)
    {
        $regex = '@^http://([a-z\.-]*\.)?viddler\.com/.+@i';
        return ( (boolean)preg_match($regex, $contentUrl))
                ? self::API_ENDPOINT
                   .'?url='.urlencode($contentUrl)
                   .'&format='.$this->getFeedFormat()
                : false;
    }

    /**
     * @see \Embed\Model\Parser\Oembed\ProviderAbstract::getFeedFormat()
     *
     * @return string json|xml
     */
    public function getFeedFormat()
    {
        return Oembed::FEED_FORMAT_JSON;
    }

}
