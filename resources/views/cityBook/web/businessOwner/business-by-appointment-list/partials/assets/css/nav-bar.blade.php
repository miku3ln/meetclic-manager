<style id="navbar">
    /* =====================================
   NAVBAR APP
===================================== */

    .navbar-app {

        height: 70px;

        background: #4C4CFF;

        padding: 0 1rem;

        box-shadow: 0 4px 18px rgba(0, 0, 0, .12);


        position: fixed;

        top: 0;

        left: 0;

        width: 100%;


        z-index: 1030;

    }


    /* =====================================
       TOGGLE MOBILE
    ===================================== */

    .navbar-app__toggle {

        display: none;

        border: 0;

        background: transparent;

        color: white;

        font-size: 22px;

        width: 42px;

        height: 42px;

        border-radius: 12px;

        align-items: center;

        justify-content: center;

    }


    .navbar-app__toggle:hover {

        background: rgba(255, 255, 255, .15);

    }


    /* =====================================
       BRAND
    ===================================== */


    .navbar-app__brand {

        display: flex;

        align-items: center;

        gap: 12px;

        text-decoration: none;

        color: white;

        flex-shrink: 0;

    }


    .navbar-app__logo {


        width: 42px;

        height: 42px;


        display: flex;

        align-items: center;

        justify-content: center;


        background: white;


        color: #4C4CFF;


        border-radius: 12px;


        font-size: 20px;


    }


    .navbar-app__title {


        display: flex;

        flex-direction: column;


        line-height: 1.1;


    }


    .navbar-app__title span {


        font-size: 17px;

        font-weight: 700;


    }


    .navbar-app__title small {


        font-size: 11px;

        opacity: .75;


    }


    /* =====================================
       MENU DESKTOP
    ===================================== */


    .navbar-app__menu-wrapper {


        display: flex;

        align-items: center;

        margin-left: 30px;


    }


    .navbar-app__menu {


        list-style: none;

        display: flex;

        align-items: center;

        gap: 6px;

        padding: 0;

        margin: 0;


    }


    .navbar-app__item {


        display: flex;

    }


    .navbar-app__link {


        display: flex;


        align-items: center;


        gap: 9px;


        padding: 10px 15px;


        border-radius: 12px;


        color: white;


        text-decoration: none;


        cursor: pointer;


        font-size: 14px;


        transition: .2s ease;


    }


    .navbar-app__link i {


        font-size: 16px;

    }


    .navbar-app__link:hover {


        background: rgba(255, 255, 255, .15);

        color: white;

    }


    .navbar-app__link.active {


        background: rgba(255, 255, 255, .20);

    }


    /* =====================================
       ACTIONS RIGHT
    ===================================== */


    .navbar-app__actions {


        display: flex;


        align-items: center;


        gap: 15px;


    }


    .navbar-app__notification {


        position: relative;


        width: 42px;


        height: 42px;


        border: none;


        background: transparent;


        color: white;


        font-size: 19px;


        border-radius: 12px;


        display: flex;


        justify-content: center;


        align-items: center;


        cursor: pointer;


    }


    .navbar-app__notification:hover {


        background: rgba(255, 255, 255, .15);


    }


    .navbar-app__badge {


        position: absolute;


        top: 2px;


        right: 2px;


        width: 18px;


        height: 18px;


        border-radius: 50%;


        background: #FFCC00;


        color: #222;


        font-size: 10px;


        font-weight: 700;


        display: flex;


        align-items: center;


        justify-content: center;


    }


    /* =====================================
       USER
    ===================================== */


    .navbar-app__user {


        border: none;


        background: transparent;


        color: white;


        display: flex;


        align-items: center;


        gap: 10px;


        padding: 6px 10px;


        border-radius: 12px;


        cursor: pointer;


    }


    .navbar-app__user:hover {


        background: rgba(255, 255, 255, .15);


    }


    .navbar-app__user img {


        width: 42px;


        height: 42px;


        border-radius: 50%;


        object-fit: cover;


    }


    .navbar-app__user div {


        display: flex;


        flex-direction: column;


        text-align: left;


        line-height: 1.1;


    }


    .navbar-app__user span {


        font-size: 14px;


        font-weight: 600;


    }


    .navbar-app__user small {


        font-size: 11px;


        opacity: .75;


    }


    .navbar-app__user i {


        font-size: 12px;


    }


    /* =====================================
       RESPONSIVE TABLET
    ===================================== */


    @media (max-width: 1100px) {


        .navbar-app__link span {


            display: none;


        }


        .navbar-app__link {


            padding: 10px;


        }


    }


    /* =====================================
       MOBILE
    ===================================== */


    @media (max-width: 768px) {


        .navbar-app {


            height: 60px;

            padding: 0 .75rem;


        }


        .navbar-app__toggle {


            display: flex;


        }


        .navbar-app__brand {


            margin-left: 8px;


        }


        .navbar-app__logo {


            width: 38px;

            height: 38px;


        }


        .navbar-app__title span {


            font-size: 15px;


        }


        .navbar-app__title small {


            display: none;


        }


        .navbar-app__menu-wrapper {


            display: none;


        }


        .navbar-app__actions {


            margin-left: auto;


        }


        .navbar-app__user {


            padding: 0;


        }


        .navbar-app__user div,
        .navbar-app__user i {


            display: none;


        }


        .navbar-app__user img {


            width: 38px;

            height: 38px;


        }


    }

    /* =====================================
       MOBILE MENU
    ===================================== */


    .navbar-mobile {


        position:fixed;


        top:60px;

        left:0;

        width:100%;


        z-index:1029;



        background: white;


        box-shadow: 0 10px 25px rgba(0, 0, 0, .15);


        transform: translateY(-120%);


        opacity: 0;


        transition: .3s ease;


        z-index: 1029;


    }


    .navbar-mobile.active {


        transform: translateY(0);


        opacity: 1;


    }
    /* =====================================
       ACTIVE PARENT MENU
    ===================================== */


    .navbar-app__link.active-parent {


        background:rgba(255,255,255,.25);


        color:white;


    }



    .navbar-app__link.active-parent i:first-child {


        color:#FFCC00;


    }



    .navbar-app__link.active-parent
    .fa-chevron-down {


        transform:rotate(180deg);


    }

    .navbar-mobile__menu {


        list-style: none;

        padding: 15px;

        margin: 0;


    }


    .navbar-mobile__item {


        margin-bottom: 8px;


    }


    .navbar-mobile__link {


        display: flex;


        align-items: center;


        gap: 12px;


        padding: 14px;


        border-radius: 12px;


        color: #2C2C2C;


        text-decoration: none;


        cursor: pointer;


    }


    .navbar-mobile__link:hover {


        background: #f2f2ff;


        color: #4C4CFF;


    }

    /* =====================================
       DESKTOP SUBMENU
    ===================================== */


    .navbar-app__item {

        position: relative;

    }


    /* submenu oculto */

    .navbar-app__submenu {


        position: absolute;

        top: calc(100% + 10px);

        left: 0;


        min-width: 220px;


        list-style: none;

        margin: 0;

        padding: 10px;


        background: white;


        border-radius: 14px;


        box-shadow: 0 10px 30px rgba(0, 0, 0, .15);


        opacity: 0;


        visibility: hidden;


        transform: translateY(10px);


        transition: .25s ease;


        z-index: 1050;


    }


    /* mostrar submenu */


    .navbar-app__item:hover
    .navbar-app__submenu {


        opacity: 1;


        visibility: visible;


        transform: translateY(0);


    }


    /* items submenu */


    .navbar-app__subitem {


        width: 100%;


    }


    .navbar-app__sublink {


        display: flex;


        align-items: center;


        padding: 12px 14px;


        border-radius: 10px;


        color: #2C2C2C;


        text-decoration: none;


        font-size: 14px;


        transition: .2s ease;


    }


    .navbar-app__sublink:hover {


        background: #f1f1ff;


        color: #4C4CFF;


    }


    .navbar-app__sublink.active {


        background: #4C4CFF;


        color: white;


    }


    /* =====================================
       PADRE CON SUBMENU
    ===================================== */


    .navbar-app__link--dropdown {


        cursor: pointer;


    }


    .navbar-app__link--dropdown i:last-child {


        font-size: 11px;


        margin-left: 4px;


    }


    /* =====================================
       MOBILE SUBMENU
    ===================================== */


    .navbar-mobile__title {


        display: flex;


        align-items: center;


        gap: 10px;


        font-weight: 700;


        color: #4C4CFF;


        padding: 12px;


    }


    .navbar-mobile__title i {


        width: 20px;


    }


    .navbar-mobile__link {


        padding-left: 45px !important;


    }


    .navbar-mobile__link.active {


        background: #4C4CFF;


        color: white;


    }


    @media (min-width: 769px) {


        .navbar-mobile {

            display: none;

        }


    }

    .layout-content {

        padding-top:70px;

    }
    .navbar-app {

        height:60px;

    }
    @media(max-width:768px){

        .navbar-app{

            height:60px;

        }


        .layout-content{

            padding-top:60px;

        }

    }
</style>
