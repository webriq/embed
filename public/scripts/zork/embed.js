/**
 * Embed interface functionalities
 *
 * @package zork
 * @subpackage embed
 * @author Kristof Matos <kristof.matos@megaweb.hu>
 */
( function ( global, $, js )
{
    "use strict";

    if ( typeof js.embed !== "undefined" )
    {
        return;
    }

    /**
     * @class Embed module
     * @constructor
     * @memberOf Zork
     */
    global.Zork.Embed = function ()
    {
        this.version = "1.0";
        this.modulePrefix = [ "zork", "embed" ];
    };

    global.Zork.Embed.prototype.initReader = function(form,isDashboard,params)
    {
        var eleInputUrl,eleInputMaxwidth,eleInputMaxheight,eleEmbedHtml,eleError;

        if( isDashboard )
        {
            eleInputUrl = form.find('input[name="paragraph-embed[inputUrl]"]');
            eleInputMaxwidth = form.find('input[name="paragraph-embed[inputMaxwidth]"]');
            eleInputMaxheight = form.find('input[name="paragraph-embed[inputMaxheight]"]');
            eleEmbedHtml = form.find('input[name="paragraph-embed[embedHtml]"]');
            eleError = form.find('input[name="paragraph-embed[error]"]');
        }
        else
        {
            eleInputUrl = form.find('input[name="inputUrl"]');
            eleInputMaxwidth = form.find('input[name="inputMaxwidth"]');
            eleInputMaxheight = form.find('input[name="inputMaxheight"]');
            eleEmbedHtml= form.find('input[name="embedHtml"]');
            eleError = form.find('input[name="error"]');
        }

        var
            onReadStart           = params.onReadStart,
            onReadEnd             = params.onReadEnd,
            currentUrlValue       = $(eleInputUrl).val(),
            currentMaxwidthValue  = $(eleInputMaxwidth).val(),
            currentMaxheightValue = $(eleInputMaxheight).val(),
            ajaxRefresh           = function()
            {
                //if real change
                if( currentUrlValue != $(eleInputUrl).val()
                    || currentMaxwidthValue != $(eleInputMaxwidth).val()
                    || currentMaxheightValue != $(eleInputMaxheight).val() )
                {
                    if ( Function.isFunction( onReadStart ) )
                    {
                        if( onReadStart() === false ){ return; }
                    }
                    js.core.ajaj( {
                        url: '/app/' + js.core.defaultLocale + '/embed/load?url='
                            + encodeURIComponent($(eleInputUrl).val())
                            + '&maxwidth='+$(eleInputMaxwidth).val()
                            + '&maxheight='+$(eleInputMaxheight).val(),
                        success: function(response)
                        {
                            var content = $(response.embedHtml);

                            //fixes flash
                            $(content.find('object param[name=wmode]'))
                                .attr('value','opaque');
                            $(content.find('embed[type="application/x-shockwave-flash"]'))
                                .attr('wmode','opaque');

                            $(eleEmbedHtml).val(content.prop('outerHTML'));
                            $(eleError).val(response.error)

                            if ( Function.isFunction( onReadEnd ) )
                            {
                                onReadEnd(response);
                            }
                        },
                        error: function()
                        {
                            if ( Function.isFunction( onReadEnd ) )
                            {
                                onReadEnd(false);
                            }
                        }
                    } );

                }
                currentUrlValue       = $(eleInputUrl).val();
                currentMaxwidthValue  = $(eleInputMaxwidth).val();
                currentMaxheightValue = $(eleInputMaxheight).val();
            }

        ;//var

        eleInputUrl.on('change paste',function(){setTimeout(ajaxRefresh,100)});
        eleInputMaxwidth.on('change paste',function(){setTimeout(ajaxRefresh,100)});
        eleInputMaxheight.on('change paste',function(){setTimeout(ajaxRefresh,100)});
    }

    global.Zork.prototype.embed = new global.Zork.Embed();

    /**
     * Form element type
     * inits url parser reader
     */
    global.Zork.Embed.prototype.inputUrl = function ( element )
    {
        element = $( element );

        //do not run if is a dashboard form
        if(element.prop('name') == 'paragraph-embed[inputUrl]'){ return; };

        var
            form = $(element.prop('form')),
            params = {},
            previewContainer = $('<div/>')
                               .css({
                                   "width": "120px",
                                   "height": "120px",
                                   "position": "absolute",
                                   "top": "15px",
                                   "right": "15px",
                                   "overflow": "hidden"
                               });
        ;//var

        form.css('position','relative').append(previewContainer);

        params.onReadStart = function()
        {
            $('input[type=submit][name=previous]').hide();
            $('input[type=submit][name=next]').hide();
            $('input[type=submit][name=finish]').hide();
        };
        params.onReadEnd = function(response)
        {
            if( response.error )
            {
                previewContainer.html( response.error );
            }
            else
            {
                previewContainer.html( response.previewHtml );
            }
            $('input[type=submit][name=previous]').show();
            $('input[type=submit][name=next]').show();
            $('input[type=submit][name=finish]').show();
        }

        js.embed.initReader(form,false,params);

    };

    global.Zork.Embed.prototype.inputUrl.isElementConstructor = true;

} ( window, jQuery, zork ) );
