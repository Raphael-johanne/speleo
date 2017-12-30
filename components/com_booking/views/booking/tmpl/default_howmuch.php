<h3>How much people</h3>
<select id="howmuch">
    <?php for ($i = 1; $i <= $this->formule->max_person_allowed; $i++) : ?>
        <option value="<?php echo $i ?>"><?php echo $i ?></option>
    <?php endfor; ?>
</select>
<a href="#" id="howmuch-save">Next</a>
