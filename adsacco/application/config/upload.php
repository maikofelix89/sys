<?php

$config['upload_path']   = DOCROOT.'images/profilepics/';

$config['file_name']     = date('Ymd',time()).random_string('alnum',6);

$config['allowed_types'] = 'gif|jpg|png';

$config['max_size']	     = '2000000';

$config['max_width']     = '10048';

$config['max_height']    = '10048';