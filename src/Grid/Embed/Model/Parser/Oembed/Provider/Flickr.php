<?php

namespace Grid\Embed\Model\Parser\Oembed\Provider;

use Grid\Embed\Model\Parser\Oembed;
use Grid\Embed\Model\Parser\Oembed\ProviderAbstract;

/**
 * Flickr Oembed provider adapter
 *
 * @author Kristof Matos <kristof.matos@megaweb.hu>
 */
class Flickr extends ProviderAbstract
{

    /**
     * API endpoint
     */
    const API_ENDPOINT = 'http://www.flickr.com/services/oembed';

    /**
     * @see \Embed\Model\Parser\Oembed\ProviderAbstract::getFeedUrl()
     *
     * @param string $contentUrl
     * @return string|false
     */
    public function getFeedUrl($contentUrl)
    {
        $regex = array(
            '@^http://([a-z\.-]*\.)?flic\.kr/p/.+@i',
            '@^http://([a-z\.-]*\.)?flickr\.com/photos/.+@i',
        );
        return ( (boolean)preg_match($regex[0], $contentUrl)
                  ||
                 (boolean)preg_match($regex[1], $contentUrl))
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
