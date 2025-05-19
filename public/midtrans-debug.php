<?php
// Debug endpoint untuk cek apakah webhook Midtrans benar-benar sampai ke server
file_put_contents(__DIR__.'/../../storage/logs/midtrans_debug.log', date('c')."\n".file_get_contents('php://input')."\n\n", FILE_APPEND);
echo 'OK';
