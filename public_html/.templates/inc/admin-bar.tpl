{literal}
    <style>.columnis-draft-bar + .header .top{
            top:38px
        }
        @media (min-width:980px){
            .columnis-draft-bar + .header{
                top:38px
            }
            .columnis-draft-bar + .header .top{
                top:47%;
            }
        }.columnis-draft-bar, .columnis-draft-bar__holder{display:block;width:100%;height:38px}.columnis-draft-bar__holder{padding:0 60px 0 15px;position:fixed;left:0;top:0;z-index:999;background-color:#e78037;box-shadow:0 2px 0 0 #fff;color:#fff;font-family:sans-serif;font-size:14px;font-weight:700;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}.columnis-draft-bar__holder:before{content:"";display:inline-block;vertical-align:middle;height:100%}.columnis-draft-bar__text{display:inline-block;vertical-align:middle}.columnis-draft-bar__link{position:absolute;right:15px;top:50%;color:#fff;font-size:13px;padding:5px 10px;background-color:#000;border-radius:6px;-webkit-transform:translateY(-50%);-ms-transform:translateY(-50%);-o-transform:translateY(-50%);transform:translateY(-50%)}.columnis-draft-bar.dark .columnis-draft-bar__holder{background-color:#000}.columnis-draft-bar.dark .columnis-draft-bar__link{background-color:#e78037}</style>
    {/literal}
    <div class="columnis-draft-bar dark"><!--
                --><div class="columnis-draft-bar__holder">
            <span class="columnis-draft-bar__text">Modo borrador Activo</span>
            <a href="{$account.url}?logoutAdmin=1" class="columnis-draft-bar__link">Salir</a>
        </div>
    </div>