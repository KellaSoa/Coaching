<div class="col-md-6">
    <div class="form-group">
        <label for="yearsEngagement">ANNI DI FIDANZAMENTO</label>
        <select name="yearsEngagement" id="yearsEngagement" class="form-select">
            <option value="" selected>Seleziona un valore</option>
            <?php for($i=1;$i<21;$i++){?>
                <option value="<?php echo $i;?>"><?php echo $i;?></option>
            <?php }?>
        </select>
    </div>
</div>