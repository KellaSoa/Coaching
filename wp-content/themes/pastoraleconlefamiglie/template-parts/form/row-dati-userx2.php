
<div class="row">
    <div class="col-md-6 col-bg-man">
        <div class="col-cnt">
            <h6 class="mb-3">Dati di Lui</h6>
            <div class="form-group">
                <label for="firstName1">NOME*</label>
                <input type="text" class="form-control" id="firstName1" name="person[0][firstName]" placeholder="Nome" required />
            </div>
            <div class="form-group">
                <label for="lastName1">COGNOME*</label>
                <input type="text" class="form-control" id="lastName1" name="person[0][lastName]" placeholder="Cognome" required />
            </div>
            <div class="form-group">
                <label for="email1">EMAIL*</label>
                <input type="email" class="form-control" id="email1" name="person[0][email]" placeholder="Email" required/>
            </div>
            <div class="form-group">
                <label for="phone1">TELEFONO*</label>
                <input type="tel" class="form-control" id="phone1" name="person[0][phone]" placeholder="+00 000 000 00" required/>
            </div>
            <input type="hidden" name="person[0][gender]" value="M">

            <div class="form-group mt-4">
                <div class="cnt-input my-2">
                    <input type="radio" name="referente" id="referente1" value="1" required/>
                    <label for="referente1" class="d-inline-block">Referente Iscrizione**</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-bg-woman">
        <div class="col-cnt">
            <h6 class="mb-3">Dati di Lei</h6>
            <div class="form-group">
                <label for="firstName2">NOME*</label>
                <input type="text" class="form-control" id="firstName2" name="person[1][firstName]" placeholder="Nome" required/>
            </div>
            <div class="form-group">
                <label for="lastName2">COGNOME*</label>
                <input type="text" class="form-control" id="lastName2" name="person[1][lastName]" placeholder="Cognome" required/>
            </div>
            <div class="form-group">
                <label for="email2">EMAIL*</label>
                <input type="email" class="form-control" id="email2" name="person[1][email]" placeholder="Email" required/>
            </div>
            <div class="form-group">
                <label for="phone2">TELEFONO*</label>
                <input type="tel" class="form-control" id="phone2" name="person[1][phone]" placeholder="+00 000 000 00" required/>
            </div>
            <input type="hidden" name="person[1][gender]" value="F">
            <div class="form-group mt-4">
                <div class="cnt-input my-2">
                    <input type="radio" name="referente" id="referente2" value="2" required/>
                    <label for="referente2" class="d-inline-block">Referente Iscrizione**</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <small class="d-inline-block">** Il referente riceverà tutte le comunicazioni relative all'iscrizione al corso, compresa la mail con le indicazioni per il pagamento.</small>
    </div>
</div>
