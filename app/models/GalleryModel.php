<?php

class GalleryModel {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // --- ALBUM METHODS ---

    public function getAllAlbums()
    {
        $this->db->query('SELECT * FROM gallery_albums ORDER BY id ASC');
        return $this->db->resultSet();
    }

    public function getAllAlbumsWithCount()
    {
        $this->db->query('
            SELECT a.*, COUNT(p.id) as photo_count
            FROM gallery_albums a
            LEFT JOIN gallery_photos p ON a.id = p.album_id
            GROUP BY a.id
            ORDER BY a.id ASC
        ');
        return $this->db->resultSet();
    }

    public function getAlbumById($id)
    {
        $this->db->query('SELECT * FROM gallery_albums WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function addAlbum($data)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['title'])));
        $this->db->query('INSERT INTO gallery_albums (title, slug) VALUES (:title, :slug)');
        $this->db->bind(':title', trim($data['title']));
        $this->db->bind(':slug', $slug);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateAlbum($data)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['title'])));
        $this->db->query('UPDATE gallery_albums SET title = :title, slug = :slug WHERE id = :id');
        $this->db->bind(':title', trim($data['title']));
        $this->db->bind(':slug', $slug);
        $this->db->bind(':id', $data['id']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function deleteAlbum($id)
    {
        $this->db->query('DELETE FROM gallery_albums WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // --- PHOTO METHODS ---

    public function getAllPhotos()
    {
        $this->db->query('
            SELECT p.*, a.title as album_title 
            FROM gallery_photos p
            JOIN gallery_albums a ON p.album_id = a.id
            ORDER BY p.id DESC
        ');
        return $this->db->resultSet();
    }

    public function getPhotosByAlbum($album_id = null)
    {
        if ($album_id && is_numeric($album_id)) {
            $this->db->query('
                SELECT p.*, a.title as album_title 
                FROM gallery_photos p
                JOIN gallery_albums a ON p.album_id = a.id
                WHERE p.album_id = :album_id
                ORDER BY p.id ASC
            ');
            $this->db->bind(':album_id', $album_id);
        } else {
            $this->db->query('
                SELECT p.*, a.title as album_title 
                FROM gallery_photos p
                JOIN gallery_albums a ON p.album_id = a.id
                ORDER BY p.id ASC
            ');
        }
        return $this->db->resultSet();
    }

    public function getPhotoById($id)
    {
        $this->db->query('SELECT * FROM gallery_photos WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function addPhoto($data)
    {
        $this->db->query('INSERT INTO gallery_photos (album_id, title, image_url) VALUES (:album_id, :title, :image_url)');
        $this->db->bind(':album_id', $data['album_id']);
        $this->db->bind(':title', trim($data['title']));
        $this->db->bind(':image_url', trim($data['image_url']));
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function deletePhoto($id)
    {
        $this->db->query('DELETE FROM gallery_photos WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // --- VIDEO METHODS ---

    public function getAllVideos()
    {
        $this->db->query('SELECT * FROM gallery_videos ORDER BY id DESC');
        return $this->db->resultSet();
    }

    public function getLatestVideo()
    {
        $this->db->query('SELECT * FROM gallery_videos ORDER BY id DESC LIMIT 1');
        return $this->db->single();
    }

    public function getVideoById($id)
    {
        $this->db->query('SELECT * FROM gallery_videos WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function addVideo($data)
    {
        // Ubah URL youtube standar (watch?v=xxx atau youtu.be/xxx) menjadi embed jika perlu
        $url = trim($data['youtube_url']);
        if (strpos($url, 'watch?v=') !== false) {
            parse_str(parse_url($url, PHP_URL_QUERY), $params);
            if (isset($params['v'])) {
                $url = 'https://www.youtube.com/embed/' . $params['v'];
            }
        } elseif (strpos($url, 'youtu.be/') !== false) {
            $parts = explode('youtu.be/', $url);
            if (isset($parts[1])) {
                $url = 'https://www.youtube.com/embed/' . trim($parts[1]);
            }
        }

        $thumbnail = !empty($data['thumbnail_url']) ? trim($data['thumbnail_url']) : 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=80';

        $this->db->query('INSERT INTO gallery_videos (title, youtube_url, thumbnail_url) VALUES (:title, :youtube_url, :thumbnail_url)');
        $this->db->bind(':title', trim($data['title']));
        $this->db->bind(':youtube_url', $url);
        $this->db->bind(':thumbnail_url', $thumbnail);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateVideo($data)
    {
        $url = trim($data['youtube_url']);
        if (strpos($url, 'watch?v=') !== false) {
            parse_str(parse_url($url, PHP_URL_QUERY), $params);
            if (isset($params['v'])) {
                $url = 'https://www.youtube.com/embed/' . $params['v'];
            }
        } elseif (strpos($url, 'youtu.be/') !== false) {
            $parts = explode('youtu.be/', $url);
            if (isset($parts[1])) {
                $url = 'https://www.youtube.com/embed/' . trim($parts[1]);
            }
        }

        $this->db->query('UPDATE gallery_videos SET title = :title, youtube_url = :youtube_url, thumbnail_url = :thumbnail_url WHERE id = :id');
        $this->db->bind(':title', trim($data['title']));
        $this->db->bind(':youtube_url', $url);
        $this->db->bind(':thumbnail_url', !empty($data['thumbnail_url']) ? trim($data['thumbnail_url']) : 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=80');
        $this->db->bind(':id', $data['id']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function deleteVideo($id)
    {
        $this->db->query('DELETE FROM gallery_videos WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
