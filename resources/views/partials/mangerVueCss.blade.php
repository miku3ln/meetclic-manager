<?php
$url_path_plugins = "libs/";
?>


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


    .switch-button {
        margin: 10px 0;
    }

    .switch-button-control .switch-button.enabled {
        background-color: var(--color);
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
        transform: translateX(calc(calc(1.6em - (2 * 2px)) + (2 * 2px)));
    }

    .switch-button-control .switch-button .button {
        height: calc(1.6em - (2 * 2px));
        width: calc(1.6em - (2 * 2px));
        border: 2px solid var(--color);
        border-radius: calc(1.6em - (2 * 2px));
        background: var(--color);
        transition: all 0.3s ease-in-out;
    }

    .floating-panel-manager__search {
        width: 580px;
    }

    .content-manager-customer-search {
        position: relative;
    }

    .floating-panel-manager__search--customer-search {
        width: 97%;
        position: absolute;
        top: -3%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto', 'sans-serif';
        line-height: 30px;
        padding-left: 10px;
    }

    .floating-panel-manager__search--customer-search input {
        width: 100%;
    }

    .floating-panel-manager__elements.element-1 {
        text-align: left;

    }

    .floating-panel-manager__elements {
        text-align: left;
        margin-bottom: 1%;
    }

    .map-guests--customer-search {
        margin-top: 8%;
    }

    .floating-panel-manager__elements h1 {
        font-size: 17px;
    }

    .content-information__description {
        display: flex;
    }

    .content-information__description-title {
        font-weight: 600;
    }

    .floating-panel-manager-manager-routes {
        /*        position: absolute;
                width: 30%;
                top: 13%;
                left: 2%;
                z-index: 5;
                background-color: #fff;
                padding: 5px;
                border: 1px solid #999;
                text-align: center;
                font-family: 'Roboto', 'sans-serif';
                line-height: 30px;
                padding-left: 10px;*/
    }

    .floating-panel-manager-manager-routes .floating-panel-manager__search {
        width: 100% !important;

    }
</style>
