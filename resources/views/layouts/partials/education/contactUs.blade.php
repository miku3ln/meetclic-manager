<!-- Classic Breadcrumbs-->
<section class="section breadcrumb-classic context-dark">
    <div class="container">
        <h1>Contacto</h1>
        <div class="offset-top-10 offset-md-top-35">
            <ul class="list-inline list-inline-lg list-inline-dashed p">
                <li><a href="{{ route($rootPage, app()->getLocale()) }}">Home</a></li>
                <li>Contacto
                </li>
            </ul>
        </div>
    </div>
</section>
<section class="section section-xl bg-default">
    <div class="container">
        <div class="row row-50 justify-content-sm-center">
            <div class="col-sm-10 col-lg-8 text-lg-left">
                <h2 class="font-weight-bold text-color--two">Cómo te podemos Ayudar?</h2>

                <div class="offset-top-30 offset-md-top-60">
                    <p>On the other hand , we denounce with righteous indignation and dislike men who e rejects
                        pelasures tosecure other greater </p>
                </div>
                <div class="offset-top-30">
                    <form  id="contact-form" class="rd-mailform text-left" data-form-output="form-output-global" data-form-type="contact"
                        method="post" >
                        <div class="row row-12">
                            <div class="col-xl-6">
                                <div class="form-wrap">
                                    <label class="form-label form-label-outside" for="contact-me-name">Primer Nombre
                                        *</label>
                                    <input class="form-input" id="contact-me-name" type="text" name="name"
                                        data-constraints="@Required">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-wrap">
                                    <label class="form-label form-label-outside" for="contact-me-last-name">Apellido
                                        *</label>
                                    <input class="form-input" id="contact-me-last-name" type="text" name="last-name"
                                        data-constraints="@Required">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-wrap">
                                    <label class="form-label form-label-outside" for="contact-me-email">E-mail *</label>
                                    <input class="form-input" id="contact-me-email" type="email" name="email"
                                        data-constraints="@Required @Email">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-wrap">
                                    <label class="form-label form-label-outside" for="contact-me-phone">Celular*</label>
                                    <input class="form-input" id="contact-me-phone" type="text" name="phone"
                                        data-constraints="@Required @IsNumeric">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="form-wrap">
                                    <label class="form-label form-label-outside" for="contact-me-message">Mensaje
                                        *</label>
                                    <textarea class="form-input" id="contact-me-message" name="message"
                                        data-constraints="@Required" style="height: 220px"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-center text-xl-left offset-top-20">
                            <button class="btn button-primary button--contact" type="submit">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-10 col-lg-4 text-left">
                <div class="inset-lg-left-30">
                    @if (isset($dataManagerPage['dataSocialNetworkContactUsHtml']))
                        <h6 class="font-weight-bold">Redes Sociales</h6>
                        <div class="hr bg-gray-light offset-top-10"></div>
                        {!! $dataManagerPage['dataSocialNetworkContactUsHtml'] !!}
                    @endif
                    @if (isset($dataBusiness) && $dataBusiness)
                        <div class="offset-top-30 offset-md-top-60">
                            <h6 class="font-weight-bold text-color--two">Teléfonos Institucionales</h6>
                            <div>
                                <div class="hr bg-gray-light offset-top-10"></div>
                            </div>
                            <div class="offset-top-15">
                                <ul class="list list-unstyled">
                                    <li><span class="icon icon-xs text-madison text-madison--contact mdi mdi-phone text-middle"></span><a
                                            class="text-middle inset-left-10 text-dark"
                                            href="tel:+{{$dataBusiness->phone_code }}{{ $dataBusiness->phone_value }}">+{{$dataBusiness->phone_code }}{{ $dataBusiness->phone_value }}</a></li>

                                </ul>
                            </div>
                        </div>

                    <div class="offset-top-30 offset-md-top-60">
                        <h6 class="font-weight-bold text-color--two">E-mail</h6>
                        <div>
                            <div class="hr bg-gray-light offset-top-10"></div>
                        </div>
                        <div class="offset-top-15">
                            <ul class="list list-unstyled">
                                <li><span class="icon icon-xs text-madison text-madison--contact mdi mdi-email-outline text-middle"></span><a
                                        class="text-primary text-middle inset-left-10"
                                        href="mailto:{{ $dataBusiness->email }}">{{ $dataBusiness->email }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="offset-top-30 offset-md-top-60">
                        <h6 class="font-weight-bold text-color--two">Dirección</h6>
                        <div>
                            <div class="hr bg-gray-light offset-top-10"></div>
                        </div>
                        <div class="offset-top-15">
                            <div class="unit flex-row unit-spacing-xs">
                                <div class="unit-left"><span
                                        class="icon icon-xs mdi mdi-map-marker text-madison text-madison--contact"></span></div>
                                <div class="unit-body">
                                    <p><a class="text-dark" >{{ $dataBusiness->street_1 }} y {{ $dataBusiness->street_2 }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="offset-top-30 offset-md-top-65">
                        <h6 class="font-weight-bold text-color--two">Horario de Atención</h6>
                        <div>
                            <div class="hr bg-gray-light offset-top-10"></div>
                        </div>
                        <div class="offset-top-15">
                            <div class="unit flex-row unit-spacing-xs">
                                <div class="unit-left"><span
                                        class="icon icon-xs mdi mdi-calendar-clock text-madison text-madison--contact"></span></div>
                                <div class="unit-body">
                                    <div>
                                        <p>Lunes-Viernes : 8:00am-14:00pm</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
