<style>

.third {
  border-color: blue;
  color: #fff;
  box-shadow: 0 0 40px 40px blue inset, 0 0 0 0 blue;
  transition: all 150ms ease-in-out;
}
  .third:hover {
    box-shadow: 0 0 10px 0 blue inset, 0 0 10px 4px blue;
  }

</style>


<!-- <section id="fancyTabWidget" class="tabs t-tabs">
        <ul class="nav nav-tabs fancyTabs" role="tablist">
            <li class="tab fancyTab">
                <div class="arrow-down">
                    <div class="arrow-down-inner"></div>
                </div>
                <a id="tab0" href="#tabBody0" role="tab" aria-controls="tabBody0" aria-selected="true" data-toggle="tab" tabindex="0"><span class="fa fa-desktop"></span><span class="hidden-xs">Connect</span></a>
                <div class="whiteBlock"></div>
            </li>
        </ul>
        <div id="myTabContent" class="tab-content fancyTabContent" aria-live="polite">
            <div class="tab-pane  fade active in" id="tabBody0" role="tabpanel" aria-labelledby="tab0" aria-hidden="false" tabindex="0">
                <div>
                    <div class="row">
                        <div class="col-md-12">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->




<div class="row d-grid gap-3">
    <div id="liveleaderboardlist">
    </div>
</div>

<div class="row d-grid gap-3">
    <div id="liveleaderboardpoints">
    </div>
</div>


<script type="text/javascript">
    var $ = jQuery;
    var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
    $(document).ready(function() {
        live_leaderboard_list();
    })
</script>

