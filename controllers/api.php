<?php

use Webcup\DreamMetaKey;
use Webcup\DreamMetaKeyService;
use Webcup\DreamMetaValue;
use Webcup\DreamMetaValueService;
use Webcup\DreamService;

if (count($_POST) > 0) {
    if (!isset($_SESSION['api'])) {
        $_SESSION['api'] = array();
    }

    if (isset($_POST['action']) && !empty($_POST['action'])) {

        if ($_POST['action'] == 'get_meta_keys') {
            $id = (int) stripslashes($_POST['id']);

            if (DreamMetaKeyService::exist($id)) {
                $metaKeys = new DreamMetaKey($id);

                echo json_encode($metaKeys->description());
            }
        }

        if ($_POST['action'] == 'add_meta_values') {
            $id = (int) stripslashes($_POST['id']);
            
            if (!isset($_SESSION['api']['dream'])) {
                $_SESSION['api']['dream'] = DreamService::save(array(
                    'user' => $_SESSION['user']->id()
                ));
            }
            
            $dreamMetaValueId = DreamMetaValueService::save(array(
                'dream' => $_SESSION['api']['dream'],
                'value' => stripslashes($_POST['value']),
                'key' => $id
            ));

            $dreamMetaValue = new DreamMetaValue($dreamMetaValueId);
            
            echo json_encode($dreamMetaValue->value());
        }
    }
    die();
} else {
    die();
}
