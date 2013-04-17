<?php

namespace Grid\Embed\Model\Parser\Oembed\Provider;

use Grid\Embed\Model\Parser\Oembed;
use Grid\Embed\Model\Parser\Oembed\ProviderAbstract;

/**
 * PhotoBucket Oembed provider adapter
 *
 * @author Kristof Matos <kristof.matos@megaweb.hu>
 */
class PhotoBucket extends ProviderAbstract
{

    /**
     * API endpoint
     */
    const API_ENDPOINT = 'http://photobucket.com/oembed';

    /**
     * @see \Embed\Model\Parser\Oembed\ProviderAbstract::getFeedUrl()
     *
     * @param string $contentUrl
     * @return string|false
     */
    public function getFeedUrl($contentUrl)
    {
        return
            (
              preg_match('@http://([a-z\.-]*\.)?photobucket\.com/(albums|groups|user)/.+@i',$contentUrl)
            )
            ? self::API_ENDPOINT
               .'?format='.$this->getFeedFormat()
               .'&url='.urlencode($contentUrl)
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
