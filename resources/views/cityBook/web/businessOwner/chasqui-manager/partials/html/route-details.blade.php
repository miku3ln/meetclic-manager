<div class="company-panel company-panel--expanded" id="companyPanel">
    <div class="company-panel__header view-toogle-company " id="companyPanelHeader">
        <div class="company-panel__logo">
            <img
                src="{{$sourceChaquiñan}}"
                alt="Logo Empresa"
                class="company-panel__logo-img"
            />
        </div>

        <div class="company-panel__title view-toogle-company">
            <h2 id="companyName" class="company-panel__name">{{$titleChaquiñan}}</h2>
        </div>

        <button
            class="company-panel__toggle view-toogle-company company-panel__toggle--right"
            id="companyPanelToggle"
        >
            ⟩
        </button>
    </div>

    <div class="company-panel__body" >
        {!! $adventureHtml!!}
        </br>

        @if(    ($dataManager["allow"]))
            {!! $dataManager["dataRoute"]["routesDrawingGroupHtml"]!!}
        @else
            <div class="company-panel__section company-panel__section--stats">
                <div class="stats company-panel__stats">
                    <div class="stat company-panel__stat">
                        <span class="stat__label company-panel__stat-label">Tótems turísticos</span>
                        <span class="stat__value company-panel__stat-value" id="statTourism">5</span>
                    </div>
                    <div class="stat company-panel__stat">
                        <span class="stat__label company-panel__stat-label">Tótems deportivos</span>
                        <span class="stat__value company-panel__stat-value" id="statSports">2</span>
                    </div>
                    <div class="stat company-panel__stat">
                        <span class="stat__label company-panel__stat-label">Tótems geológicos</span>
                        <span class="stat__value company-panel__stat-value" id="statGeo">3</span>
                    </div>
                </div>
            </div>
            @endif

            </br>


            <div class="company-panel__section company-panel__section--description">
                <h3 class="color-primary--title company-panel__subtitle">Descripción</h3>

                @if(!$dataManager["allow"])
                    <p id="companyDescription" class="company-panel__description">
                        {{$descriptinoChaquiñan}}
                    </p>
                @else
                    <div id="companyDescription" class="company-panel__description">
                        {!! $descriptinoChaquiñan !!}
                    </div>
                @endif

                <button
                    class="link-button not-view company-panel__more-link"
                    id="btnMoreInfo">
                    Ver perfil completo
                </button>
            </div>

            <div class="company-panel__section company-panel__section--contacts">
                <h3 class="color-primary--title company-panel__subtitle">

                    <a class="color-secondary--title company-panel__contact-link"
                       id="companyWebsite"
                       href="{{ $hrefCurrent }}"
                       target="_blank">
                        🌐 {{$companyName}}
                    </a>
                </h3>
                <h3 class="color-primary--title company-panel__subtitle">
                    Contactanos
                </h3>
                <div class="contact-list company-panel__contacts">
                    <a class="color-secondary--title company-panel__contact-link"
                       id="companyEmail"
                       href="mailto:info@empresa.com">
                        📧 Email
                    </a>

                    <a class="color-secondary--title company-panel__contact-link"
                       id="companyWhatsapp"
                       href="https://wa.me/{{$phone}}?text={{urlencode($whatsappMessage) }}"
                       target="_blank">
                        💬 WhatsApp
                    </a>


                    <div class="social-icons company-panel__social">
                        <a class="color-secondary--title company-panel__social-link"
                           id="companyInstagram"
                           href="https://instagram.com/empresa"
                           target="_blank">
                            IG
                        </a>
                        <a class="color-secondary--title company-panel__social-link"
                           id="companyFacebook"
                           href="https://facebook.com/empresa"
                           target="_blank">
                            FB
                        </a>
                        <a class="color-secondary--title company-panel__social-link"
                           id="companyTiktok"
                           href="https://tiktok.com/@empresa"
                           target="_blank">
                            TT
                        </a>
                    </div>
                </div>
            </div>
    </div>
</div>
