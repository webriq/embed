<?php

namespace Grid\Embed\Model\Parser;

use Zork\Factory\AdapterInterface as FactoryAdapterInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

/**
 * Embed parser adapter interface
 *
 * @extends \Zork\Factory\AdapterInterface
 * @extends \Zend\ServiceManager\ServiceLocatorAwareInterface
 *
 * @author Kristof Matos <kristof.matos@megaweb.hu>
 */
interface AdapterInterface extends
                                FactoryAdapterInterface,
                                ServiceLocatorAwareInterface
{
    /**
     * Extract given URL
     *
     * @param string $contentUrl
     * @param array $params
     * @return boolean
     */
    public function parse($contentUrl,$params=array());

    /**
     * Gets embed HTML code
     *
     * @return string
     */
    public function getEmbedHtml();

    /**
     * Gets preview HTML code
     *
     * @return string
     */
    public function getPreviewHtml();

    /**
     * Gets error message
     *
     * @return string
     */
    public function getError();
}