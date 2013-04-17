<?php

namespace Grid\Embed\Model\Parser\Oembed\Provider;

use Grid\Embed\Model\Parser\Oembed;
use Grid\Embed\Model\Parser\Oembed\ProviderAbstract;

/**
 * Hulu Oembed provider adapter
 *
 * @author Kristof Matos <kristof.matos@megaweb.hu>
 */
class Hulu extends ProviderAbstract
{

    /**
     * API endpoint
     */
    const API_ENDPOINT = 'http://www.hulu.com/api/oembed';

    /**
     * @see \Embed\Model\Parser\Oembed\ProviderAbstract::getFeedUrl()
     *
     * @param string $contentUrl
     * @return string|false
     */
    public function getFeedUrl($contentUrl)
    {
        $regex = "@^http://([a-z\.-]*\.)?hulu\.com/watch/.+@i";
        return ( (boolean)preg_match($regex, $contentUrl))
                ? self::API_ENDPOINT
                   .'.'.$this->getFeedFormat()
                   .'?url='.urlencode($contentUrl)
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
