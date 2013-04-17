<?php

namespace Grid\Embed\Model\Parser\Oembed;

use Zork\Factory\AdapterAbstract;

/**
 * Oembed content type adapter abstract
 *
 * @author Kristof Matos <kristof.matos@megaweb.hu>
 */
abstract class ContentAbstract extends AdapterAbstract 
{
    /**
     * Returns html code from oembed response data 
     * or FALSE if type does not match
     * 
     * @param object $oembedData
     * @return string|false
     */
    abstract public function getEmbedHtml($oembedData);
    
    /**
     * @implements \Zork\Factory\AdapterInterface
     */
    public static function acceptsOptions( array $options ){return true;}
}