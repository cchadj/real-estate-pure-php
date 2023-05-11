<?php
/**
* @var string $label
* @var string $selectId
* @var string $name
* @var array<string, string> $options
* @var ?string $containerClass
* @var ?string $selectedValue
*/
$selectedValue = $selectedValue ?? null;
?>

<div class="<?= $containerClass ?? ""?>">
    <label for="<?= $selectId?>"><?= $label ?></label>
    <select name="<?= $name?>" id="<?= $selectId?>" >
        <?php foreach ($options as $optionValue => $optionDisplay): ?>
            <option
                value="<?= $optionValue?>"
                <?=($selectedValue and $optionValue === $selectedValue)? "selected" : ""?>
            >
                <?= $optionDisplay ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
