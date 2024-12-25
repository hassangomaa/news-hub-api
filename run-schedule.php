<?php

while (true) {
    exec('php artisan schedule:run');
    sleep(10);
}
