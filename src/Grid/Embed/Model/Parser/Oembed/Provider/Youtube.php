<?php

namespace Grid\Embed\Model\Parser\Oembed\Provider;

use Grid\Embed\Model\Parser\Oembed;
use Grid\Embed\Model\Parser\Oembed\ProviderAbstract;

/**
 * Youtube Oembed provider adapter
 *
 * @author Kristof Matos <kristof.matos@megaweb.hu>
 */
class Youtube extends ProviderAbstract
{

    /**
     * API endpoint
     */
    const API_ENDPOINT = 'http://www.youtube.com/oembed';

    /**
     * @see \Embed\Model\Parser\Oembed\ProviderAbstract::getFeedUrl()
     *
     * @param string $contentUrl
     * @return string|false
     */
    public function getFeedUrl($contentUrl)
    {
        return
            preg_match('@http://([a-z\.-]*\.)?youtube\.com/watch@i',$contentUrl)
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

    /**
     * Fixes Youtube embed code
     *
     * @see \Embed\Model\Parser\Oembed\ProviderAbstract::parseResponse()
     *
     * @param object $response
     */
    public function parseResponse($response)
    {
        parent::parseResponse($response);

        $regexp = '#<iframe[^>]*src="([^"]+)[^>]*>#i';
        $m = array();
        if( preg_match($regexp,$this->_embedHtml,$m) )
        {
            $src = $m[1];
            $fix = $src.(strpos($src,'?')?'&':'?').'wmode=opaque';
            $this->_embedHtml = str_replace($src, $fix, $this->_embedHtml);
        }
    }

}
