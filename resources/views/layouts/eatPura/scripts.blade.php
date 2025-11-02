<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$woocomerceAllow = false;

?>

@yield('script-bootgrid-init')
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-includes/js/jquery/jquery.js"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-includes/js/jquery/jquery-migrate.min.js"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/miniorange-login-openid/includes/js/jquery.cookie.min.js"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/miniorange-login-openid/includes/js/social_login.js"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/themes/citybook/assets/js/Scrollax.js"></script>
<script type="text/javascript">
    window._wpemojiSettings = {
        "baseUrl": "https:\/\/s.w.org\/images\/core\/emoji\/12.0.0-1\/72x72\/",
        "ext": ".png",
        "svgUrl": "https:\/\/s.w.org\/images\/core\/emoji\/12.0.0-1\/svg\/",
        "svgExt": ".svg",
        "source": {"concatemoji": "http:\/\/citybook.meetclic.com\/wp-includes\/js\/wp-emoji-release.min.js"}
    };
    /*! This file is auto-generated */
    !function (e, a, t) {
        var r, n, o, i, p = a.createElement("canvas"), s = p.getContext && p.getContext("2d");

        function c(e, t) {
            var a = String.fromCharCode;
            s.clearRect(0, 0, p.width, p.height), s.fillText(a.apply(this, e), 0, 0);
            var r = p.toDataURL();
            return s.clearRect(0, 0, p.width, p.height), s.fillText(a.apply(this, t), 0, 0), r === p.toDataURL()
        }

        function l(e) {
            if (!s || !s.fillText) return !1;
            switch (s.textBaseline = "top", s.font = "600 32px Arial", e) {
                case"flag":
                    return !c([127987, 65039, 8205, 9895, 65039], [127987, 65039, 8203, 9895, 65039]) && (!c([55356, 56826, 55356, 56819], [55356, 56826, 8203, 55356, 56819]) && !c([55356, 57332, 56128, 56423, 56128, 56418, 56128, 56421, 56128, 56430, 56128, 56423, 56128, 56447], [55356, 57332, 8203, 56128, 56423, 8203, 56128, 56418, 8203, 56128, 56421, 8203, 56128, 56430, 8203, 56128, 56423, 8203, 56128, 56447]));
                case"emoji":
                    return !c([55357, 56424, 55356, 57342, 8205, 55358, 56605, 8205, 55357, 56424, 55356, 57340], [55357, 56424, 55356, 57342, 8203, 55358, 56605, 8203, 55357, 56424, 55356, 57340])
            }
            return !1
        }

        function d(e) {
            var t = a.createElement("script");
            t.src = e, t.defer = t.type = "text/javascript", a.getElementsByTagName("head")[0].appendChild(t)
        }

        for (i = Array("flag", "emoji"), t.supports = {
            everything: !0,
            everythingExceptFlag: !0
        }, o = 0; o < i.length; o++) t.supports[i[o]] = l(i[o]), t.supports.everything = t.supports.everything && t.supports[i[o]], "flag" !== i[o] && (t.supports.everythingExceptFlag = t.supports.everythingExceptFlag && t.supports[i[o]]);
        t.supports.everythingExceptFlag = t.supports.everythingExceptFlag && !t.supports.flag, t.DOMReady = !1, t.readyCallback = function () {
            t.DOMReady = !0
        }, t.supports.everything || (n = function () {
            t.readyCallback()
        }, a.addEventListener ? (a.addEventListener("DOMContentLoaded", n, !1), e.addEventListener("load", n, !1)) : (e.attachEvent("onload", n), a.attachEvent("onreadystatechange", function () {
            "complete" === a.readyState && t.readyCallback()
        })), (r = t.source || {}).concatemoji ? d(r.concatemoji) : r.wpemoji && r.twemoji && (d(r.twemoji), d(r.wpemoji)))
    }(window, document, window._wpemojiSettings);
</script>
<script src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-includes/js/wp-emoji-release.min.js')}}"
        type="text/javascript"
        defer="">

</script>


<script
    src="https://maps.google.com/maps/api/js?key={{env('APP_GOOGLE_MAPS_KEY')}}&{{env('APP_GOOGLE_MAPS_BOOKSTORE')}}"></script>
<script type="text/javascript" charset="UTF-8"
        src="https://maps.googleapis.com/maps-api-v3/api/js/40/10/intl/es_ALL/common.js"></script>
<script type="text/javascript" charset="UTF-8"
        src="https://maps.googleapis.com/maps-api-v3/api/js/40/10/intl/es_ALL/util.js"></script>
<script type="text/javascript" charset="UTF-8"
        src="https://maps.googleapis.com/maps-api-v3/api/js/40/10/intl/es_ALL/controls.js"></script>
<script type="text/javascript" charset="UTF-8"
        src="https://maps.googleapis.com/maps-api-v3/api/js/40/10/intl/es_ALL/places_impl.js"></script>

@if( isset($dataManagerPage['currentPage'])&& $dataManagerPage['currentPage']=='search' )

    <script type="text/javascript" charset="UTF-8"
            src="https://maps.googleapis.com/maps-api-v3/api/js/40/10/map.js"></script>
    <script type="text/javascript" charset="UTF-8"
            src="https://maps.googleapis.com/maps-api-v3/api/js/40/10/marker.js"></script>
    <script type="text/javascript" charset="UTF-8"
            src="https://maps.googleapis.com/maps-api-v3/api/js/40/10/overlay.js"></script>
    <script type="text/javascript" charset="UTF-8"
            src="https://maps.googleapis.com/maps-api-v3/api/js/40/10/stats.js"></script>
    <script type="text/javascript" charset="UTF-8"
            src="https://maps.googleapis.com/maps-api-v3/api/js/40/10/onion.js"></script>
    <script type="text/javascript"
            src="http://citybook.meetclic.com/wp-includes/js/hoverintent-js.min.js?ver=2.2.1"></script>
    <script type="text/javascript" src="http://citybook.meetclic.com/wp-includes/js/admin-bar.min.js?ver=5.4"></script>
@endif
<!--ajax-modal-container end -->
<script type="text/javascript"
        src="{{URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/citybook-add-ons/assets/js/plugins.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/citybook-add-ons/assets/js/moment.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/citybook-add-ons/assets/js/select2.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/citybook-add-ons/assets/js/jquery.mousewheel.js')}}"></script>

<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/citybook-add-ons/assets/js/infobox.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/citybook-add-ons/assets/js/markerclusterer.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/citybook-add-ons/assets/js/oms.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-includes/js/dist/vendor/wp-polyfill.min.js')}}"></script>

@if(false)
    <script type="text/javascript">
        var currentPathTemplate = '{{URL::asset($resourcePathServer.'templates/citybook/')}}';

        ('fetch' in window) || document.write('<script src="' + currentPathTemplate + 'wp-includes/js/dist/vendor/wp-polyfill-fetch.min.js"></scr' + 'ipt>');
        (document.contains) || document.write('<script src="' + currentPathTemplate + 'wp-includes/js/dist/vendor/wp-polyfill-node-contains.min.js"></scr' + 'ipt>');
        (window.DOMRect) || document.write('<script src="' + currentPathTemplate + 'wp-includes/js/dist/vendor/wp-polyfill-dom-rect.min.js"></scr' + 'ipt>');
        (window.URL && window.URL.prototype && window.URLSearchParams) || document.write('<script src="' + currentPathTemplate + 'wp-includes/js/dist/vendor/wp-polyfill-url.min.js"></scr' + 'ipt>');
        (window.FormData && window.FormData.prototype.keys) || document.write('<script src="' + currentPathTemplate + 'wp-includes/js/dist/vendor/wp-polyfill-formdata.min.js"></scr' + 'ipt>');
        (Element.prototype.matches && Element.prototype.closest) || document.write('<script src="' + currentPathTemplate + 'wp-includes/js/dist/vendor/wp-polyfill-element-closest.min.js"></scr' + 'ipt>');
    </script>

@endif
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-includes/js/dist/i18n.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-includes/js/underscore.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-includes/js/imagesloaded.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-includes/js/masonry.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-includes/js/jquery/ui/core.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-includes/js/jquery/ui/widget.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-includes/js/jquery/ui/mouse.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-includes/js/jquery/ui/sortable.min.js')}}"></script>
<script type="text/javascript">
    /* <![CDATA[ */
    var _citybook_add_ons = {
        "url": "http:\/\/citybook.meetclic.com\/wp-admin\/admin-ajax.php",
        "nonce": "cf46735336",
        "posted_on": "Posted on ",
        "reply": "Reply",
        "retweet": "Retweet",
        "favorite": "Favorite",
        "pl_w": "Please wait...",
        "like": "Like",
        "unlike": "Unlike",
        "marker": "http:\/\/citybook.meetclic.com\/wp-content\/plugins\/citybook-add-ons\/assets\/images\/marker.png",
        "center_lat": "40.7",
        "center_lng": "-73.87",
        "map_zoom": "10",
        "socials": {
            "facebook": "Facebook",
            "twitter": "Twitter",
            "youtube": "Youtube",
            "vimeo": "Vimeo",
            "instagram": "Instagram",
            "vk": "Vkontakte",
            "reddit": "Reddit",
            "pinterest": "Pinterest",
            "vine": "Vine Camera",
            "tumblr": "Tumblr",
            "flickr": "Flickr",
            "google-plus-g": "Google+",
            "linkedin": "LinkedIn",
            "whatsapp": "Whatsapp",
            "meetup": "Meetup",
            "custom_icon": "Custom"
        },
        "gmap_type": "ROADMAP",
        "login_delay": "5000",
        "files": {
            "category": [{"id": 36, "name": "Cars", "level": 0}, {
                "id": 47,
                "name": "Events",
                "level": 0
            }, {"id": 48, "name": "Fitness", "level": 0}, {"id": 60, "name": "Hotels", "level": 0}, {
                "id": 81,
                "name": "Restaurants",
                "level": 0
            }, {"id": 89, "name": "Shops", "level": 0}],
            "location": [{"value": 106, "label": "Albany"}, {"value": 107, "label": "Astoria"}, {
                "value": 108,
                "label": "Bronx"
            }, {"value": 109, "label": "Brooklyn"}, {"value": 110, "label": "Manhattan"}, {
                "value": 111,
                "label": "Melville"
            }, {"value": 112, "label": "New Jersey"}, {"value": 113, "label": "New York"}, {
                "value": 114,
                "label": "Passaic"
            }, {"value": 115, "label": "Ridgewood"}, {"value": 98, "label": "United States"}]
        },
        "features": [{"name": "Accepts Credit Cards", "id": 24}, {"name": "Accessories", "id": 25}, {
            "name": "Alcohol",
            "id": 30
        }, {"name": "Bike Parking", "id": 33}, {"name": "Electronics", "id": 44}, {
            "name": "Elevator in building",
            "id": 45
        }, {"name": "Friendly workspace", "id": 52}, {"name": "Good for Kids", "id": 53}, {
            "name": "Instant Book",
            "id": 62
        }, {"name": "Men Clothing", "id": 71}, {"name": "Parking street", "id": 76}, {
            "name": "Reservations",
            "id": 79
        }, {"name": "Smoking Allowed", "id": 91}, {"name": "Sporting Goods", "id": 94}, {
            "name": "Wheelchair Accesible",
            "id": 99
        }, {"name": "Wireless Internet", "id": 101}, {"name": "Women Clothing", "id": 103}],
        "listing_type_opts": [],
        "chatbox_message": "",
        "submit_timezone_hide": "no",
        "working_days": {
            "Monday": "Monday",
            "Tuesday": "Tuesday",
            "Wednesday": "Wednesday",
            "Thursday": "Thursday",
            "Friday": "Friday",
            "Saturday": "Saturday",
            "Sunday": "Sunday"
        },
        "working_hours": {
            "0:00": "00:00",
            "0:30": "00:30",
            "1:00": "01:00",
            "1:30": "01:30",
            "2:00": "02:00",
            "2:30": "02:30",
            "3:00": "03:00",
            "3:30": "03:30",
            "4:00": "04:00",
            "4:30": "04:30",
            "5:00": "05:00",
            "5:30": "05:30",
            "6:00": "06:00",
            "6:30": "06:30",
            "7:00": "07:00",
            "7:30": "07:30",
            "8:00": "08:00",
            "8:30": "08:30",
            "9:00": "09:00",
            "9:30": "09:30",
            "10:00": "10:00",
            "10:30": "10:30",
            "11:00": "11:00",
            "11:30": "11:30",
            "12:00": "12:00",
            "12:30": "12:30",
            "13:00": "13:00",
            "13:30": "13:30",
            "14:00": "14:00",
            "14:30": "14:30",
            "15:00": "15:00",
            "15:30": "15:30",
            "16:00": "16:00",
            "16:30": "16:30",
            "17:00": "17:00",
            "17:30": "17:30",
            "18:00": "18:00",
            "18:30": "18:30",
            "19:00": "19:00",
            "19:30": "19:30",
            "20:00": "20:00",
            "20:30": "20:30",
            "21:00": "21:00",
            "21:30": "21:30",
            "22:00": "22:00",
            "22:30": "22:30",
            "23:00": "23:00",
            "23:30": "23:30",
            "24:00": "24:00"
        },
        "timezones": {
            "Pacific\/Pago_Pago": "(UTC-11:00) Pacific\/Pago_Pago",
            "Pacific\/Midway": "(UTC-11:00) Pacific\/Midway",
            "Pacific\/Niue": "(UTC-11:00) Pacific\/Niue",
            "Pacific\/Honolulu": "(UTC-10:00) Pacific\/Honolulu",
            "Pacific\/Tahiti": "(UTC-10:00) Pacific\/Tahiti",
            "Pacific\/Rarotonga": "(UTC-10:00) Pacific\/Rarotonga",
            "Pacific\/Marquesas": "(UTC-09:30) Pacific\/Marquesas",
            "America\/Adak": "(UTC-09:00) America\/Adak",
            "Pacific\/Gambier": "(UTC-09:00) Pacific\/Gambier",
            "America\/Anchorage": "(UTC-08:00) America\/Anchorage",
            "America\/Nome": "(UTC-08:00) America\/Nome",
            "America\/Sitka": "(UTC-08:00) America\/Sitka",
            "America\/Yakutat": "(UTC-08:00) America\/Yakutat",
            "America\/Metlakatla": "(UTC-08:00) America\/Metlakatla",
            "America\/Juneau": "(UTC-08:00) America\/Juneau",
            "Pacific\/Pitcairn": "(UTC-08:00) Pacific\/Pitcairn",
            "America\/Phoenix": "(UTC-07:00) America\/Phoenix",
            "America\/Creston": "(UTC-07:00) America\/Creston",
            "America\/Dawson": "(UTC-07:00) America\/Dawson",
            "America\/Los_Angeles": "(UTC-07:00) America\/Los_Angeles",
            "America\/Dawson_Creek": "(UTC-07:00) America\/Dawson_Creek",
            "America\/Whitehorse": "(UTC-07:00) America\/Whitehorse",
            "America\/Hermosillo": "(UTC-07:00) America\/Hermosillo",
            "America\/Fort_Nelson": "(UTC-07:00) America\/Fort_Nelson",
            "America\/Tijuana": "(UTC-07:00) America\/Tijuana",
            "America\/Vancouver": "(UTC-07:00) America\/Vancouver",
            "America\/Chihuahua": "(UTC-06:00) America\/Chihuahua",
            "America\/Cambridge_Bay": "(UTC-06:00) America\/Cambridge_Bay",
            "America\/Boise": "(UTC-06:00) America\/Boise",
            "America\/Denver": "(UTC-06:00) America\/Denver",
            "America\/El_Salvador": "(UTC-06:00) America\/El_Salvador",
            "America\/Costa_Rica": "(UTC-06:00) America\/Costa_Rica",
            "America\/Mazatlan": "(UTC-06:00) America\/Mazatlan",
            "America\/Ojinaga": "(UTC-06:00) America\/Ojinaga",
            "America\/Guatemala": "(UTC-06:00) America\/Guatemala",
            "America\/Edmonton": "(UTC-06:00) America\/Edmonton",
            "America\/Inuvik": "(UTC-06:00) America\/Inuvik",
            "America\/Belize": "(UTC-06:00) America\/Belize",
            "America\/Managua": "(UTC-06:00) America\/Managua",
            "America\/Regina": "(UTC-06:00) America\/Regina",
            "America\/Tegucigalpa": "(UTC-06:00) America\/Tegucigalpa",
            "Pacific\/Easter": "(UTC-06:00) Pacific\/Easter",
            "Pacific\/Galapagos": "(UTC-06:00) Pacific\/Galapagos",
            "America\/Yellowknife": "(UTC-06:00) America\/Yellowknife",
            "America\/Swift_Current": "(UTC-06:00) America\/Swift_Current",
            "America\/Monterrey": "(UTC-05:00) America\/Monterrey",
            "America\/Bahia_Banderas": "(UTC-05:00) America\/Bahia_Banderas",
            "America\/Bogota": "(UTC-05:00) America\/Bogota",
            "America\/Cancun": "(UTC-05:00) America\/Cancun",
            "America\/Merida": "(UTC-05:00) America\/Merida",
            "America\/Chicago": "(UTC-05:00) America\/Chicago",
            "America\/Winnipeg": "(UTC-05:00) America\/Winnipeg",
            "America\/Menominee": "(UTC-05:00) America\/Menominee",
            "America\/Eirunepe": "(UTC-05:00) America\/Eirunepe",
            "America\/Atikokan": "(UTC-05:00) America\/Atikokan",
            "America\/Matamoros": "(UTC-05:00) America\/Matamoros",
            "America\/Guayaquil": "(UTC-05:00) America\/Guayaquil",
            "America\/Indiana\/Knox": "(UTC-05:00) America\/Indiana\/Knox",
            "America\/Indiana\/Tell_City": "(UTC-05:00) America\/Indiana\/Tell_City",
            "America\/Jamaica": "(UTC-05:00) America\/Jamaica",
            "America\/Lima": "(UTC-05:00) America\/Lima",
            "America\/Mexico_City": "(UTC-05:00) America\/Mexico_City",
            "America\/Cayman": "(UTC-05:00) America\/Cayman",
            "America\/Rainy_River": "(UTC-05:00) America\/Rainy_River",
            "America\/Rankin_Inlet": "(UTC-05:00) America\/Rankin_Inlet",
            "America\/Rio_Branco": "(UTC-05:00) America\/Rio_Branco",
            "America\/North_Dakota\/Center": "(UTC-05:00) America\/North_Dakota\/Center",
            "America\/Panama": "(UTC-05:00) America\/Panama",
            "America\/Resolute": "(UTC-05:00) America\/Resolute",
            "America\/North_Dakota\/New_Salem": "(UTC-05:00) America\/North_Dakota\/New_Salem",
            "America\/North_Dakota\/Beulah": "(UTC-05:00) America\/North_Dakota\/Beulah",
            "America\/New_York": "(UTC-04:00) America\/New_York",
            "America\/Puerto_Rico": "(UTC-04:00) America\/Puerto_Rico",
            "America\/Porto_Velho": "(UTC-04:00) America\/Porto_Velho",
            "America\/Grand_Turk": "(UTC-04:00) America\/Grand_Turk",
            "America\/Guadeloupe": "(UTC-04:00) America\/Guadeloupe",
            "America\/Grenada": "(UTC-04:00) America\/Grenada",
            "America\/Marigot": "(UTC-04:00) America\/Marigot",
            "America\/Martinique": "(UTC-04:00) America\/Martinique",
            "America\/Port_of_Spain": "(UTC-04:00) America\/Port_of_Spain",
            "America\/Port-au-Prince": "(UTC-04:00) America\/Port-au-Prince",
            "America\/Guyana": "(UTC-04:00) America\/Guyana",
            "America\/Indiana\/Indianapolis": "(UTC-04:00) America\/Indiana\/Indianapolis",
            "America\/Manaus": "(UTC-04:00) America\/Manaus",
            "America\/Havana": "(UTC-04:00) America\/Havana",
            "America\/Tortola": "(UTC-04:00) America\/Tortola",
            "America\/Indiana\/Marengo": "(UTC-04:00) America\/Indiana\/Marengo",
            "America\/Indiana\/Petersburg": "(UTC-04:00) America\/Indiana\/Petersburg",
            "America\/Indiana\/Vevay": "(UTC-04:00) America\/Indiana\/Vevay",
            "America\/Indiana\/Vincennes": "(UTC-04:00) America\/Indiana\/Vincennes",
            "America\/Indiana\/Winamac": "(UTC-04:00) America\/Indiana\/Winamac",
            "America\/Iqaluit": "(UTC-04:00) America\/Iqaluit",
            "America\/Kentucky\/Louisville": "(UTC-04:00) America\/Kentucky\/Louisville",
            "America\/Kentucky\/Monticello": "(UTC-04:00) America\/Kentucky\/Monticello",
            "America\/Kralendijk": "(UTC-04:00) America\/Kralendijk",
            "America\/La_Paz": "(UTC-04:00) America\/La_Paz",
            "America\/Pangnirtung": "(UTC-04:00) America\/Pangnirtung",
            "America\/Dominica": "(UTC-04:00) America\/Dominica",
            "America\/Nassau": "(UTC-04:00) America\/Nassau",
            "America\/Campo_Grande": "(UTC-04:00) America\/Campo_Grande",
            "America\/Montserrat": "(UTC-04:00) America\/Montserrat",
            "America\/Lower_Princes": "(UTC-04:00) America\/Lower_Princes",
            "America\/Aruba": "(UTC-04:00) America\/Aruba",
            "America\/Asuncion": "(UTC-04:00) America\/Asuncion",
            "America\/Nipigon": "(UTC-04:00) America\/Nipigon",
            "America\/Barbados": "(UTC-04:00) America\/Barbados",
            "America\/St_Barthelemy": "(UTC-04:00) America\/St_Barthelemy",
            "America\/St_Kitts": "(UTC-04:00) America\/St_Kitts",
            "America\/Blanc-Sablon": "(UTC-04:00) America\/Blanc-Sablon",
            "America\/Boa_Vista": "(UTC-04:00) America\/Boa_Vista",
            "America\/Detroit": "(UTC-04:00) America\/Detroit",
            "America\/St_Thomas": "(UTC-04:00) America\/St_Thomas",
            "America\/St_Lucia": "(UTC-04:00) America\/St_Lucia",
            "America\/Caracas": "(UTC-04:00) America\/Caracas",
            "America\/Thunder_Bay": "(UTC-04:00) America\/Thunder_Bay",
            "America\/Toronto": "(UTC-04:00) America\/Toronto",
            "America\/Antigua": "(UTC-04:00) America\/Antigua",
            "America\/St_Vincent": "(UTC-04:00) America\/St_Vincent",
            "America\/Anguilla": "(UTC-04:00) America\/Anguilla",
            "America\/Santiago": "(UTC-04:00) America\/Santiago",
            "America\/Cuiaba": "(UTC-04:00) America\/Cuiaba",
            "America\/Curacao": "(UTC-04:00) America\/Curacao",
            "America\/Santo_Domingo": "(UTC-04:00) America\/Santo_Domingo",
            "America\/Montevideo": "(UTC-03:00) America\/Montevideo",
            "America\/Paramaribo": "(UTC-03:00) America\/Paramaribo",
            "America\/Moncton": "(UTC-03:00) America\/Moncton",
            "America\/Sao_Paulo": "(UTC-03:00) America\/Sao_Paulo",
            "Atlantic\/Stanley": "(UTC-03:00) Atlantic\/Stanley",
            "America\/Thule": "(UTC-03:00) America\/Thule",
            "America\/Santarem": "(UTC-03:00) America\/Santarem",
            "Antarctica\/Rothera": "(UTC-03:00) Antarctica\/Rothera",
            "America\/Punta_Arenas": "(UTC-03:00) America\/Punta_Arenas",
            "Antarctica\/Palmer": "(UTC-03:00) Antarctica\/Palmer",
            "America\/Recife": "(UTC-03:00) America\/Recife",
            "Atlantic\/Bermuda": "(UTC-03:00) Atlantic\/Bermuda",
            "America\/Maceio": "(UTC-03:00) America\/Maceio",
            "America\/Argentina\/Ushuaia": "(UTC-03:00) America\/Argentina\/Ushuaia",
            "America\/Argentina\/Jujuy": "(UTC-03:00) America\/Argentina\/Jujuy",
            "America\/Argentina\/Buenos_Aires": "(UTC-03:00) America\/Argentina\/Buenos_Aires",
            "America\/Argentina\/La_Rioja": "(UTC-03:00) America\/Argentina\/La_Rioja",
            "America\/Argentina\/Mendoza": "(UTC-03:00) America\/Argentina\/Mendoza",
            "America\/Argentina\/Rio_Gallegos": "(UTC-03:00) America\/Argentina\/Rio_Gallegos",
            "America\/Argentina\/Salta": "(UTC-03:00) America\/Argentina\/Salta",
            "America\/Argentina\/San_Juan": "(UTC-03:00) America\/Argentina\/San_Juan",
            "America\/Argentina\/San_Luis": "(UTC-03:00) America\/Argentina\/San_Luis",
            "America\/Argentina\/Tucuman": "(UTC-03:00) America\/Argentina\/Tucuman",
            "America\/Araguaina": "(UTC-03:00) America\/Araguaina",
            "America\/Argentina\/Catamarca": "(UTC-03:00) America\/Argentina\/Catamarca",
            "America\/Bahia": "(UTC-03:00) America\/Bahia",
            "America\/Belem": "(UTC-03:00) America\/Belem",
            "America\/Cayenne": "(UTC-03:00) America\/Cayenne",
            "America\/Fortaleza": "(UTC-03:00) America\/Fortaleza",
            "America\/Glace_Bay": "(UTC-03:00) America\/Glace_Bay",
            "America\/Goose_Bay": "(UTC-03:00) America\/Goose_Bay",
            "America\/Halifax": "(UTC-03:00) America\/Halifax",
            "America\/Argentina\/Cordoba": "(UTC-03:00) America\/Argentina\/Cordoba",
            "America\/St_Johns": "(UTC-02:30) America\/St_Johns",
            "Atlantic\/South_Georgia": "(UTC-02:00) Atlantic\/South_Georgia",
            "America\/Noronha": "(UTC-02:00) America\/Noronha",
            "America\/Miquelon": "(UTC-02:00) America\/Miquelon",
            "America\/Godthab": "(UTC-02:00) America\/Godthab",
            "Atlantic\/Cape_Verde": "(UTC-01:00) Atlantic\/Cape_Verde",
            "Africa\/Lome": "(UTC+00:00) Africa\/Lome",
            "Africa\/Casablanca": "(UTC+00:00) Africa\/Casablanca",
            "Africa\/Freetown": "(UTC+00:00) Africa\/Freetown",
            "Africa\/El_Aaiun": "(UTC+00:00) Africa\/El_Aaiun",
            "Africa\/Dakar": "(UTC+00:00) Africa\/Dakar",
            "Africa\/Conakry": "(UTC+00:00) Africa\/Conakry",
            "Africa\/Banjul": "(UTC+00:00) Africa\/Banjul",
            "Africa\/Bissau": "(UTC+00:00) Africa\/Bissau",
            "Atlantic\/Azores": "(UTC+00:00) Atlantic\/Azores",
            "Africa\/Bamako": "(UTC+00:00) Africa\/Bamako",
            "Africa\/Accra": "(UTC+00:00) Africa\/Accra",
            "Atlantic\/St_Helena": "(UTC+00:00) Atlantic\/St_Helena",
            "Atlantic\/Reykjavik": "(UTC+00:00) Atlantic\/Reykjavik",
            "America\/Scoresbysund": "(UTC+00:00) America\/Scoresbysund",
            "Africa\/Abidjan": "(UTC+00:00) Africa\/Abidjan",
            "Africa\/Nouakchott": "(UTC+00:00) Africa\/Nouakchott",
            "Africa\/Monrovia": "(UTC+00:00) Africa\/Monrovia",
            "Africa\/Sao_Tome": "(UTC+00:00) Africa\/Sao_Tome",
            "America\/Danmarkshavn": "(UTC+00:00) America\/Danmarkshavn",
            "Africa\/Ouagadougou": "(UTC+00:00) Africa\/Ouagadougou",
            "Europe\/London": "(UTC+01:00) Europe\/London",
            "Europe\/Lisbon": "(UTC+01:00) Europe\/Lisbon",
            "Europe\/Jersey": "(UTC+01:00) Europe\/Jersey",
            "Europe\/Isle_of_Man": "(UTC+01:00) Europe\/Isle_of_Man",
            "Europe\/Guernsey": "(UTC+01:00) Europe\/Guernsey",
            "Europe\/Dublin": "(UTC+01:00) Europe\/Dublin",
            "Africa\/Porto-Novo": "(UTC+01:00) Africa\/Porto-Novo",
            "Africa\/Bangui": "(UTC+01:00) Africa\/Bangui",
            "Africa\/Niamey": "(UTC+01:00) Africa\/Niamey",
            "Africa\/Brazzaville": "(UTC+01:00) Africa\/Brazzaville",
            "Africa\/Ndjamena": "(UTC+01:00) Africa\/Ndjamena",
            "Africa\/Luanda": "(UTC+01:00) Africa\/Luanda",
            "Africa\/Kinshasa": "(UTC+01:00) Africa\/Kinshasa",
            "Africa\/Tunis": "(UTC+01:00) Africa\/Tunis",
            "Atlantic\/Faroe": "(UTC+01:00) Atlantic\/Faroe",
            "Africa\/Lagos": "(UTC+01:00) Africa\/Lagos",
            "Africa\/Douala": "(UTC+01:00) Africa\/Douala",
            "Atlantic\/Madeira": "(UTC+01:00) Atlantic\/Madeira",
            "Africa\/Algiers": "(UTC+01:00) Africa\/Algiers",
            "Africa\/Libreville": "(UTC+01:00) Africa\/Libreville",
            "Africa\/Malabo": "(UTC+01:00) Africa\/Malabo",
            "Atlantic\/Canary": "(UTC+01:00) Atlantic\/Canary",
            "Europe\/Kaliningrad": "(UTC+02:00) Europe\/Kaliningrad",
            "Europe\/Andorra": "(UTC+02:00) Europe\/Andorra",
            "Europe\/Ljubljana": "(UTC+02:00) Europe\/Ljubljana",
            "Europe\/Madrid": "(UTC+02:00) Europe\/Madrid",
            "Europe\/Malta": "(UTC+02:00) Europe\/Malta",
            "Europe\/Monaco": "(UTC+02:00) Europe\/Monaco",
            "Europe\/Oslo": "(UTC+02:00) Europe\/Oslo",
            "Europe\/Paris": "(UTC+02:00) Europe\/Paris",
            "Europe\/Luxembourg": "(UTC+02:00) Europe\/Luxembourg",
            "Europe\/Gibraltar": "(UTC+02:00) Europe\/Gibraltar",
            "Europe\/Amsterdam": "(UTC+02:00) Europe\/Amsterdam",
            "Europe\/Copenhagen": "(UTC+02:00) Europe\/Copenhagen",
            "Europe\/Busingen": "(UTC+02:00) Europe\/Busingen",
            "Africa\/Windhoek": "(UTC+02:00) Africa\/Windhoek",
            "Africa\/Tripoli": "(UTC+02:00) Africa\/Tripoli",
            "Europe\/Budapest": "(UTC+02:00) Europe\/Budapest",
            "Europe\/Brussels": "(UTC+02:00) Europe\/Brussels",
            "Europe\/Prague": "(UTC+02:00) Europe\/Prague",
            "Europe\/Bratislava": "(UTC+02:00) Europe\/Bratislava",
            "Europe\/Berlin": "(UTC+02:00) Europe\/Berlin",
            "Europe\/Belgrade": "(UTC+02:00) Europe\/Belgrade",
            "Europe\/Podgorica": "(UTC+02:00) Europe\/Podgorica",
            "Europe\/San_Marino": "(UTC+02:00) Europe\/San_Marino",
            "Europe\/Zagreb": "(UTC+02:00) Europe\/Zagreb",
            "Africa\/Maseru": "(UTC+02:00) Africa\/Maseru",
            "Africa\/Blantyre": "(UTC+02:00) Africa\/Blantyre",
            "Antarctica\/Troll": "(UTC+02:00) Antarctica\/Troll",
            "Africa\/Bujumbura": "(UTC+02:00) Africa\/Bujumbura",
            "Europe\/Rome": "(UTC+02:00) Europe\/Rome",
            "Europe\/Warsaw": "(UTC+02:00) Europe\/Warsaw",
            "Africa\/Cairo": "(UTC+02:00) Africa\/Cairo",
            "Africa\/Ceuta": "(UTC+02:00) Africa\/Ceuta",
            "Europe\/Vienna": "(UTC+02:00) Europe\/Vienna",
            "Europe\/Vatican": "(UTC+02:00) Europe\/Vatican",
            "Africa\/Mbabane": "(UTC+02:00) Africa\/Mbabane",
            "Europe\/Vaduz": "(UTC+02:00) Europe\/Vaduz",
            "Africa\/Maputo": "(UTC+02:00) Africa\/Maputo",
            "Europe\/Tirane": "(UTC+02:00) Europe\/Tirane",
            "Africa\/Gaborone": "(UTC+02:00) Africa\/Gaborone",
            "Europe\/Stockholm": "(UTC+02:00) Europe\/Stockholm",
            "Africa\/Harare": "(UTC+02:00) Africa\/Harare",
            "Africa\/Johannesburg": "(UTC+02:00) Africa\/Johannesburg",
            "Africa\/Khartoum": "(UTC+02:00) Africa\/Khartoum",
            "Europe\/Skopje": "(UTC+02:00) Europe\/Skopje",
            "Africa\/Kigali": "(UTC+02:00) Africa\/Kigali",
            "Africa\/Lusaka": "(UTC+02:00) Africa\/Lusaka",
            "Europe\/Sarajevo": "(UTC+02:00) Europe\/Sarajevo",
            "Africa\/Lubumbashi": "(UTC+02:00) Africa\/Lubumbashi",
            "Europe\/Zurich": "(UTC+02:00) Europe\/Zurich",
            "Indian\/Mayotte": "(UTC+03:00) Indian\/Mayotte",
            "Europe\/Athens": "(UTC+03:00) Europe\/Athens",
            "Europe\/Riga": "(UTC+03:00) Europe\/Riga",
            "Europe\/Bucharest": "(UTC+03:00) Europe\/Bucharest",
            "Europe\/Uzhgorod": "(UTC+03:00) Europe\/Uzhgorod",
            "Europe\/Simferopol": "(UTC+03:00) Europe\/Simferopol",
            "Europe\/Moscow": "(UTC+03:00) Europe\/Moscow",
            "Europe\/Minsk": "(UTC+03:00) Europe\/Minsk",
            "Europe\/Mariehamn": "(UTC+03:00) Europe\/Mariehamn",
            "Europe\/Sofia": "(UTC+03:00) Europe\/Sofia",
            "Europe\/Tallinn": "(UTC+03:00) Europe\/Tallinn",
            "Europe\/Kirov": "(UTC+03:00) Europe\/Kirov",
            "Indian\/Comoro": "(UTC+03:00) Indian\/Comoro",
            "Europe\/Kiev": "(UTC+03:00) Europe\/Kiev",
            "Europe\/Istanbul": "(UTC+03:00) Europe\/Istanbul",
            "Europe\/Vilnius": "(UTC+03:00) Europe\/Vilnius",
            "Europe\/Helsinki": "(UTC+03:00) Europe\/Helsinki",
            "Europe\/Zaporozhye": "(UTC+03:00) Europe\/Zaporozhye",
            "Europe\/Chisinau": "(UTC+03:00) Europe\/Chisinau",
            "Indian\/Antananarivo": "(UTC+03:00) Indian\/Antananarivo",
            "Asia\/Amman": "(UTC+03:00) Asia\/Amman",
            "Asia\/Aden": "(UTC+03:00) Asia\/Aden",
            "Africa\/Mogadishu": "(UTC+03:00) Africa\/Mogadishu",
            "Asia\/Kuwait": "(UTC+03:00) Asia\/Kuwait",
            "Asia\/Nicosia": "(UTC+03:00) Asia\/Nicosia",
            "Asia\/Baghdad": "(UTC+03:00) Asia\/Baghdad",
            "Antarctica\/Syowa": "(UTC+03:00) Antarctica\/Syowa",
            "Asia\/Jerusalem": "(UTC+03:00) Asia\/Jerusalem",
            "Asia\/Bahrain": "(UTC+03:00) Asia\/Bahrain",
            "Asia\/Gaza": "(UTC+03:00) Asia\/Gaza",
            "Asia\/Qatar": "(UTC+03:00) Asia\/Qatar",
            "Asia\/Famagusta": "(UTC+03:00) Asia\/Famagusta",
            "Asia\/Riyadh": "(UTC+03:00) Asia\/Riyadh",
            "Africa\/Nairobi": "(UTC+03:00) Africa\/Nairobi",
            "Asia\/Hebron": "(UTC+03:00) Asia\/Hebron",
            "Africa\/Kampala": "(UTC+03:00) Africa\/Kampala",
            "Asia\/Damascus": "(UTC+03:00) Asia\/Damascus",
            "Asia\/Beirut": "(UTC+03:00) Asia\/Beirut",
            "Africa\/Dar_es_Salaam": "(UTC+03:00) Africa\/Dar_es_Salaam",
            "Africa\/Djibouti": "(UTC+03:00) Africa\/Djibouti",
            "Africa\/Asmara": "(UTC+03:00) Africa\/Asmara",
            "Africa\/Addis_Ababa": "(UTC+03:00) Africa\/Addis_Ababa",
            "Africa\/Juba": "(UTC+03:00) Africa\/Juba",
            "Indian\/Mauritius": "(UTC+04:00) Indian\/Mauritius",
            "Asia\/Tbilisi": "(UTC+04:00) Asia\/Tbilisi",
            "Europe\/Saratov": "(UTC+04:00) Europe\/Saratov",
            "Asia\/Dubai": "(UTC+04:00) Asia\/Dubai",
            "Europe\/Astrakhan": "(UTC+04:00) Europe\/Astrakhan",
            "Indian\/Mahe": "(UTC+04:00) Indian\/Mahe",
            "Europe\/Ulyanovsk": "(UTC+04:00) Europe\/Ulyanovsk",
            "Asia\/Baku": "(UTC+04:00) Asia\/Baku",
            "Indian\/Reunion": "(UTC+04:00) Indian\/Reunion",
            "Europe\/Samara": "(UTC+04:00) Europe\/Samara",
            "Asia\/Muscat": "(UTC+04:00) Asia\/Muscat",
            "Asia\/Yerevan": "(UTC+04:00) Asia\/Yerevan",
            "Europe\/Volgograd": "(UTC+04:00) Europe\/Volgograd",
            "Asia\/Kabul": "(UTC+04:30) Asia\/Kabul",
            "Asia\/Tehran": "(UTC+04:30) Asia\/Tehran",
            "Asia\/Aqtobe": "(UTC+05:00) Asia\/Aqtobe",
            "Asia\/Aqtau": "(UTC+05:00) Asia\/Aqtau",
            "Asia\/Karachi": "(UTC+05:00) Asia\/Karachi",
            "Antarctica\/Mawson": "(UTC+05:00) Antarctica\/Mawson",
            "Asia\/Oral": "(UTC+05:00) Asia\/Oral",
            "Asia\/Tashkent": "(UTC+05:00) Asia\/Tashkent",
            "Indian\/Kerguelen": "(UTC+05:00) Indian\/Kerguelen",
            "Indian\/Maldives": "(UTC+05:00) Indian\/Maldives",
            "Asia\/Atyrau": "(UTC+05:00) Asia\/Atyrau",
            "Asia\/Qyzylorda": "(UTC+05:00) Asia\/Qyzylorda",
            "Asia\/Dushanbe": "(UTC+05:00) Asia\/Dushanbe",
            "Asia\/Samarkand": "(UTC+05:00) Asia\/Samarkand",
            "Asia\/Yekaterinburg": "(UTC+05:00) Asia\/Yekaterinburg",
            "Asia\/Ashgabat": "(UTC+05:00) Asia\/Ashgabat",
            "Asia\/Colombo": "(UTC+05:30) Asia\/Colombo",
            "Asia\/Kolkata": "(UTC+05:30) Asia\/Kolkata",
            "Asia\/Kathmandu": "(UTC+05:45) Asia\/Kathmandu",
            "Asia\/Dhaka": "(UTC+06:00) Asia\/Dhaka",
            "Asia\/Bishkek": "(UTC+06:00) Asia\/Bishkek",
            "Asia\/Thimphu": "(UTC+06:00) Asia\/Thimphu",
            "Asia\/Omsk": "(UTC+06:00) Asia\/Omsk",
            "Antarctica\/Vostok": "(UTC+06:00) Antarctica\/Vostok",
            "Indian\/Chagos": "(UTC+06:00) Indian\/Chagos",
            "Asia\/Urumqi": "(UTC+06:00) Asia\/Urumqi",
            "Asia\/Almaty": "(UTC+06:00) Asia\/Almaty",
            "Asia\/Qostanay": "(UTC+06:00) Asia\/Qostanay",
            "Indian\/Cocos": "(UTC+06:30) Indian\/Cocos",
            "Asia\/Yangon": "(UTC+06:30) Asia\/Yangon",
            "Antarctica\/Davis": "(UTC+07:00) Antarctica\/Davis",
            "Asia\/Tomsk": "(UTC+07:00) Asia\/Tomsk",
            "Asia\/Vientiane": "(UTC+07:00) Asia\/Vientiane",
            "Asia\/Barnaul": "(UTC+07:00) Asia\/Barnaul",
            "Asia\/Krasnoyarsk": "(UTC+07:00) Asia\/Krasnoyarsk",
            "Asia\/Pontianak": "(UTC+07:00) Asia\/Pontianak",
            "Asia\/Ho_Chi_Minh": "(UTC+07:00) Asia\/Ho_Chi_Minh",
            "Asia\/Hovd": "(UTC+07:00) Asia\/Hovd",
            "Asia\/Phnom_Penh": "(UTC+07:00) Asia\/Phnom_Penh",
            "Asia\/Jakarta": "(UTC+07:00) Asia\/Jakarta",
            "Indian\/Christmas": "(UTC+07:00) Indian\/Christmas",
            "Asia\/Novosibirsk": "(UTC+07:00) Asia\/Novosibirsk",
            "Asia\/Novokuznetsk": "(UTC+07:00) Asia\/Novokuznetsk",
            "Asia\/Bangkok": "(UTC+07:00) Asia\/Bangkok",
            "Antarctica\/Casey": "(UTC+08:00) Antarctica\/Casey",
            "Asia\/Shanghai": "(UTC+08:00) Asia\/Shanghai",
            "Asia\/Brunei": "(UTC+08:00) Asia\/Brunei",
            "Asia\/Kuala_Lumpur": "(UTC+08:00) Asia\/Kuala_Lumpur",
            "Australia\/Perth": "(UTC+08:00) Australia\/Perth",
            "Asia\/Manila": "(UTC+08:00) Asia\/Manila",
            "Asia\/Ulaanbaatar": "(UTC+08:00) Asia\/Ulaanbaatar",
            "Asia\/Macau": "(UTC+08:00) Asia\/Macau",
            "Asia\/Kuching": "(UTC+08:00) Asia\/Kuching",
            "Asia\/Makassar": "(UTC+08:00) Asia\/Makassar",
            "Asia\/Taipei": "(UTC+08:00) Asia\/Taipei",
            "Asia\/Choibalsan": "(UTC+08:00) Asia\/Choibalsan",
            "Asia\/Irkutsk": "(UTC+08:00) Asia\/Irkutsk",
            "Asia\/Hong_Kong": "(UTC+08:00) Asia\/Hong_Kong",
            "Asia\/Singapore": "(UTC+08:00) Asia\/Singapore",
            "Australia\/Eucla": "(UTC+08:45) Australia\/Eucla",
            "Asia\/Chita": "(UTC+09:00) Asia\/Chita",
            "Asia\/Tokyo": "(UTC+09:00) Asia\/Tokyo",
            "Pacific\/Palau": "(UTC+09:00) Pacific\/Palau",
            "Asia\/Khandyga": "(UTC+09:00) Asia\/Khandyga",
            "Asia\/Yakutsk": "(UTC+09:00) Asia\/Yakutsk",
            "Asia\/Seoul": "(UTC+09:00) Asia\/Seoul",
            "Asia\/Dili": "(UTC+09:00) Asia\/Dili",
            "Asia\/Jayapura": "(UTC+09:00) Asia\/Jayapura",
            "Asia\/Pyongyang": "(UTC+09:00) Asia\/Pyongyang",
            "Australia\/Adelaide": "(UTC+09:30) Australia\/Adelaide",
            "Australia\/Darwin": "(UTC+09:30) Australia\/Darwin",
            "Australia\/Broken_Hill": "(UTC+09:30) Australia\/Broken_Hill",
            "Pacific\/Guam": "(UTC+10:00) Pacific\/Guam",
            "Pacific\/Port_Moresby": "(UTC+10:00) Pacific\/Port_Moresby",
            "Antarctica\/DumontDUrville": "(UTC+10:00) Antarctica\/DumontDUrville",
            "Pacific\/Chuuk": "(UTC+10:00) Pacific\/Chuuk",
            "Australia\/Currie": "(UTC+10:00) Australia\/Currie",
            "Pacific\/Saipan": "(UTC+10:00) Pacific\/Saipan",
            "Australia\/Hobart": "(UTC+10:00) Australia\/Hobart",
            "Australia\/Sydney": "(UTC+10:00) Australia\/Sydney",
            "Australia\/Lindeman": "(UTC+10:00) Australia\/Lindeman",
            "Australia\/Melbourne": "(UTC+10:00) Australia\/Melbourne",
            "Asia\/Ust-Nera": "(UTC+10:00) Asia\/Ust-Nera",
            "Asia\/Vladivostok": "(UTC+10:00) Asia\/Vladivostok",
            "Australia\/Brisbane": "(UTC+10:00) Australia\/Brisbane",
            "Australia\/Lord_Howe": "(UTC+10:30) Australia\/Lord_Howe",
            "Pacific\/Pohnpei": "(UTC+11:00) Pacific\/Pohnpei",
            "Asia\/Srednekolymsk": "(UTC+11:00) Asia\/Srednekolymsk",
            "Antarctica\/Macquarie": "(UTC+11:00) Antarctica\/Macquarie",
            "Asia\/Sakhalin": "(UTC+11:00) Asia\/Sakhalin",
            "Pacific\/Efate": "(UTC+11:00) Pacific\/Efate",
            "Pacific\/Bougainville": "(UTC+11:00) Pacific\/Bougainville",
            "Asia\/Magadan": "(UTC+11:00) Asia\/Magadan",
            "Pacific\/Kosrae": "(UTC+11:00) Pacific\/Kosrae",
            "Pacific\/Noumea": "(UTC+11:00) Pacific\/Noumea",
            "Pacific\/Norfolk": "(UTC+11:00) Pacific\/Norfolk",
            "Pacific\/Guadalcanal": "(UTC+11:00) Pacific\/Guadalcanal",
            "Pacific\/Tarawa": "(UTC+12:00) Pacific\/Tarawa",
            "Pacific\/Wake": "(UTC+12:00) Pacific\/Wake",
            "Pacific\/Wallis": "(UTC+12:00) Pacific\/Wallis",
            "Pacific\/Nauru": "(UTC+12:00) Pacific\/Nauru",
            "Pacific\/Majuro": "(UTC+12:00) Pacific\/Majuro",
            "Pacific\/Kwajalein": "(UTC+12:00) Pacific\/Kwajalein",
            "Pacific\/Funafuti": "(UTC+12:00) Pacific\/Funafuti",
            "Pacific\/Fiji": "(UTC+12:00) Pacific\/Fiji",
            "Pacific\/Auckland": "(UTC+12:00) Pacific\/Auckland",
            "Antarctica\/McMurdo": "(UTC+12:00) Antarctica\/McMurdo",
            "Asia\/Anadyr": "(UTC+12:00) Asia\/Anadyr",
            "Asia\/Kamchatka": "(UTC+12:00) Asia\/Kamchatka",
            "Pacific\/Chatham": "(UTC+12:45) Pacific\/Chatham",
            "Pacific\/Fakaofo": "(UTC+13:00) Pacific\/Fakaofo",
            "Pacific\/Enderbury": "(UTC+13:00) Pacific\/Enderbury",
            "Pacific\/Apia": "(UTC+13:00) Pacific\/Apia",
            "Pacific\/Tongatapu": "(UTC+13:00) Pacific\/Tongatapu",
            "Pacific\/Kiritimati": "(UTC+14:00) Pacific\/Kiritimati"
        },
        "timezone": "",
        "post_id": "545",
        "ckot_url": "http:\/\/citybook.meetclic.com\/index.php\/listing-checkout\/",
        "location_type": "administrative_area_level_1",
        "address_format": ["formatted_address"],
        "country_restrictions": "",
        "place_lng": "",
        "disable_bubble": "no",
        "lb_approved": "Approved",
        "lb_24h": "1",
        "td_color": "#4DB7FE",
        "lb_delay": "3000",
        "md_limit": "3",
        "md_limit_msg": "Max upload files is 3",
        "md_limit_size": "2",
        "md_limit_size_msg": "Max upload file size is 2 MB",
        "search": "Search...",
        "gcaptcha": "",
        "gcaptcha_key": "",
        "location_show_state": "",
        "payment": [],
        "weather_strings": {
            "days": ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            "min": "Min",
            "max": "Max",
            "direction": ["N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSW", "SW", "WSW", "W", "WNW", "NW", "NNW"]
        },
        "i18n": {
            "share_on": "Share this on {SOCIAL}",
            "del-listing": "Are you sure want to delete <?php  echo "{{listing_title}}" ?>listing and its data?\nThe listing is permanently deleted.",
            "cancel-booking": "Are you sure want to cancel <?php  echo "{{booking_title}}" ?> booking?",
            "approve-booking": "Are you sure want to approve <?php  echo "{{booking_title}}" ?> booking?",
            "del-booking": "Are you sure want to delete <?php  echo "{{booking_title}} " ?>booking and its data?\nThe booking is permanently deleted.",
            "del-message": "Are you sure want to cancel <?php  echo "{{message_title}}" ?> message?",
            "cancel-package": "Are you sure want to cancel this subscription?",
            "chats_h3": "Inbox",
            "chat_fr_owner": "Chat With Owner",
            "chat_fr_login": "Login to chat",
            "chat_fr_cwith": "You is chatting with  ",
            "chat_fr_conver": "Conversation list",
            "change_pas_h3": " Change Password",
            "change_pas_lb_CP": "Current Password",
            "change_pas_lb_NP": "New Password",
            "change_pas_lb_CNP": "Confirm New Password",
            "inner_chat_op_W": "Week",
            "inner_chat_op_M": "Month",
            "inner_chat_op_Y": "Year",
            "inner_listing_li_E": "Edit ",
            "inner_listing_li_D": "Delete ",
            "author_review_h3": "Reviews for your listings",
            "likebtn": "Like Button",
            "welcome": "Welcome",
            "listings": "Listings",
            "bookings": "Bookings",
            "reviews": "Reviews",
            "log_out": "Log Out ",
            "add_hour": "Add Hour",
            "timezone": "Timezone",
            "book_dates": "Dates",
            "book_services": "Extra Services",
            "book_ad": "ADULTS",
            "book_chi": "CHILDREN",
            "book_avr": "Available Rooms",
            "book_ts": "Total Cost",
            "book_chev": "Check availability",
            "book_bn": "Book Now",
            "checkout_can": "Cancel",
            "checkout_app": "Apply",
            "roomsl_avai": "Available:",
            "roomsl_maxg": "Max Guests: ",
            "roomsl_quan": "Quantity",
            "btn_save": "Save Change",
            "btn_save_c": "Save Changes",
            "btn_close": "Close me",
            "btn_send": "Send",
            "btn_add_F": "Add Fact +",
            "fact_title": "Fact Title",
            "fact_number": "Fact Number",
            "fact_icon": "Fact Icon",
            "location_country": "Country",
            "location_state": "State",
            "location_city": "City",
            "faq_title": "Question",
            "faq_content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
            "btn_add_Faq": "Add FAQ",
            "btn_add_S": "Add Social +",
            "btn_add_R": "Add Room +",
            "image_upload": " Click here to upload",
            "th_mount": "Amount",
            "th_method": "Method",
            "th_to": "To",
            "th_date": "Date Submitted",
            "th_status": "Status",
            "calendar_dis_number": "Select the number of months displayed.",
            "calendar_number_one": "One Months",
            "calendar_number_two": "Two Months",
            "calendar_number_three": "Three Months",
            "calendar_number_four": "Four Months",
            "calendar_number_five": "Five Months",
            "calendar_number_six": "Six Months",
            "calendar_number_seven": "Seven Months",
            "coupon_code": "Coupon code",
            "coupon_discount": "Discount type",
            "coupon_percentage": "Percentage discount",
            "coupon_fix_cart": "Fixed cart discount",
            "coupon_desc": "Description",
            "coupon_show": "Display content in widget banner?",
            "coupon_amount": "Discount amount",
            "coupon_qtt": "Coupon quantity",
            "coupon_expiry": "Coupon expiry date",
            "coupon_format": "Format:YY-mm-dd HH:ii:ss",
            "bt_coupon": "Add Coupon",
            "bt_services": "Add Service",
            "services_name": "Service Name",
            "services_desc": "Description",
            "services_price": "Service Price",
            "bt_member": "Add Member",
            "member_name": "Name: ",
            "member_job": "Job or Position: ",
            "member_desc": "Description",
            "member_img": "Image",
            "memeber_social": "Socials",
            "days": ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
            "months": ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            "earnings_title": "Your Earnings",
            "th_date_": "Date",
            "th_total_": "Total",
            "th_fee_": "Author Fee",
            "th_earning_": "Earning",
            "th_order_": "Order",
            "go_back": "Go back",
            "no_earning": "You have no earning.",
            "cancel": "Cancel",
            "submit": "Submit",
            "ltype_title": "Listing type",
            "ltype_desc": "Listing type description",
            "wkh_enter": "Enter Hours",
            "wkh_open": "Open all day",
            "wkh_close": "Close all day",
            "calen_lock": "Lock this month",
            "calen_unlock": "Unlock this month",
            "smwdtitle": "Submit a withdrawal request",
            "wdfunds": "Withdraw funds",
            "goearnings": "View Earnings",
            "chat_type_msg": "Type Message",
            "save": "Save",
            "cal_event_start": "Event start time: ",
            "cal_event_end": "Event end date: ",
            "cal_opts": "Options",
            "wth_payments": "PayPal \/ Stripe Email",
            "wth_amount": "Amount ",
            "wth_plh_email": "email@gmail.com",
            "wth_acount_balance": "Account Balance",
            "wth_will_process": "Your request will be processed on ",
            "wth_no_request": "You have no withdrawal request",
            "bt_slots": "Add Time Slot",
            "slot_time": "Time",
            "slot_guests": "Guests",
            "slot_available": "Available slots",
            "nights": "Nights",
            "raselect_placeholder": "Select",
            "raselect_nooptions": "No options",
            "slots_add": "Add Slot",
            "slots_guests": "Max Guests",
            "slots_start": "Start time",
            "slots_end": "End time",
            "slots_price": "Price",
            "cal_bulkedit": "Bulk Edit",
            "save_bulkedit": "Save",
            "cancel_bulkedit": "Cancel",
            "adults": "Adults",
            "children": "Children",
            "AM": "AM",
            "PM": "PM"
        },
        "distance_df": "5",
        "curr_user": {
            "id": 0,
            "display_name": "",
            "avatar": "",
            "can_upload": false,
            "role": false,
            "is_author": false
        },
        "free_map": "",
        "currency": {
            "currency": "USD",
            "symbol": "$",
            "rate": "1",
            "sb_pos": "left",
            "decimal": "2",
            "ths_sep": ",",
            "dec_sep": "."
        },
        "base_currency": {
            "currency": "USD",
            "symbol": "$",
            "rate": "1",
            "sb_pos": "left",
            "decimal": "2",
            "ths_sep": ",",
            "dec_sep": "."
        },
        "wpml": null
    };
    /* ]]> */
</script>
<script type="text/javascript">
    (function (domain, translations) {
        var localeData = translations.locale_data[domain] || translations.locale_data.messages;
        localeData[""].domain = domain;
        wp.i18n.setLocaleData(localeData, domain);
    })("citybook-add-ons", {"locale_data": {"messages": {"": {}}}});
</script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/citybook-add-ons/assets/js/citybook-add-ons.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-includes/js/dist/vendor/react.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-includes/js/dist/vendor/react-dom.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/citybook-add-ons/assets/js/react-router-dom.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/citybook-add-ons/assets/js/redux.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/citybook-add-ons/assets/js/react-redux.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/citybook-add-ons/assets/js/redux-thunk.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/citybook-add-ons/assets/js/qs.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/citybook-add-ons/assets/js/axios.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/citybook-add-ons/assets/js/Sortable.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/citybook-add-ons/assets/js/react-sortable.min.js')}}"></script>
<script type="text/javascript">
    (function (domain, translations) {
        var localeData = translations.locale_data[domain] || translations.locale_data.messages;
        localeData[""].domain = domain;
        wp.i18n.setLocaleData(localeData, domain);
    })("citybook-add-ons", {"locale_data": {"messages": {"": {}}}});
</script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/citybook-add-ons/assets/js/citybook-react-app.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/citybook-add-ons/assets/js/citybook-chat-app.min.js')}}"></script>
<script type="text/javascript">
    /* <![CDATA[ */
    var wpcf7 = {
        "apiSettings": {
            "root": "http:\/\/citybook.meetclic.com\/index.php\/wp-json\/contact-form-7\/v1",
            "namespace": "contact-form-7\/v1"
        }, "cached": "1"
    };
    /* ]]> */
</script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/contact-form-7/includes/js/scripts.js?ver=5.1.8')}}"></script>

@if($woocomerceAllow)
    <script type="text/javascript"
            src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/woocommerce/assets/js/jquery-blockui/jquery.blockUI.min.js')}}"></script>

    <script type="text/javascript">
        /* <![CDATA[ */
        var wc_add_to_cart_params = {
            "ajax_url": "\/wp-admin\/admin-ajax.php",
            "wc_ajax_url": "\/?wc-ajax=%%endpoint%%",
            "i18n_view_cart": "View cart",
            "cart_url": "http:\/\/citybook.meetclic.com",
            "is_cart": "",
            "cart_redirect_after_add": "no"
        };
        /* ]]> */
    </script>

    <script type="text/javascript"
            src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/woocommerce/assets/js/frontend/add-to-cart.min.js')}}"></script>
    <script type="text/javascript"
            src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/woocommerce/assets/js/js-cookie/js.cookie.min.js')}}"></script>
    <script type="text/javascript">
        /* <![CDATA[ */
        var woocommerce_params = {"ajax_url": "\/wp-admin\/admin-ajax.php", "wc_ajax_url": "\/?wc-ajax=%%endpoint%%"};
        /* ]]> */
    </script>
    <script type="text/javascript"
            src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/woocommerce/assets/js/frontend/woocommerce.min.js')}}"></script>
    <script type="text/javascript">
        /* <![CDATA[ */
        var wc_cart_fragments_params = {
            "ajax_url": "\/wp-admin\/admin-ajax.php",
            "wc_ajax_url": "\/?wc-ajax=%%endpoint%%",
            "cart_hash_key": "wc_cart_hash_391acb7c8e5b40a808c5fb3204e39147",
            "fragment_name": "wc_fragments_391acb7c8e5b40a808c5fb3204e39147",
            "request_timeout": "5000"
        };
        /* ]]> */
    </script>
    <script type="text/javascript"
            src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/woocommerce/assets/js/frontend/cart-fragments.min.js')}}"></script>
@endif
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/themes/citybook/assets/js/jquery.easing.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/themes/citybook/assets/js/jquery.appear.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/themes/citybook/assets/js/jquery.countTo.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/themes/citybook/assets/js/navigation.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/themes/citybook/assets/js/rangeslider.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/themes/citybook/assets/js/slick.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/themes/citybook/assets/js/lightgallery.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/themes/citybook/assets/js/scripts.js')}}"></script>

@if( isset($dataManagerPage['currentPage'])&& $dataManagerPage['currentPage']=='search' )


    <script type="text/javascript"
            src="http://citybook.meetclic.com/wp-includes/js/jquery/ui/draggable.min.js?ver=1.11.4"></script>
    <script type="text/javascript" src="http://citybook.meetclic.com/wp-includes/js/backbone.min.js?ver=1.4.0"></script>
    <script type="text/javascript"
            src="http://citybook.meetclic.com/wp-content/plugins/elementor/assets/lib/backbone/backbone.marionette.min.js?ver=2.4.5"></script>
    <script type="text/javascript"
            src="http://citybook.meetclic.com/wp-content/plugins/elementor/assets/lib/backbone/backbone.radio.min.js?ver=1.0.4"></script>
    <script type="text/javascript"
            src="http://citybook.meetclic.com/wp-content/plugins/elementor/assets/js/common-modules.min.js?ver=2.9.8"></script>

    <script type="text/javascript">
        var elementorCommonConfig = {
            "version": "2.9.8",
            "isRTL": false,
            "isDebug": false,
            "activeModules": ["ajax", "finder", "connect"],
            "urls": {"assets": "http:\/\/citybook.meetclic.com\/wp-content\/plugins\/elementor\/assets\/"},
            "ajax": {"url": "http:\/\/citybook.meetclic.com\/wp-admin\/admin-ajax.php", "nonce": "dd538f9f26"},
            "finder": {
                "data": {
                    "edit": {"title": "Edit", "dynamic": true, "name": "edit"},
                    "general": {
                        "title": "General",
                        "dynamic": false,
                        "items": {
                            "saved-templates": {
                                "title": "Saved Templates",
                                "icon": "library-save",
                                "url": "http:\/\/citybook.meetclic.com\/wp-admin\/edit.php?post_type=elementor_library&tabs_group=library",
                                "keywords": ["template", "section", "page", "library"]
                            },
                            "system-info": {
                                "title": "System Info",
                                "icon": "info-circle-o",
                                "url": "http:\/\/citybook.meetclic.com\/wp-admin\/admin.php?page=elementor-system-info",
                                "keywords": ["system", "info", "environment", "elementor"]
                            },
                            "role-manager": {
                                "title": "Role Manager",
                                "icon": "person",
                                "url": "http:\/\/citybook.meetclic.com\/wp-admin\/admin.php?page=elementor-role-manager",
                                "keywords": ["role", "manager", "user", "elementor"]
                            },
                            "knowledge-base": {
                                "title": "Knowledge Base",
                                "url": "http:\/\/citybook.meetclic.com\/wp-admin\/admin.php?page=go_knowledge_base_site",
                                "keywords": ["help", "knowledge", "docs", "elementor"]
                            }
                        },
                        "name": "general"
                    },
                    "create": {
                        "title": "Create",
                        "dynamic": false,
                        "items": {
                            "post": {
                                "title": "Add New Entrada",
                                "icon": "plus-circle-o",
                                "url": "http:\/\/citybook.meetclic.com\/wp-admin\/edit.php?action=elementor_new_post&post_type=post&_wpnonce=5e3f73c2cb",
                                "keywords": ["post", "page", "template", "new", "create"]
                            },
                            "page": {
                                "title": "Add New P\u00e1gina",
                                "icon": "plus-circle-o",
                                "url": "http:\/\/citybook.meetclic.com\/wp-admin\/edit.php?action=elementor_new_post&post_type=page&_wpnonce=5e3f73c2cb",
                                "keywords": ["post", "page", "template", "new", "create"]
                            },
                            "elementor_library": {
                                "title": "Add New Template",
                                "icon": "plus-circle-o",
                                "url": "http:\/\/citybook.meetclic.com\/wp-admin\/edit.php?post_type=elementor_library#add_new",
                                "keywords": ["post", "page", "template", "new", "create"]
                            }
                        },
                        "name": "create"
                    },
                    "site": {
                        "title": "Site", "dynamic": false, "items": {
                            "homepage": {
                                "title": "Homepage",
                                "url": "http:\/\/citybook.meetclic.com",
                                "icon": "home-heart",
                                "keywords": ["home", "page"]
                            },
                            "wordpress-dashboard": {
                                "title": "Dashboard",
                                "icon": "dashboard",
                                "url": "http:\/\/citybook.meetclic.com\/wp-admin\/",
                                "keywords": ["dashboard", "wordpress"]
                            },
                            "wordpress-menus": {
                                "title": "Menus",
                                "icon": "wordpress",
                                "url": "http:\/\/citybook.meetclic.com\/wp-admin\/nav-menus.php",
                                "keywords": ["menu", "wordpress"]
                            },
                            "wordpress-themes": {
                                "title": "Themes",
                                "icon": "wordpress",
                                "url": "http:\/\/citybook.meetclic.com\/wp-admin\/themes.php",
                                "keywords": ["themes", "wordpress"]
                            },
                            "wordpress-customizer": {
                                "title": "Customizer",
                                "icon": "wordpress",
                                "url": "http:\/\/citybook.meetclic.com\/wp-admin\/customize.php",
                                "keywords": ["customizer", "wordpress"]
                            },
                            "wordpress-plugins": {
                                "title": "Plugins",
                                "icon": "wordpress",
                                "url": "http:\/\/citybook.meetclic.com\/wp-admin\/plugins.php",
                                "keywords": ["plugins", "wordpress"]
                            },
                            "wordpress-users": {
                                "title": "Users",
                                "icon": "wordpress",
                                "url": "http:\/\/citybook.meetclic.com\/wp-admin\/users.php",
                                "keywords": ["users", "profile", "wordpress"]
                            }
                        }, "name": "site"
                    },
                    "settings": {
                        "title": "Settings",
                        "dynamic": false,
                        "items": {
                            "general-settings": {
                                "title": "General Settings",
                                "url": "http:\/\/citybook.meetclic.com\/wp-admin\/admin.php?page=elementor",
                                "keywords": ["general", "settings", "elementor"]
                            },
                            "style": {
                                "title": "Style",
                                "url": "http:\/\/citybook.meetclic.com\/wp-admin\/admin.php?page=elementor#tab-style",
                                "keywords": ["style", "settings", "elementor"]
                            },
                            "advanced": {
                                "title": "Advanced",
                                "url": "http:\/\/citybook.meetclic.com\/wp-admin\/admin.php?page=elementor#tab-advanced",
                                "keywords": ["advanced", "settings", "elementor"]
                            }
                        },
                        "name": "settings"
                    },
                    "tools": {
                        "title": "Tools",
                        "dynamic": false,
                        "items": {
                            "tools": {
                                "title": "Tools",
                                "icon": "tools",
                                "url": "http:\/\/citybook.meetclic.com\/wp-admin\/admin.php?page=elementor-tools",
                                "keywords": ["tools", "regenerate css", "safe mode", "debug bar", "sync library", "elementor"]
                            },
                            "replace-url": {
                                "title": "Replace URL",
                                "icon": "tools",
                                "url": "http:\/\/citybook.meetclic.com\/wp-admin\/admin.php?page=elementor-tools#tab-replace_url",
                                "keywords": ["tools", "replace url", "domain", "elementor"]
                            },
                            "version-control": {
                                "title": "Version Control",
                                "icon": "time-line",
                                "url": "http:\/\/citybook.meetclic.com\/wp-admin\/admin.php?page=elementor-tools#tab-versions",
                                "keywords": ["tools", "version", "control", "rollback", "beta", "elementor"]
                            },
                            "maintenance-mode": {
                                "title": "Maintenance Mode",
                                "icon": "tools",
                                "url": "http:\/\/citybook.meetclic.com\/wp-admin\/admin.php?page=elementor-tools#tab-maintenance_mode",
                                "keywords": ["tools", "maintenance", "coming soon", "elementor"]
                            }
                        },
                        "name": "tools"
                    }
                }, "i18n": {"finder": "Finder"}
            },
            "connect": []
        };
    </script>
    <script type="text/javascript"
            src="http://citybook.meetclic.com/wp-content/plugins/elementor/assets/js/common.min.js?ver=2.9.8"></script>
@endif
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-includes/js/wp-embed.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/elementor/assets/js/frontend-modules.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-includes/js/jquery/ui/position.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/elementor/assets/lib/dialog/dialog.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/elementor/assets/lib/waypoints/waypoints.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/elementor/assets/lib/swiper/swiper.min.js')}}"></script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/elementor/assets/lib/share-link/share-link.min.js')}}"></script>
<script type="text/javascript">
    var elementorFrontendConfig = {
        "environmentMode": {"edit": false, "wpPreview": false},
        "i18n": {
            "shareOnFacebook": "Share on Facebook",
            "shareOnTwitter": "Share on Twitter",
            "pinIt": "Pin it",
            "downloadImage": "Download image"
        },
        "is_rtl": false,
        "breakpoints": {"xs": 0, "sm": 480, "md": 768, "lg": 1025, "xl": 1440, "xxl": 1600},
        "version": "2.9.8",
        "urls": {"assets": "http:\/\/citybook.meetclic.com\/wp-content\/plugins\/elementor\/assets\/"},
        "settings": {
            "page": [],
            "general": {
                "elementor_global_image_lightbox": "yes",
                "elementor_lightbox_enable_counter": "yes",
                "elementor_lightbox_enable_fullscreen": "yes",
                "elementor_lightbox_enable_zoom": "yes",
                "elementor_lightbox_enable_share": "yes",
                "elementor_lightbox_title_src": "title",
                "elementor_lightbox_description_src": "description"
            },
            "editorPreferences": []
        },
        "post": {
            "id": 545,
            "title": "Bee%20%E2%80%93%20Otro%20sitio%20realizado%20con%20WordPress",
            "excerpt": "",
            "featuredImage": false
        }
    };
</script>
<script type="text/javascript"
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/elementor/assets/js/frontend.min.js')}}"></script>
<span id="elementor-device-mode" class="elementor-screen-only"></span>
<script>
    function lazyListingsChanged() {
        // create new window event for listing change
        var evt = new CustomEvent('listingsChanged', {detail: 'lazy-load'});
        window.dispatchEvent(evt);
    }

    function lazyGalChanged(el) {
        // create new window event for listing change
        var evt = new CustomEvent('galChanged', {detail: el});
      /*  window.dispatchEvent(evt);*/
    }

    // Set the options to make LazyLoad self-initialize
    window.lazyLoadOptions = {
        elements_selector: ".lazy",
        // ... more custom settings?
        callback_loaded: (el) => {
            // console.log("Loaded", el)

            if (window.listingItemsEle != null) {
                // console.log('has #listing-items');
                if (window.listingItemsEle.contains(el)) {
                    // console.log('el inside #listing-items');
                    lazyListingsChanged()
                }
            }

            lazyGalChanged(el)
        },
        callback_finish: () => {
            // console.log("Finish")
        },
    };
    // Listen to the initialization event and get the instance of LazyLoad
    window.addEventListener('LazyLoad::Initialized', function (event) {
        window.lazyLoadInstance = event.detail.instance;
        console.log('ah');
        window.listingItemsEle = document.getElementById('listing-items')
    }, false);
</script>
<script async=""
        src="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/citybook-add-ons/assets/js/lazyload.js')}}"></script>


@yield('additional-scripts')
@yield('script')
@yield('script-bottom')
