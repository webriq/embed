<?php

namespace Grid\Embed\Model\Parser\Oembed\Content;

use Grid\Embed\Model\Parser\Oembed\ContentAbstract;

/**
 * Default/link oembed content adapter
 *
 * @author Kristof Matos <kristof.matos@megaweb.hu>
 */
class Photo extends ContentAbstract
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
        if( $oembedData->type == 'photo'
            && isset($oembedData->url)
            && isset($oembedData->width)
            && isset($oembedData->height))
        {
            return '<div style="text-align: center"'
                    .' data-embed-type="oembed/photo" '
                    .' data-embed-width="'.$oembedData->width.'" '
                    .' data-embed-height="'.$oembedData->height.'" '
                    .'>'
                    .'<img src="'.$oembedData->url.'" '
                    .'alt="'.htmlentities($oembedData->title,ENT_COMPAT).'" '
                    .'width="'.$oembedData->width.'" '
                    .'height="'.$oembedData->height.'" '
                    . ' />'
                    .'</div>';
                    
        }
        return false;
    }
}