<div class="instr-item">
    <div class="item-step">
        <span><?php echo __('Step');?></span>
    </div>
    <div class="item-wrapper">
        <div class="title form-group">
            <input type="text" name="instructions[title][]" value="<?php echo !empty($instruction[0]) ? $instruction[0] : ''; ?>"/>
        </div>
        <div class="description">
            <?php

                wp_editor(
                    (!empty($instruction[1]) ? $instruction[1] : ''),
                    "instruction{$i}",
                    array( 'textarea_rows' => '5', 'textarea_name' => "instructions[description][]",'media_buttons' => false )
                );
            ?>
        </div>
    </div>
    <div class="close instr-remove"></div>
</div>
