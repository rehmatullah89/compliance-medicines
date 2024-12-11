@if( (Request::has('report_type') && request()->get('report_type') != "" && request()->get('number_of_days') != "")  )

                        <div class="row mt-7_ mb-7_" style="margin-top: -10px;">
                            <div class="col-sm-12">
                                <div class="elm-left c-mr-4_ fs-17-force-child_" style="line-height: 24px; margin-top:10px; display: inline-block;"> <span class="txt-blue weight_600 tt_uc_" id="heading_toggle">{{ucfirst(str_replace ("_", " ", $report_title))}}</span></div>
                                <div class="elm-right" id="download_icon">
                                    <!-- button class="btn bg-blue-txt-wht weight_600 fs-14_" data-toggle="modal" data-target="#practice-Add-Modal" style="line-height: 20px; padding: .1rem .75rem;">+ Add</button-->
                                    @if($result and !isset($web_statis) and (request()->get('report_type')=='rx_refill_due_and_remaining' or request()->get('report_type')=='top_products_sale' or request()->get('report_type') =='product_profitablity') or request()->get('report_type') =='all_cwp_activity' or request()->get('report_type')=='most_referrals' or request()->get('report_type')=='all_users' or request()->get('report_type')=='patient_out_pocket' or request()->get('report_type')=='zero_refill_remaining' or request()->get('report_type')=='rx_near_expiration')
                                        <form action="{{ url('report/generate') }}" method="post" style="float:right">
                                            {{ csrf_field()  }}
                                            <input type="hidden" name="report_type" value="{{ request()->get('report_type') }}" />
                                            <input type="hidden" name="number_of_days" value="{{ request()->get('number_of_days') }}" />
                                            <input type="hidden" name="order_by" />
                                            <input type="hidden" name="type" />
                                            <input type="hidden" name="export_by" value="pdf" />
                                            <!--<button type="button" disabled="" class="btn clean_"><span class="fa fa-print txt-blue fs-24_"></span></button>-->
                                            <button title="Export this report detail in PDF" type="submit"  class="btn clean_"><span class="fa fa-arrow-circle-o-down txt-blue fs-24_"></span></button>
                                        </form>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="row pr-14_ pl-14_" id="report_table_data">
                            <div class="col-sm-12 mb-7_ pb-7_ pl-0 pr-0 table-responsive">
                                <table class="table reports-bordered compliance-user-table aa-client-dashboard-bld-table19mar-l99 @if(count($result)==0) {{'empty-table'}} @endif" style="min-width: 700px;">
                                    <thead>
                                        <tr>
                                           @if($tab_title)
                                            @foreach($tab_title as $keyTab=>$valTab)
                                            @php
                                            $style = '';
                                            $class = '';
                                            if(is_array($valTab)){
                                                if(isset($valTab['style'])) { $style = $valTab['style']; }
                                                if(isset($valTab['class'])) { $class = $valTab['class']; }
                                                $valTab = $valTab['title'];
                                            }
                                            @endphp
                                            <th style="{{ $style }}" class="{{ $class }}">{{ $valTab }}</th>
                                             @endforeach
                                           @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($result)
                                        @foreach($result as $keyRes=>$valRes)
                                         <tr class="L122">
                                             @php
                                             $keys = [];
                                             $keys = array_keys($valRes);
                                             @endphp

                                             @for($i=0; $i < count($keys); $i++)
                                             <td class="L129 {{$keys[$i]}}@if(isset($col_style[$i])) {{ $col_style[$i] }} @else {{ 'bg-tb-blue-lt txt-blue' }} @endif">{{ $valRes[$keys[$i]] }}</td>
                                             @endfor
                                         </tr>
                                         @endforeach

                                         @else                                    <script>
                                       var no_data = true;
                                        </script>

                                         <tr>
                                             <td id="main_report_noData" style="text-align: center;" colspan="{{ $count_field }}">No Record Found</td>
                                         </tr>
                                         @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                        