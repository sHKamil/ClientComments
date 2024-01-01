<?php

class AdminCommentListController extends ModuleAdminController
{
    public function initContent()
    {
        $paths = [];
        if(Configuration::get('PREVIEW_VIDEO_PATH') !== '') array_push($paths, Configuration::get('PREVIEW_VIDEO_PATH'));
        if(Configuration::get('PREVIEW_IMG_PATH_1') !== '') array_push($paths, Configuration::get('PREVIEW_IMG_PATH_1'));
        if(Configuration::get('PREVIEW_IMG_PATH_2') !== '') array_push($paths, Configuration::get('PREVIEW_IMG_PATH_2'));
        if(Configuration::get('PREVIEW_IMG_PATH_3') !== '') array_push($paths, Configuration::get('PREVIEW_IMG_PATH_3'));
        if(Configuration::get('PREVIEW_IMG_PATH_4') !== '') array_push($paths, Configuration::get('PREVIEW_IMG_PATH_4'));

        header('Content-Type: application/json');
        echo json_encode($paths);
        exit;
    }

    public function getPaths() : void
    {
        $paths = [];
        if(Configuration::get('PREVIEW_VIDEO_PATH') !== '') array_push($paths, Configuration::get('PREVIEW_VIDEO_PATH'));
        if(Configuration::get('PREVIEW_IMG_PATH_1') !== '') array_push($paths, Configuration::get('PREVIEW_IMG_PATH_1'));
        if(Configuration::get('PREVIEW_IMG_PATH_2') !== '') array_push($paths, Configuration::get('PREVIEW_IMG_PATH_2'));
        if(Configuration::get('PREVIEW_IMG_PATH_3') !== '') array_push($paths, Configuration::get('PREVIEW_IMG_PATH_3'));
        if(Configuration::get('PREVIEW_IMG_PATH_4') !== '') array_push($paths, Configuration::get('PREVIEW_IMG_PATH_4'));

        header('Content-Type: application/json');
        echo json_encode($paths);
        exit;
    }
}
