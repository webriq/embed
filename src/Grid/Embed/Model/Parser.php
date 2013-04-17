<?php

namespace Grid\Embed\Model;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zork\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Grid\Embed\Model\Parser\AdapterInterface as ParserAdapterInterface;

/**
 * Oembed parser service
 *
 * @implements \Zend\ServiceManager\ServiceLocatorAwareInterface
 *
 * @author Kristof Matos <kristof.matos@megaweb.hu>
 */
class Parser implements ServiceLocatorAwareInterface
{

    use ServiceLocatorAwareTrait;

    const ERROR_CAN_NOT_EXTRACT_URL   = 'embed.parser.error.cannotextracturl';
    const ERROR_CONTENT_NOT_FOUND     = 'embed.parser.error.contentnotfound';
    const ERROR_SERVICE_NOT_AVAILABLE = 'embed.parser.error.servicenotavailable';
    const ERROR_CONTENT_NOT_SUPPORTED = 'embed.parser.error.contentnotsupported';

    protected $parserAdapter = null;

    /**
     * Constructor
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->setServiceLocator($serviceLocator);
    }

    /**
     * Extracts URL
     * Returns error message on error, otherwise NULL
     *
     * @param string $url
     * @param array $params
     * @return null|string
     */
    public function extractUrl($url,$params=array())
    {
        $handled = false;

        $parserFactory = $this->getServiceLocator()
                              ->get('Grid\Embed\Model\Parser\AdapterFactory');

        foreach( $parserFactory->getRegisteredAdapters() as $adapterName => $adapterClass )
        {
            $parser = $parserFactory->factory($adapterName);
            $accepted = $parser->parse($url,$params);
            if( $accepted )
            {
                $this->parserAdapter = $parser;
                $handled = true;
                break;
            }
        }

        return $this->getError();
    }

    /**
     * Returns embed HTML code
     *
     * @return string
     */
    public function getEmbedHtml()
    {
        return $this->parserAdapter instanceof ParserAdapterInterface
               ? $this->parserAdapter->getEmbedHtml()
               : null;
    }

    /**
     * Returns preview HTML code
     *
     * @return string
     */
    public function getPreviewHtml()
    {
        return $this->parserAdapter instanceof ParserAdapterInterface
               ? $this->parserAdapter->getPreviewHtml()
               : null;
    }

    /**
     * Returns parsing error
     *
     * @return string
     */
    public function getError()
    {
        return $this->parserAdapter instanceof ParserAdapterInterface
               ? $this->parserAdapter->getError()
               : self::ERROR_CAN_NOT_EXTRACT_URL;
    }

}
