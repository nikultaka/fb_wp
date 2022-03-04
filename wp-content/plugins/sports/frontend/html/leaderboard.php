<style>
    .container10FFG {
        display: flow-root;
        place-items: center;
        width: 100%;
        height: 80px;
        position: relative;
        overflow: hidden;
        padding: 9px;

    }

    .container10FFG::before {
        content: '';
        background: linear-gradient(45deg, #24890d, #58c333);
        width: 400px;
        height: 90px;
        position: absolute;
        transform: rotate(-45deg) translate(0, -200px);
    }

    .txt10FFG {
        display: flex;
        flex-direction: column;
        text-align: center;
        transition: color 1s ease;
    }

    .container10FFG:hover::before {
        animation: effetto 3s infinite;
    }

    .container10FFG:hover .txt10FFG {
        transform: scaleX(1);
    }

    .card1FFG {
        display: block;
        place-items: center;
        width: auto;
        height: 79px;
        background-color: #f2f2f2;
        position: relative;
        margin: -6px;
        padding: 17px;
    }

    .t1FFG {
        font-style: bold;
        font-family: Oswald;
        color: #0C2D48;
        font-weight: 400;
        line-height: 1;
        font-size: 38px;
        margin: 3px 0px -6px 0px;
    }











    .containerFFG {
        display: flow-root;
        place-items: center;
        width: 337px;
        height: 191px;
        margin: 8px;
        position: relative;
        overflow: hidden;
        padding: 9px;
    }

    .containerFFG::before {
        content: '';
        background: linear-gradient(45deg, yellow, red);
        width: 308px;
        height: 93px;
        position: absolute;
        transform: rotate(-45deg) translate(0, -200px);
    }

    .cardFFG {
        display: block;
        place-items: center;
        width: auto;
        height: 185px;
        background-color: #f2f2f2;
        position: relative;
        margin: -6px;
        padding: 17px;
    }

    .txtFFG {
        display: flex;
        flex-direction: column;
        text-align: center;
        transition: color 1s ease;
    }

    .tFFG h5 {
        font-style: normal;
        color: #0C2D48;
        font-weight: 400;
        line-height: 1;
        font-size: 22px;
        margin: 3px 0px -6px 0px;
    }

    .PFFG::before {
        content: "";
        display: inline-block;
        width: 282px;
        height: 1px;
        background: linear-gradient(45deg, yellow, red);
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

    .pointer {
        cursor: pointer;
    }

    @keyframes effetto {
        50% {
            transform: rotate(-52deg) translate(0, 180px)
        }
    }

    .container2FFG {
        display: flow-root;
        place-items: center;
        width: 100%;
        height: 85px;
        margin: 8px;
        position: relative;
        overflow: hidden;
        padding: 9px;
    }

    .container2FFG::before {
        content: '';
        background: linear-gradient(45deg, yellow, red);
        width: 308px;
        height: 93px;
        position: absolute;
        transform: rotate(-45deg) translate(0, -200px);
    }

    .card2FFG {
        display: block;
        place-items: center;
        width: auto;
        height: 79px;
        background-color: #f2f2f2;
        position: relative;
        margin: -6px;
        padding: 17px;
    }

    .container2FFG:hover::before {
        animation: effetto 3s infinite;
    }

    .container2FFG:hover .txtFFG .PFFG::before {
        transform: scaleX(1);
    }

    .container2FFG:hover .cardFFG {
        color: #fff;
    }

    .t2FFG h2 {
        font-style: normal;
        color: #0C2D48;
        font-weight: 400;
        line-height: 1;
        font-size: 35px;
        margin: 3px 0px -6px 0px;
    }
</style>


<div class="row d-grid gap-3">
    <div id="liveleaderboardlist">
    </div>
</div>

<div class="row d-grid gap-3">
    <div id="liveleaderboardpoints">
    </div>
</div></br></br></br></br></br>


<script type="text/javascript">
    var $ = jQuery;
    var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
    $(document).ready(function() {
        live_leaderboard_list();
    })
</script>