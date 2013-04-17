<?php

namespace Grid\Embed\Model\Parser\Oembed\Provider;

use Zend\Dom\Query;
use Grid\Embed\Model\Parser\Oembed;
use Grid\Embed\Model\Parser\Oembed\ProviderAbstract;

/**
 * Default Oembed provider adapter
 * Implements Oembed discovery mode
 *
 * @author Kristof Matos <kristof.matos@megaweb.hu>
 * @author David Pozsar <david.pozsar@megaweb.hu>
 */
class DefaultDiscovery extends ProviderAbstract
{

    /**
     * Stores readed provider API endpint URL with request URL
     *
     * @var string
     */
    private $_feedUrl    = null;

    /**
     * Stores provider response data format
     *
     * @var string json|xml
     */
    private $_feedFormat = null;

    /**
     * @see \Embed\Model\Parser\Oembed\ProviderAbstract::getFeedUrl()
     *
     * @param string $contentUrl
     * @return string|false
     */
    public function getFeedUrl( $contentUrl )
    {
        if ( is_null( $this->_feedUrl ) )
        {
            $this->discover( $contentUrl );
        }

        return $this->_feedUrl;
    }

    /**
     * @see \Embed\Model\Parser\Oembed\ProviderAbstract::getFeedFormat()
     *
     * @return string json|xml
     */
    public function getFeedFormat()
    {
        return $this->_feedFormat;
    }

    /**
     * Tries discover the given URL and set $_feedUrl and $_feedFormat
     * returns FALSE if no oembed data
     *
     * @param string|false $url
     */
    private function discover( $url )
    {
        static $paths = array(
            Oembed::FEED_FORMAT_JSON => '//link[@href][@type=\'application/json+oembed\']',
            Oembed::FEED_FORMAT_XML  => '//link[@href][@type=\'text/xml+oembed\']',
        );

        $this->_feedUrl = false;

        try
        {
            $httpClient     = clone $this->getServiceLocator()
                                         ->get( 'Zend\Http\Client' );
            $httpResponse   = $httpClient->setUri( $url )
                                         ->send();

            if ( $httpResponse && $httpResponse->isSuccess())
            {
                $query = new Query( $httpResponse->getBody() );

                foreach ( $paths as $format => $path )
                {
                    foreach ( $query->queryXpath( $path ) as $node )
                    {
                        $this->_feedFormat  = $format;
                        $this->_feedUrl     = $node->getAttribute( 'href' );
                        return;
                    }
                }
            }
        }
        catch ( \Exception $ex )
        {
            //do nothing
        }
    }

}
