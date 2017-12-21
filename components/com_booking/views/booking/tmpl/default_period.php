<h3>Wich period</h3>
<select id="period">
<?php foreach ($this->periods as $period) : ?>
    <option value="<?php echo $period->id ?>"><?php echo $period->name ?>&nbsp;-&nbsp;<?php echo $period->hour ?></option>
<?php endforeach; ?>
</select>
<a href="#" id="period-save">Next</a>