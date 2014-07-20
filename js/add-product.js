/**
 * Created by JetBrains PhpStorm.
 * User: Lison Allen
 * Date: 11-10-17
 * Time: 下午8:19
 * To change this template use File | Settings | File Templates.
 */

function addCnProductSpec( item_list ) {
    var num = item_list.length,
        seq = String.fromCharCode( 65 + num );

    $( '\
                                    <tr class="product-spec-item-cn">\
                                        <td>' + seq + '</td>\
                                        <td class="spec no"><input type="text" name="spec-no-cn-' + num + '" maxlength="9" /></td>\
                                        <td class="spec size"><input type="text" name="spec-size-cn-' + num + '" maxlength="19" /></td>\
                                        <td class="spec min"><input type="text" name="spec-min-cn-' + num + '" maxlength="4" /></td>\
                                    </tr>' ).insertAfter( item_list[num - 1] );
}

function addEnProductSpec( item_list ) {
    var num = item_list.length,
        seq = String.fromCharCode( 65 + num );

    $( '\
                                    <tr class="product-spec-item-en">\
                                        <td>' + seq + '</td>\
                                        <td class="spec no"><input type="text" name="spec-no-en-' + num + '" maxlength="9" /></td>\
                                        <td class="spec size"><input type="text" name="spec-size-en-' + num + '" maxlength="19" /></td>\
                                        <td class="spec min"><input type="text" name="spec-min-en-' + num + '" maxlength="4" /></td>\
                                    </tr>' ).insertAfter( item_list[num - 1] );
}

function addProductSpec( item_list ) {
    var num = item_list.length,
        seq = String.fromCharCode( 65 + num );

    $( '\
                                    <tr class="product-spec-item">\
                                        <td>' + seq + '</td>\
                                        <td class="spec no"><input type="text" name="spec-no-en-' + num + '" maxlength="9" /></td>\
                                        <td class="spec size"><input type="text" name="spec-size-en-' + num + '" maxlength="19" /></td>\
                                        <td class="spec min"><input type="text" name="spec-min-en-' + num + '" maxlength="4" /></td>\
                                    </tr>' ).insertAfter( item_list[num - 1] );
}

function clearProductSpec( item_list ) {

    for( var index = 1, len = item_list.length; index < len; index++ ) {
        $( item_list[index] ).remove();
    }
    
    $( 'input[name="spec-no-0"]' ).val( '' );
    $( 'input[name="spec-size-0"]' ).val( '' );
    $( 'input[name="spec-min-0"]' ).val( '' );
}