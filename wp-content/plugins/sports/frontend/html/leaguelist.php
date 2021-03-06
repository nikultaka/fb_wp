<style>
.sportbut {
  --border: 5px;    /* the border width */
  --slant: 0.7em;   /* control the slanted corners */
  --color: #195d10 ; /* the color */
  
 
  font-size: x-large;
  padding: 0.4em 1.2em;
  border: 3px solid;
  cursor: pointer;
  font-weight: bold;

  color: var(--color);
  background: 
     linear-gradient(to bottom left,var(--color)  50%,#0000 50.1%) top right,
     linear-gradient(to top   right,var(--color)  50%,#0000 50.1%) bottom left;
  background-size: calc(var(--slant) + 1.3*var(--border)) calc(var(--slant) + 1.3*var(--border));
  background-repeat: no-repeat;
  box-shadow:
    0 0 0 200px inset var(--s,#0000),
    0 0 0 var(--border) inset var(--color);
  clip-path: 
      polygon(0 0, calc(100% - var(--slant)) 0, 100% var(--slant),
              100% 100%, var(--slant) 100%,0 calc(100% - var(--slant))
             );
  transition: color var(--t,0.3s), background-size 0.3s;
}
.sportbut:hover,
.sportbut:active{
  background-size: 100% 100%;
  color: #fff;
  --t: 0.2s 0.1s;
}
.sportbut:focus-visible {
  outline-offset: calc(-1*var(--border));
  outline: var(--border) solid #000a;
}
.sportbut:active {
  --s: #0005;
  transition: none;
}
.sportbut .body {
  display:grid;
  grid-auto-flow:column;
  grid-gap:20px;
  place-content:center;
  margin:0;
  height:100vh;
}

.loaderball {
		position: fixed;
		opacity: 1;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background: url('../wp-content/plugins/sports/images/6.gif')50% 50% no-repeat rgb(255 255 255 / 65%);
	}
</style>
<span><a  onclick="history.back()" class="title btn" style="background-color: #ffcc00; color: #24890d; font-size: 25px; margin-top: -4%;  float : left; font-family: Oswald; "><b>Go Back</b></a></span>
</br></br></br>

<div id="loaderball" class="loaderball" style="display: none;"></div>
<div class="row d-grid gap-3">
    <div id="leaguelistdata" >
    </div>
</div>


<script type="text/javascript">
    var $ = jQuery;
    var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
    $(document).ready(function() {
        league_list(<?php echo $_GET['id'] ?>);
    })
</script>