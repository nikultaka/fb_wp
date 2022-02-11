<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>




<div class="modal fade" tabindex="-1" role="dialog" data-backdrop="false" id="scorepredictormodal" aria-labelledby="scorepredictormodallabel" aria-hidden="true">
    <div class="modal-dialog model-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scorepredictormodallabel">Add Your Predicted Score</h5>
            </div>
            <form onsubmit="return false" method="POST" name="scorepredictorformdata" id="scorepredictorformdata">
                <div class="modal-body">
                    <input type="hidden" name="action" value="match_list_Controller::score_predictor_insert_data">
                    <input type="hidden" id="hdnsprmatchid" name="hdnsprmatchid">
                    <input type="hidden" id="hdnsprteamid" name="hdnsprteamid">
                    <input type="hidden" id="hspfid" name="hspfid">

                    <div class="row">
                        <div class="col-md-4">   
                            <label for="name">
                                <h3><b>Predict Your Score :</b></h3>
                            </label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" style="color: #2b2b2b;" class="form-control" id="scorepredictor" autocomplete="off" name="scorepredictor">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn" id="save_Btnscorepredictor" style="background-color: #24890d;" name="save_Btnscorepredictor">Save</button>
                    <button type="button" class="btn" style="background-color: #e0b404;" data-dismiss="modal" id="close_modal_btn2" name="close_modal_btn2">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    var $ = jQuery;
    var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
</script>