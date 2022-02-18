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

  



    .containerFFG {
        display: grid;
        place-items: center;
        width: 200px;
       
        margin: auto;
        background: linear-gradient(50deg, lightblue, Teal);
        position: relative;
        border-radius: 5%;
        overflow: hidden;
        padding: 3px;
    }

    .containerFFG::before {
        content: '';
        background: linear-gradient(45deg, yellow, Aqua);
        width: 400px;
        height: 20px;
        position: absolute;
        transform: rotate(-52deg) translate(0, -180px);
    }

    .cardFFG {
        display: grid;
        place-items: center;
        width: 100%;        
        border-radius: 5%;
        background-color: #6EC1E4;
        color: #7A7A7A;
        position: relative;
    }

    .txtFFG {
        display: flex;
        flex-direction: column;
        text-align: center;
        transition: color 1s ease;
    }

    .PFFG::before {
        content: "";
        display: inline-block;
        width: 98%;
        height: 2px;
        background: linear-gradient(45deg, lightblue, Aqua);
        transform: scaleX(0);
        transition: transform 1s ease;
    }

    .containerFFG:hover::before {
        animation: effetto 3s infinite;
    }

    .containerFFG:hover .txtFFG .PFFG::before {
        transform: scaleX(1);
    }

    .containerFFG:hover .cardFFG {
        color: #fff;
    }

    @keyframes effetto {
        50% {
            transform: rotate(-52deg) translate(0, 180px)
        }
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