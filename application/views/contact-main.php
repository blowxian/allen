
            <div class="contact-list">

                <?php for( $index = 0, $len = count( $contact ); $index < $len; $index++ ) { ?>

                <div class="contact">

                    <div class="thead"><?php echo $contact[$index]['contact_city']; ?></div>
                    <table>
                        <tbody>
                            <tr></tr>
                            <tr>
                                <th><?php echo $addr; ?>:</th>
                                <td><?php echo $contact[$index]['contact_addr']; ?></td>
                            </tr>
                            <?php if( $contact[$index]['contact_post'] != '' ) { ?>
                            <tr>
                                <th><?php echo $post; ?>:</th>
                                <td><?php echo $contact[$index]['contact_post']; ?></td>
                            </tr>
                            <?php } ?>
                            <?php if( $contact[$index]['contact_tel'] != '' ) { ?>
                            <tr>
                                <th><?php echo $tel; ?>:</th>
                                <?php
                                $pieces = preg_split( '/,/', $contact[$index]['contact_tel']);
                                for( $index_b = 0, $len_b = count( $pieces ); $index_b < $len_b; $index_b++ ) {
                                    if( $index_b != 0 ) {
                                ?>
                            </tr>
                            <tr>
                                <th></th>
                                <?php } ?>
                                <td><?php echo $pieces[$index_b]; ?></td>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                            <?php if( $contact[$index]['contact_mobile'] != '' ) { ?>
                            <tr>
                                <th><?php echo $mobile; ?>:</th>
                                <?php
                                $pieces = preg_split( '/,/', $contact[$index]['contact_mobile']);
                                for( $index_b = 0, $len_b = count( $pieces ); $index_b < $len_b; $index_b++ ) {
                                    if( $index_b != 0 ) {
                                ?>
                            </tr>
                            <tr>
                                <th></th>
                                <?php } ?>
                                <td><?php echo $pieces[$index_b]; ?></td>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                            <?php if( $contact[$index]['contact_fax'] != '' ) { ?>
                            <tr>
                                <th><?php echo $fax; ?>:</th>
                                <?php
                                $pieces = preg_split( '/,/', $contact[$index]['contact_fax']);
                                for( $index_b = 0, $len_b = count( $pieces ); $index_b < $len_b; $index_b++ ) {
                                    if( $index_b != 0 ) {
                                ?>
                            </tr>
                            <tr>
                                <th></th>
                                <?php } ?>
                                <td><?php echo $pieces[$index_b]; ?></td>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                            <?php if( $contact[$index]['contact_email'] != '' ) { ?>
                            <tr>
                                <th><?php echo $email; ?>:</th>
                                <?php
                                $pieces = preg_split( '/,/', $contact[$index]['contact_email']);
                                for( $index_b = 0, $len_b = count( $pieces ); $index_b < $len_b; $index_b++ ) {
                                    if( $index_b != 0 ) {
                                ?>
                            </tr>
                            <tr>
                                <th></th>
                                <?php } ?>
                                <td><?php echo $pieces[$index_b]; ?></td>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                            <?php if( $contact[$index]['contact_site'] != '' ) { ?>
                            <tr>
                                <th><?php echo $site; ?>:</th>
                                <?php
                                $pieces = preg_split( '/,/', $contact[$index]['contact_site']);
                                for( $index_b = 0, $len_b = count( $pieces ); $index_b < $len_b; $index_b++ ) {
                                    if( $index_b != 0 ) {
                                ?>
                            </tr>
                            <tr>
                                <th></th>
                                <?php } ?>
                                <td><?php echo $pieces[$index_b]; ?></td>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <?php } ?>

            </div>

        </div>
        
    </div>