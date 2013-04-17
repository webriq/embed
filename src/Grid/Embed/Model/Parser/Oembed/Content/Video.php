<?php

namespace Grid\Embed\Model\Parser\Oembed\Content;

use Grid\Embed\Model\Parser\Oembed\ContentAbstract;

/**
 * Default/link oembed content type adapter
 *
 * @author Kristof Matos <kristof.matos@megaweb.hu>
 */
class Video extends ContentAbstract
{
    /**
     * Returns html code from oembed response data 
     * or FALSE if type does not match
     * 
     * @param object $oembedData
     * @return string|false
     */
    public function getEmbedHtml($oembedData)
    {
        if( $oembedData->type == 'video' 
            && isset($oembedData->html) 
            && isset($oembedData->width)
            && isset($oembedData->height))
        {
            return '<div style="text-align: center"'
                    .' data-embed-type="oembed/video" '
                    .' data-embed-width="'.$oembedData->width.'" '
                    .' data-embed-height="'.$oembedData->height.'" '
                    .'>'
                    .$oembedData->html
                    .'</div>';
        }
        return false;
    }
}