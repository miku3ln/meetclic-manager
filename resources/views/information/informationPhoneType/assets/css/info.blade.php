<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
<?php
$url_path_plugins = "metronic/plugins/";
?>
{{-----BOOTGRID PLUGIN--}}
<link href="{{ asset($resourcePathServer.$url_path_plugins."bootgrid/css/jquery.bootgrid.css") }}" rel="stylesheet"
      type="text/css">
<style>
    .switch-button {
        margin: 10px 0;
    }

    .switch-button-control .switch-button.enabled {
        background-color:var(--color);
        box-shadow: none;
    }

    .switch-button-control .switch-button {
        height: 1.6em;
        width: calc(1.6em * 2);
        border: 2px solid var(--color);
        box-shadow: inset 0px 0px 2px 0px rgba(0, 0, 0, 0.33);
        border-radius: 1.6em;
        transition: all 0.3s ease-in-out;
        cursor: pointer;
    }
    .switch-button-control .switch-button.enabled .button {
        background: white;
        transform: translateX(calc(calc( 1.6em - (2 * 2px) ) + (2 *2px)));
    }
    .switch-button-control .switch-button .button {
        height: calc( 1.6em - (2 * 2px) );
        width: calc( 1.6em - (2 * 2px) );
        border: 2px solid var(--color);
        border-radius: calc( 1.6em - (2 * 2px) );
        background:var(--color);
        transition: all 0.3s ease-in-out;
    }
</style>

