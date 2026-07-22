<?php

class Gallery extends Controller {
    public function index($album_id = null)
    {
        $this->photo($album_id);
    }

    public function photo($album_id = null)
    {
        $data['judul'] = 'Gallery Photo - Unsoed Press';
        $data['albums'] = $this->model('GalleryModel')->getAllAlbumsWithCount();
        $data['current_album_id'] = $album_id;

        if ($album_id && is_numeric($album_id)) {
            $data['photos'] = $this->model('GalleryModel')->getPhotosByAlbum($album_id);
            $currentAlbum = $this->model('GalleryModel')->getAlbumById($album_id);
            if ($currentAlbum) {
                $data['judul'] = $currentAlbum['title'] . ' - Gallery Photo - Unsoed Press';
            }
        } else {
            $data['photos'] = $this->model('GalleryModel')->getAllPhotos();
        }

        $this->view('templates/header', $data);
        $this->view('gallery/photo', $data);
        $this->view('templates/footer');
    }

    public function video()
    {
        $data['judul'] = 'Gallery Video - Unsoed Press';
        $data['videos'] = $this->model('GalleryModel')->getAllVideos();

        $this->view('templates/header', $data);
        $this->view('gallery/video', $data);
        $this->view('templates/footer');
    }
}
