<?php

namespace Grid\Embed\Model\Parser\Oembed\Content;

use Grid\Embed\Model\Parser\Oembed\ContentAbstract;

/**
 * Default/link oembed content adapter
 *
 * @author Kristof Matos <kristof.matos@megaweb.hu>
 */
class DefaultLink extends ContentAbstract
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
        if( $oembedData->type == 'link' 
            || ( isset($oembedData->title) && !empty($oembedData->title) ) 
          ) 
        {
            if( isset($oembedData->html) && !empty($oembedData->html) )
            {
                return  '<div data-embed-type="oembed/link" >'
                        .$oembedData->html
                        .'</div>';
            }
            else
            {
                $url = ( isset($oembedData->url) && !empty($oembedData->url) )
                       ? $oembedData->url
                       : $oembedData->requestUrl;

                return  '<a href="'.$url.'"'
                        .' title="'.htmlentities($oembedData->title,ENT_COMPAT).'" '
                        .' target="_blank" '
                        .' data-embed-type="oembed/link" >'
                        .$oembedData->title
                        .'</a>';
            }
        }
        return false;
    }
}