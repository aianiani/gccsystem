<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['url']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['url']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="text-align: center;">
                <tr>
                    <td align="center">
                        <a href="<?php echo new \Illuminate\Support\EncodedHtmlString($url); ?>"
                           style="display: inline-block;
                                  padding: 12px 28px;
                                  border-radius: 999px;
                                  background-color: #2d5016;
                                  color: #ffffff !important;
                                  font-weight: 600;
                                  font-size: 14px;
                                  text-decoration: none;">
                            <?php echo new \Illuminate\Support\EncodedHtmlString($slot); ?>

                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/vendor/mail/html/button.blade.php ENDPATH**/ ?>