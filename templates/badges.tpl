{**
 * plugins/generic/badges/templates/articleFooter.tpl
 *
 * Copyright 2019 
 * Portal de Revistas de la Universidad Nacional de La Plata
 *  https://revistas.unlp.edu.ar 
 *  https://sedici.unlp.edu.ar
 *
 * @author gonetil
 *}
<link rel="stylesheet" type="text/css" href="/plugins/generic/badges/styles/badges.css">
<div class="item badges">
        <h2 class="label">{translate key="plugins.generic.hera.manager.settings.showBlockTitle"}</h2>
        {if $doi}

            {if $showHeraArticle} 
                <div class="sub_item">
                    <script type='text/javascript' src='https://hera.sedici.unlp.edu.ar/conector/built.min.js'></script>
                    <span class="HeraConnector" doi="{$doi}" data-style="small_circle"></span>
                </div>
            {/if}
            
        {/if}
        
</div>

