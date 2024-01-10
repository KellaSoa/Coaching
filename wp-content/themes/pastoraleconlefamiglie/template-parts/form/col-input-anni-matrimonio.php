<?php
$limite_anni_di_matrimonio = get_field("limite_anni_di_matrimonio", $_GET['idCourse']);
$stopYearsMarriage = 51;
if(!empty($limite_anni_di_matrimonio)) $stopYearsMarriage = $limite_anni_di_matrimonio+1;
?>
<div class="col-md-6">
    <div class="form-group">
        <label for="yearsMarriage">ANNI DI MATRIMONIO*</label>
        <?php if(!empty($limite_anni_di_matrimonio)):?>
        <small>Il corso è riservato a coppie fino a <?php echo $limite_anni_di_matrimonio;?> anni di matrimonio.</small>
        <?php endif;?>
        <select name="yearsMarriage" id="yearsMarriage" class="form-select" required>
            <option value="" selected>Seleziona un valore</option>
            <?php for($i=1;$i<$stopYearsMarriage;$i++){?>
                <option value="<?php echo $i;?>"><?php echo $i;?></option>
            <?php }?>
        </select>
    </div>
</div>