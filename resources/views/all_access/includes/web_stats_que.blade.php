@if(isset($web_statis) )
                      
        <div class="row mt-7_ mb-7_">
            <div class="col-sm-12">
                <div class="elm-left c-mr-4_ fs-17-force-child_" style="line-height: 24px; margin-top: 10px; display: inline-block;"> <span id="web_stat_heading" class="txt-blue weight_600 tt_uc_">{{ucfirst(str_replace ("_", " ", $report_title))}}</span></div>
                <div class="elm-right" id="stat_icons">
                    <!-- button class="btn bg-blue-txt-wht weight_600 fs-14_" data-toggle="modal" data-target="#practice-Add-Modal" style="line-height: 20px; padding: .1rem .75rem;">+ Add</button-->
                    <!-- <button type="button" disabled="" class="btn clean_"><span class="fa fa-print txt-blue fs-24_"></span></button>
                    <button type="button" disabled="" class="btn clean_"><span class="fa fa-arrow-circle-o-down txt-blue fs-24_"></span></button> -->
                     @if($result and isset($web_statis) and (request()->get('web_stat')=='referrals_generated' or request()->get('web_stat')=='completed_enrollments' or  request()->get('web_stat') == 'refill_reminders' or request()->get('web_stat') == 'payments_made') or request()->get('web_stat')=='member_questions' or request()->get('web_stat')=='refill_requests')
                                        <form action="{{ url('report/generate') }}" method="post" style="float:right">
                                            {{ csrf_field()  }}
                                            <input type="hidden" name="web_stat" value="{{ request()->get('web_stat') }}" />
                                            <input type="hidden" name="duration" value="{{ request()->get('duration') }}" />
                                            <input type="hidden" name="order_by" />
                                            <input type="hidden" name="type" />
                                            <input type="hidden" name="export_by" value="pdf" />
                                            <!--<button type="button" disabled="" class="btn clean_"><span class="fa fa-print txt-blue fs-24_"></span></button>-->
                                            <button title="Export this report detail in PDF" type="submit"  class="btn clean_" ><span class="fa fa-arrow-circle-o-down txt-blue fs-24_"></span></button>
                                        </form>
                                    @endif
                </div>
            </div>
        </div>
        <div class="row pr-14_ pl-14_" id="web_stat_report">
            <div class="col-sm-12 pl-0 pr-0 table-responsive">
                <table class="table reports-bordered compliance-user-table aa-client-dashboard-bld-table19mar-l199 @if(count($result)==0) {{'empty-table'}} @endif" style="min-width: 700px;">
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
                        @php $keys = []; @endphp
                        @foreach($result as $keyRes=>$valRes)
                         <tr>
                             @php
                             $keys = array_keys($valRes);
                             @endphp

                             @for($i=0; $i < count($keys); $i++)
                             <td class="{{$keys[$i]}}@if(isset($col_style[$i])) {{ $col_style[$i] }} @else {{ 'bg-tb-blue-lt txt-blue' }} @endif">{{ $valRes[$keys[$i]] }}</td>
                             @endfor
                         </tr>
                         @endforeach

                         @else
                         <script>
                        var no_data = true;
                        </script>
                         <tr>
                             <td id="web_stats_noData" style="text-align: center;" colspan="{{ $count_field }}">No Record Found</td>
                         </tr>
                         @endif
                    </tbody>
                    @if(isset($keys))
                    <tfoot>
                            <tr>
                            @for($i=0; $i < count($keys); $i++)
                                <th style="text-align: <?=($i==2 || $i==3 )?'right':'center';?>; font-weight:bold;"></th>
                             @endfor
                            </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
        @endif