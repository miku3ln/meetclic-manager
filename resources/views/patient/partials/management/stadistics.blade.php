<div class="m-portlet">
    <div class="m-portlet__body  m-portlet__body--no-padding">
        <div class="row m-row--no-padding m-row--col-separator-xl">
            <div class="col-xl-4">
                <!--begin:: Widgets/Stats2-1 -->
                <div class="m-widget1">
                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Tratamientos</h3>
                                <span class="m-widget1__desc">Realizados en este mes</span>
                            </div>
                            <div class="col m--align-right">
                                <span class="m-widget1__number m--font-brand">+$17,800</span>
                            </div>
                        </div>
                    </div>
                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Tratamientos</h3>
                                <span class="m-widget1__desc">Terminados</span>
                            </div>
                            <div class="col m--align-right">
                                <span class="m-widget1__number m--font-danger">+1,800</span>
                            </div>
                        </div>
                    </div>
                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Tratamientos</h3>
                                <span class="m-widget1__desc">Anulados</span>
                            </div>
                            <div class="col m--align-right">
                                <span class="m-widget1__number m--font-success">-27,49%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end:: Widgets/Stats2-1 -->            </div>
            <div class="col-xl-4">
                <!--begin:: Widgets/Daily Sales-->
                <div class="m-widget14">
                    <div class="m-widget14__header m--margin-bottom-30">
                        <h3 class="m-widget14__title">
                            Pagos Tratamientos
                        </h3>
                        <span class="m-widget14__desc">
		Check out each collumn for more details
		</span>
                    </div>
                    <div class="m-widget14__chart" style="height:120px;">
                        <div class="chartjs-size-monitor"
                             style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                            <div class="chartjs-size-monitor-expand"
                                 style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink"
                                 style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                            </div>
                        </div>
                        <canvas id="m_chart_daily_sales" width="311" height="120" class="chartjs-render-monitor"
                                style="display: block; width: 311px; height: 120px;"></canvas>
                    </div>
                </div>
                <!--end:: Widgets/Daily Sales-->            </div>
            <div class="col-xl-4">
                <!--begin:: Widgets/Profit Share-->
                <div class="m-widget14">
                    <div class="m-widget14__header">
                        <h3 class="m-widget14__title">
                          Tratamientos
                        </h3>
                        <span class="m-widget14__desc">
Gestionados para el paciente.
		</span>
                    </div>
                    <div class="row  align-items-center">
                        <div class="col">
                            <div id="m_chart_profit_share" class="m-widget14__chart" style="height: 160px">
                                <div class="m-widget14__stat">45</div>
                                <svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%"
                                     class="ct-chart-donut" style="width: 100%; height: 100%;">
                                    <g class="ct-series custom">
                                        <path d="M122.15,104.286A57.039,57.039,0,0,0,70.539,22.961"
                                              class="ct-slice-donut" ct:value="32"
                                              ct:meta="{&amp;quot;data&amp;quot;:{&amp;quot;color&amp;quot;:&amp;quot;#716aca&amp;quot;}}"
                                              style="stroke-width: 17px;"
                                              stroke-dasharray="114.68540954589844px 114.68540954589844px"
                                              stroke-dashoffset="-114.68540954589844px" stroke="#716aca">
                                            <animate attributeName="stroke-dashoffset" id="anim0" dur="1000ms"
                                                     from="-114.68540954589844px" to="0px" fill="freeze"
                                                     stroke="#716aca" calcMode="spline" keySplines="0.23 1 0.32 1"
                                                     keyTimes="0;1"></animate>
                                        </path>
                                    </g>
                                    <g class="ct-series custom">
                                        <path d="M26.59,116.358A57.039,57.039,0,0,0,122.234,104.106"
                                              class="ct-slice-donut" ct:value="32"
                                              ct:meta="{&amp;quot;data&amp;quot;:{&amp;quot;color&amp;quot;:&amp;quot;#00c5dc&amp;quot;}}"
                                              style="stroke-width: 17px;"
                                              stroke-dasharray="114.88359069824219px 114.88359069824219px"
                                              stroke-dashoffset="-114.88359069824219px" stroke="#00c5dc">
                                            <animate attributeName="stroke-dashoffset" id="anim1" dur="1000ms"
                                                     from="-114.88359069824219px" to="0px" fill="freeze"
                                                     stroke="#00c5dc" begin="anim0.end" calcMode="spline"
                                                     keySplines="0.23 1 0.32 1" keyTimes="0;1"></animate>
                                        </path>
                                    </g>
                                    <g class="ct-series custom">
                                        <path d="M70.539,22.961A57.039,57.039,0,0,0,26.717,116.511"
                                              class="ct-slice-donut" ct:value="36"
                                              ct:meta="{&amp;quot;data&amp;quot;:{&amp;quot;color&amp;quot;:&amp;quot;#ffb822&amp;quot;}}"
                                              style="stroke-width: 17px;"
                                              stroke-dasharray="129.22027587890625px 129.22027587890625px"
                                              stroke-dashoffset="-129.22027587890625px" stroke="#ffb822">
                                            <animate attributeName="stroke-dashoffset" id="anim2" dur="1000ms"
                                                     from="-129.22027587890625px" to="0px" fill="freeze"
                                                     stroke="#ffb822" begin="anim1.end" calcMode="spline"
                                                     keySplines="0.23 1 0.32 1" keyTimes="0;1"></animate>
                                        </path>
                                    </g>
                                </svg>
                            </div>
                        </div>
                        <div class="col">
                            <div class="m-widget14__legends">
                                <div class="m-widget14__legend">
                                    <span class="m-widget14__legend-bullet m--bg-accent"></span>
                                    <span class="m-widget14__legend-text">37% Pagados</span>
                                </div>
                                <div class="m-widget14__legend">
                                    <span class="m-widget14__legend-bullet m--bg-warning"></span>
                                    <span class="m-widget14__legend-text">47% Terminados</span>
                                </div>
                                <div class="m-widget14__legend">
                                    <span class="m-widget14__legend-bullet m--bg-brand"></span>
                                    <span class="m-widget14__legend-text">19% Por Pagar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end:: Widgets/Profit Share-->            </div>
        </div>
    </div>
</div>