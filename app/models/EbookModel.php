<?php

class EbookModel {
    private $table = 'ebooks';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllEbooks()
    {
        $this->db->query('
            SELECT ebooks.*, 
                   books.title as book_title, 
                   books.author as book_author, 
                   books.image as cover_image, 
                   books.isbn,
                   books.price as normal_price,
                   COALESCE(cat_ebook.name, cat_book.name) as category_name
            FROM ebooks 
            LEFT JOIN books ON ebooks.book_id = books.id 
            LEFT JOIN categories cat_ebook ON ebooks.category_id = cat_ebook.id
            LEFT JOIN categories cat_book ON books.category_id = cat_book.id
            ORDER BY ebooks.created_at DESC
        ');
        return $this->db->resultSet();
    }

    public function getActiveEbooks()
    {
        $this->db->query("
            SELECT ebooks.*, 
                   books.title as book_title, 
                   books.author as book_author, 
                   books.image as cover_image, 
                   books.isbn,
                   books.price as normal_price,
                   books.synopsis,
                   COALESCE(cat_ebook.name, cat_book.name) as category_name
            FROM ebooks 
            LEFT JOIN books ON ebooks.book_id = books.id 
            LEFT JOIN categories cat_ebook ON ebooks.category_id = cat_ebook.id
            LEFT JOIN categories cat_book ON books.category_id = cat_book.id
            WHERE ebooks.status = 'active'
            ORDER BY ebooks.created_at DESC
        ");
        return $this->db->resultSet();
    }

    public function getLatestEbooks($limit = 5)
    {
        $this->db->query("
            SELECT ebooks.*, 
                   books.title as book_title, 
                   books.author as book_author, 
                   books.image as cover_image, 
                   books.isbn,
                   books.price as normal_price,
                   books.synopsis,
                   COALESCE(cat_ebook.name, cat_book.name) as category_name
            FROM ebooks 
            LEFT JOIN books ON ebooks.book_id = books.id 
            LEFT JOIN categories cat_ebook ON ebooks.category_id = cat_ebook.id
            LEFT JOIN categories cat_book ON books.category_id = cat_book.id
            WHERE ebooks.status = 'active'
            ORDER BY ebooks.created_at DESC
            LIMIT :limit
        ");
        $this->db->bind(':limit', (int)$limit);
        return $this->db->resultSet();
    }

    public function getEbookById($id)
    {
        $this->db->query('
            SELECT ebooks.*, 
                   books.title as book_title, 
                   books.author as book_author, 
                   books.image as cover_image, 
                   books.isbn,
                   COALESCE(cat_ebook.name, cat_book.name) as category_name
            FROM ebooks 
            LEFT JOIN books ON ebooks.book_id = books.id 
            LEFT JOIN categories cat_ebook ON ebooks.category_id = cat_ebook.id
            LEFT JOIN categories cat_book ON books.category_id = cat_book.id
            WHERE ebooks.id = :id
        ');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getEbookByBookId($book_id)
    {
        $this->db->query('SELECT * FROM ebooks WHERE book_id = :book_id LIMIT 1');
        $this->db->bind(':book_id', $book_id);
        return $this->db->single();
    }

    public function addEbook($data)
    {
        $this->db->query('
            INSERT INTO ebooks (book_id, category_id, title, file_pdf, preview_pdf, file_size, page_count, ebook_price, is_free, status, is_flashsale, downloads_count, created_at) 
            VALUES (:book_id, :category_id, :title, :file_pdf, :preview_pdf, :file_size, :page_count, :ebook_price, :is_free, :status, :is_flashsale, 0, NOW())
        ');

        $book_id = !empty($data['book_id']) ? (int)$data['book_id'] : null;
        $category_id = !empty($data['category_id']) ? (int)$data['category_id'] : null;
        
        $this->db->bind(':book_id', $book_id);
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':title', trim($data['title']));
        $this->db->bind(':file_pdf', trim($data['file_pdf'] ?? ''));
        $this->db->bind(':preview_pdf', trim($data['preview_pdf'] ?? ''));
        $this->db->bind(':file_size', trim($data['file_size'] ?? '15 MB'));
        $this->db->bind(':page_count', !empty($data['page_count']) ? (int)$data['page_count'] : 150);
        
        $is_free = isset($data['is_free']) && $data['is_free'] == 1 ? 1 : 0;
        $ebook_price = $is_free ? 0 : (!empty($data['ebook_price']) ? floatval(str_replace(['.', ','], ['', '.'], $data['ebook_price'])) : 0);
        
        $this->db->bind(':ebook_price', $ebook_price);
        $this->db->bind(':is_free', $is_free);
        $this->db->bind(':status', $data['status'] ?? 'active');
        $this->db->bind(':is_flashsale', isset($data['is_flashsale']) ? $data['is_flashsale'] : 0);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateEbook($data)
    {
        $query = '
            UPDATE ebooks SET 
                book_id = :book_id,
                category_id = :category_id,
                title = :title,
                file_size = :file_size,
                page_count = :page_count,
                ebook_price = :ebook_price,
                is_free = :is_free,
                is_flashsale = :is_flashsale,
                status = :status';

        if (!empty($data['file_pdf'])) {
            $query .= ', file_pdf = :file_pdf';
        }
        if (!empty($data['preview_pdf'])) {
            $query .= ', preview_pdf = :preview_pdf';
        }

        $query .= ' WHERE id = :id';

        $this->db->query($query);

        $book_id = !empty($data['book_id']) ? (int)$data['book_id'] : null;
        $category_id = !empty($data['category_id']) ? (int)$data['category_id'] : null;
        $this->db->bind(':book_id', $book_id);
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':title', trim($data['title']));
        $this->db->bind(':file_size', trim($data['file_size'] ?? '15 MB'));
        $this->db->bind(':page_count', !empty($data['page_count']) ? (int)$data['page_count'] : 150);
        
        $is_free = isset($data['is_free']) && $data['is_free'] == 1 ? 1 : 0;
        $ebook_price = $is_free ? 0 : (!empty($data['ebook_price']) ? floatval(str_replace(['.', ','], ['', '.'], $data['ebook_price'])) : 0);
        
        $this->db->bind(':ebook_price', $ebook_price);
        $this->db->bind(':is_free', $is_free);
        $this->db->bind(':is_flashsale', isset($data['is_flashsale']) ? $data['is_flashsale'] : 0);
        $this->db->bind(':status', $data['status'] ?? 'active');
        $this->db->bind(':id', (int)$data['id']);

        if (!empty($data['file_pdf'])) {
            $this->db->bind(':file_pdf', trim($data['file_pdf']));
        }
        if (!empty($data['preview_pdf'])) {
            $this->db->bind(':preview_pdf', trim($data['preview_pdf']));
        }

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function deleteEbook($id)
    {
        $this->db->query('DELETE FROM ebooks WHERE id = :id');
        $this->db->bind(':id', (int)$id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function incrementDownload($id)
    {
        $this->db->query('UPDATE ebooks SET downloads_count = downloads_count + 1 WHERE id = :id');
        $this->db->bind(':id', (int)$id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    /**
     * Cek apakah user punya akses unduh e-book:
     * 1. Ebook gratis → selalu bisa
     * 2. Ebook berbayar standalone/linked → cek tabel ebook_orders (status confirmed)
     * 3. Ebook linked ke buku → juga cek orders buku fisik yang confirmed (backward compat)
     */
    public function hasUserAccessToEbook($user_id, $ebook_id)
    {
        $ebook = $this->getEbookById($ebook_id);
        if (!$ebook) return false;

        // Gratis: selalu ada akses
        if ($ebook['is_free'] == 1 || floatval($ebook['ebook_price']) == 0) return true;

        // Cek ebook_orders langsung (primary flow untuk semua ebook)
        $this->db->query("
            SELECT COUNT(*) as cnt FROM ebook_orders
            WHERE user_id = :user_id AND ebook_id = :ebook_id AND status = 'confirmed'
        ");
        $this->db->bind(':user_id', (int)$user_id);
        $this->db->bind(':ebook_id', (int)$ebook_id);
        $result = $this->db->single();
        if ($result && $result['cnt'] > 0) return true;

        // Backward compat: cek orders buku fisik (jika ebook linked ke book)
        if (!empty($ebook['book_id'])) {
            $this->db->query('
                SELECT COUNT(*) as cnt
                FROM orders
                JOIN order_items ON orders.id = order_items.order_id
                WHERE orders.user_id = :user_id
                  AND order_items.book_id = :book_id
                  AND orders.status = "confirmed"
            ');
            $this->db->bind(':user_id', (int)$user_id);
            $this->db->bind(':book_id', (int)$ebook['book_id']);
            $result2 = $this->db->single();
            if ($result2 && $result2['cnt'] > 0) return true;
        }

        return false;
    }
}
