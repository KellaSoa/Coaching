<div class="row mt-3 pt-5 mb-5">
    <div class="col-md-4 mx-auto">
        <div class="form-group">
            <label for="numberSons">Quanti figli verranno con voi?</label>
            <select name="numberSons" id="numberSons" class="form-select">
                <option value="0" selected>Nessun figlio</option>
                <?php for($i=1;$i<10;$i++){?>
                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                <?php }?>
            </select>
        </div>
    </div>
</div>