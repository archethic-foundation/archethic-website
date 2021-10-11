<?php
$attrs = empty($trx_shortcode_args['attrs']) ? array() : $trx_shortcode_args['attrs'];
$args = empty($trx_shortcode_args['args']) ? array() : $trx_shortcode_args['args'];
$show_additional_fields = (isset($trx_shortcode_args['show_additional_fields']) && $trx_shortcode_args['show_additional_fields'] == false) ? false : true;
$type = $args['id'];
?>
<div class="control-box">
    <fieldset>
        <?php if (!empty($trx_shortcode_args['description'])):?>
            <legend><?php echo sprintf( esc_html( $trx_shortcode_args['description'] ), $trx_shortcode_args['desc_link']); ?></legend>
        <?php endif;?>

        <table class="form-table">
            <tbody>
            <?php foreach ($attrs as $key => $attr): ?>
                <?php
                switch ($attr['type']) {
                    case 'select' :
                        ?>
                        <tr>
                            <th scope="row"><?php echo $attr['label']; ?></th>
                            <td>
                                <fieldset>
                                    <legend class="screen-reader-text"><?php echo $attr['label']; ?></legend>
                                    <label>
                                        <?php foreach ($attr['options'] as $option_value => $option_text): ?>
                                            <label>
                                                <input type="radio"
                                                       name="<?php echo $key; ?>"
                                                       value="<?php echo $option_value; ?>"
                                                       class="<?php echo !empty($attr['class']) ? $attr['class'] : 'option'; ?>"
                                                        <?php checked( $attr['default'], $option_value ); ?> >
                                                <?php echo $option_text; ?>
                                            </label>

                                        <?php endforeach; ?>
                                    </label>
                                </fieldset>
                            </td>
                        </tr>
                        <?php
                        break;
                    case 'text' :
                        ?>
                        <tr>
                            <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-' . $key ); ?>"><?php echo $attr['label']; ?></label></th>
                            <td><input type="text"
                                        name="<?php echo $key; ?>"
                                        class="<?php echo !empty($attr['class']) ? $attr['class'] : 'oneline'; ?>"
                                        id="<?php echo esc_attr( $args['content'] . '-values' ); ?>"
                                        value="<?php echo $attr['default'];?>" >
                            </td>
                        </tr>
                        <?php
                        break;
                }
                ?>
            <?php endforeach; ?>
            <?php if ($show_additional_fields) : ?>
                <tr>
                    <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-id' ); ?>"><?php esc_html_e('Id attribute', 'trx-contact-form-7-multi-step-addon'); ?></label></th>
                    <td><input type="text" name="id" class="idvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-id' ); ?>" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-class' ); ?>"><?php esc_html_e('Class attribute', 'trx-contact-form-7-multi-step-addon'); ?></label></th>
                    <td><input type="text" name="class" class="classvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-class' ); ?>" /></td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </fieldset>
</div>
<div class="insert-box">
    <input type="text" name="<?php echo $type; ?>" class="tag code" readonly="readonly" onfocus="this.select()" />
    <div class="submitbox">
        <input type="button" class="button button-primary insert-tag" value="<?php esc_attr_e('Insert Tag', 'trx-contact-form-7-multi-step-addon'); ?>" />
    </div>
    <br class="clear" />
</div>
