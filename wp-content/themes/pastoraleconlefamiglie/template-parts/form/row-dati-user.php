
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="firstName">NOME*</label>
            <input type="text" class="form-control" id="firstName" name="person[0][firstName]" placeholder="Nome" required />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="lastName">COGNOME*</label>
            <input type="text" class="form-control" id="lastName" name="person[0][lastName]" placeholder="Cognome" required />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="email">EMAIL*</label>
            <input type="email" class="form-control" id="email" name="person[0][email]" placeholder="Email" required/>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="regione">REGIONE di RESIDENZA*</label>

            <select name="person[0][regione]" id="regione" class="form-control" required>
                <option value="">Seleziona regione</option>
                <option value="Abruzzo">Abruzzo</option>
                <option value="Basilicata">Basilicata</option>
                <option value="Calabria">Calabria</option>
                <option value="Campania">Campania</option>
                <option value="Emilia-Romagna">Emilia-Romagna</option>
                <option value="Friuli-Venezia Giulia">Friuli-Venezia Giulia</option>
                <option value="Lazio">Lazio</option>
                <option value="Liguria">Liguria</option>
                <option value="Lombardia">Lombardia</option>
                <option value="Marche">Marche</option>
                <option value="Molise">Molise</option>
                <option value="Piemonte">Piemonte</option>
                <option value="Puglia">Puglia</option>
                <option value="Sardegna">Sardegna</option>
                <option value="Sicilia">Sicilia</option>
                <option value="Toscana">Toscana</option>
                <option value="Trentino-Alto Adige">Trentino-Alto Adige</option>
                <option value="Umbria">Umbria</option>
                <option value="Valle d'Aosta">Valle d'Aosta</option>
                <option value="Veneto">Veneto</option>
            </select>
        </div>
    </div>
    <input type="hidden" name="person[0][gender]" value="">
</div>