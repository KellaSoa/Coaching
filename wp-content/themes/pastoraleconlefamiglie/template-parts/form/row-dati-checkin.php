<div class="row row_dati_checkin">
    <div class="col-sm-12 text-center text-dark mb-5">
        <p>Per velocizzare la procedura di check-in al tuo arrivo e adempiere alle ottemperanze di legge in tema di accoglienza, abbiamo bisogno dei seguenti dati aggiuntivi:</p>
    </div>
    <div class="col-md-6 col-bg-man">
        <div class="col-cnt">
            <h6 class="mb-4">Dati di Lui</h6>
            <div class="form-group">
                <label for="birthdate1">Data di nascita*</label>
                <input type="text" class="form-control birth" id="birthdate1" name="person[0][birthdate]" placeholder="gg/mm/aaaa">

            </div>
            <div class="form-group">
                <label for="comune1">Comune di nascita*</label>
                <input type="text" class="form-control" id="comune1" name="person[0][comune]" placeholder="Comune di nascita">
            </div>
            <div class="form-group">
                <label for="citta1">Provincia di residenza*</label>
                <select class="form-control" id="citta1"  name="person[0][citta]">
                    <?php get_template_part("template-parts/form/option-select-province");?>
                </select>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-bg-woman">
        <div class="col-cnt">
            <h6 class="mb-4">Dati di Lei</h6>
            <div class="form-group">
                <label for="birthdate2">Data di nascita*</label>
                <input type="text" class="form-control birth" id="birthdate2" name="person[1][birthdate]" placeholder="gg/mm/aaaa">
            </div>
            <div class="form-group">
                <label for="comune2">Comune di nascita*</label>
                <input type="text" class="form-control" id="comune2" name="person[1][comune]" placeholder=" Comune di nascita">
            </div>
            <div class="form-group">
                <label for="citta2">Provincia di residenza*</label>
                <select class="form-control" id="citta2"  name="person[1][citta]">
                    <?php get_template_part("template-parts/form/option-select-province");?>
                </select>
            </div>

        </div>
    </div>
    <div class="col-sm-12">
        <small>* Campi obbligatori</small>
    </div>
</div>
