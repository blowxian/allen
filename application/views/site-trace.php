
                <!-- site trace -->
                <div class="site-trace">

                    <?php for( $index = 0, $len = count( $trace ); $index < $len; $index++ ) { ?>
                    <a href="<?php echo $trace_link[$index] ?>"><span class="trace <?php if( $index == $len - 1 ) { echo 'last'; } ?>"><?php echo $trace[$index]; ?></span></a>
                    <?php } ?>
                    <div class="clear"></div>

                </div>