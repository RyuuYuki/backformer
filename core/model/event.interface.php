<?php

interface Events {
    protected function before_send_mail($field);
    protected function after_send_mail($field);
}