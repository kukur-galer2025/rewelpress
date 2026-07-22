<?php

class BookModel {
    private $table = 'books';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllBooks()
    {
        $this->db->query('
            SELECT books.*, 
                   categories.name as category_name, 
                   parent.name as parent_category_name,
                   COALESCE(rev.avg_rating, 4.8) AS avg_rating,
                   COALESCE(rev.review_count, 12) AS review_count
            FROM books 
            JOIN categories ON books.category_id = categories.id 
            LEFT JOIN categories parent ON categories.parent_id = parent.id 
            LEFT JOIN (SELECT item_id, ROUND(AVG(rating), 1) AS avg_rating, COUNT(*) AS review_count FROM reviews WHERE item_type = "book" GROUP BY item_id) rev ON books.id = rev.item_id
            ORDER BY books.created_at DESC
        ');
        return $this->db->resultSet();
    }
    
    public function getLatestBooks($limit = 4)
    {
        $this->db->query('SELECT books.*, categories.name as category_name, parent.name as parent_category_name, COALESCE(rev.avg_rating, 4.8) AS avg_rating, COALESCE(rev.review_count, 12) AS review_count FROM ' . $this->table . ' JOIN categories ON books.category_id = categories.id LEFT JOIN categories parent ON categories.parent_id = parent.id LEFT JOIN (SELECT item_id, ROUND(AVG(rating), 1) AS avg_rating, COUNT(*) AS review_count FROM reviews WHERE item_type = "book" GROUP BY item_id) rev ON books.id = rev.item_id ORDER BY books.created_at DESC LIMIT :limit');
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function getPopularBooks($limit = 4)
    {
        $this->db->query('SELECT books.*, categories.name as category_name, parent.name as parent_category_name, COALESCE(rev.avg_rating, 4.8) AS avg_rating, COALESCE(rev.review_count, 12) AS review_count FROM ' . $this->table . ' JOIN categories ON books.category_id = categories.id LEFT JOIN categories parent ON categories.parent_id = parent.id LEFT JOIN (SELECT item_id, ROUND(AVG(rating), 1) AS avg_rating, COUNT(*) AS review_count FROM reviews WHERE item_type = "book" GROUP BY item_id) rev ON books.id = rev.item_id ORDER BY books.views DESC LIMIT :limit');
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function getPromoBooks($keyword = '', $author = '')
    {
        $sql = "
            SELECT books.*, categories.name as category_name, parent.name as parent_category_name, COALESCE(rev.avg_rating, 4.8) AS avg_rating, COALESCE(rev.review_count, 12) AS review_count 
            FROM " . $this->table . " 
            JOIN categories ON books.category_id = categories.id 
            LEFT JOIN categories parent ON categories.parent_id = parent.id 
            LEFT JOIN (SELECT item_id, ROUND(AVG(rating), 1) AS avg_rating, COUNT(*) AS review_count FROM reviews WHERE item_type = 'book' GROUP BY item_id) rev ON books.id = rev.item_id
            WHERE books.old_price > books.price
        ";
        if (!empty($keyword)) {
            $sql .= " AND (books.title LIKE :keyword OR books.author LIKE :keyword2 OR books.isbn LIKE :keyword3)";
        }
        if (!empty($author)) {
            $sql .= " AND books.author = :author";
        }
        $sql .= " ORDER BY (books.old_price - books.price) DESC, books.created_at DESC";

        $this->db->query($sql);
        if (!empty($keyword)) {
            $kw = '%' . $keyword . '%';
            $this->db->bind(':keyword', $kw);
            $this->db->bind(':keyword2', $kw);
            $this->db->bind(':keyword3', $kw);
        }
        if (!empty($author)) {
            $this->db->bind(':author', $author);
        }
        return $this->db->resultSet();
    }

    public function getBookById($id)
    {
        $this->db->query('SELECT books.*, categories.name as category_name, parent.name as parent_category_name, COALESCE(rev.avg_rating, 4.8) AS avg_rating, COALESCE(rev.review_count, 12) AS review_count FROM ' . $this->table . ' JOIN categories ON books.category_id = categories.id LEFT JOIN categories parent ON categories.parent_id = parent.id LEFT JOIN (SELECT item_id, ROUND(AVG(rating), 1) AS avg_rating, COUNT(*) AS review_count FROM reviews WHERE item_type = "book" GROUP BY item_id) rev ON books.id = rev.item_id WHERE books.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getBookByIdOrSlug($identifier)
    {
        // Check if numeric, assume ID, otherwise Slug
        if (is_numeric($identifier)) {
            $this->db->query('SELECT books.*, categories.name as category_name, categories.slug as category_slug, parent.name as parent_category_name, COALESCE(rev.avg_rating, 4.8) AS avg_rating, COALESCE(rev.review_count, 12) AS review_count FROM ' . $this->table . ' JOIN categories ON books.category_id = categories.id LEFT JOIN categories parent ON categories.parent_id = parent.id LEFT JOIN (SELECT item_id, ROUND(AVG(rating), 1) AS avg_rating, COUNT(*) AS review_count FROM reviews WHERE item_type = "book" GROUP BY item_id) rev ON books.id = rev.item_id WHERE books.id = :id');
            $this->db->bind(':id', $identifier);
        } else {
            $this->db->query('SELECT books.*, categories.name as category_name, categories.slug as category_slug, parent.name as parent_category_name, COALESCE(rev.avg_rating, 4.8) AS avg_rating, COALESCE(rev.review_count, 12) AS review_count FROM ' . $this->table . ' JOIN categories ON books.category_id = categories.id LEFT JOIN categories parent ON categories.parent_id = parent.id LEFT JOIN (SELECT item_id, ROUND(AVG(rating), 1) AS avg_rating, COUNT(*) AS review_count FROM reviews WHERE item_type = "book" GROUP BY item_id) rev ON books.id = rev.item_id WHERE books.slug = :slug');
            $this->db->bind(':slug', $identifier);
        }
        return $this->db->single();
    }

    public function getBestSellerBooks($limit = 4)
    {
        $this->db->query('
            SELECT books.*, categories.name as category_name, parent.name as parent_category_name, COALESCE(SUM(order_items.quantity), 0) as total_sold, COALESCE(rev.avg_rating, 4.8) AS avg_rating, COALESCE(rev.review_count, 12) AS review_count
            FROM ' . $this->table . '
            JOIN categories ON books.category_id = categories.id
            LEFT JOIN categories parent ON categories.parent_id = parent.id
            LEFT JOIN order_items ON books.id = order_items.book_id
            LEFT JOIN (SELECT item_id, ROUND(AVG(rating), 1) AS avg_rating, COUNT(*) AS review_count FROM reviews WHERE item_type = "book" GROUP BY item_id) rev ON books.id = rev.item_id
            GROUP BY books.id
            ORDER BY total_sold DESC, books.views DESC, books.created_at DESC
            LIMIT :limit
        ');
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function getDistinctAuthors($limit = 6)
    {
        $this->db->query('
            SELECT DISTINCT author
            FROM ' . $this->table . '
            WHERE author IS NOT NULL AND author != ""
            LIMIT :limit
        ');
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function searchBooks($keyword)
    {
        $this->db->query('SELECT books.*, categories.name as category_name, parent.name as parent_category_name, COALESCE(rev.avg_rating, 4.8) AS avg_rating, COALESCE(rev.review_count, 12) AS review_count FROM ' . $this->table . ' JOIN categories ON books.category_id = categories.id LEFT JOIN categories parent ON categories.parent_id = parent.id LEFT JOIN (SELECT item_id, ROUND(AVG(rating), 1) AS avg_rating, COUNT(*) AS review_count FROM reviews WHERE item_type = "book" GROUP BY item_id) rev ON books.id = rev.item_id WHERE title LIKE :keyword OR author LIKE :keyword ORDER BY created_at DESC');
        $this->db->bind(':keyword', "%$keyword%");
        return $this->db->resultSet();
    }

    public function getBooksByAuthorName($author_name)
    {
        $this->db->query('SELECT books.*, categories.name as category_name, parent.name as parent_category_name, COALESCE(rev.avg_rating, 4.8) AS avg_rating, COALESCE(rev.review_count, 12) AS review_count FROM ' . $this->table . ' JOIN categories ON books.category_id = categories.id LEFT JOIN categories parent ON categories.parent_id = parent.id LEFT JOIN (SELECT item_id, ROUND(AVG(rating), 1) AS avg_rating, COUNT(*) AS review_count FROM reviews WHERE item_type = "book" GROUP BY item_id) rev ON books.id = rev.item_id WHERE books.author LIKE :author_name ORDER BY books.created_at DESC');
        $this->db->bind(':author_name', '%' . $author_name . '%');
        return $this->db->resultSet();
    }

    public function getBooksByCategory($category_id)
    {
        $this->db->query('SELECT books.*, categories.name as category_name, parent.name as parent_category_name, COALESCE(rev.avg_rating, 4.8) AS avg_rating, COALESCE(rev.review_count, 12) AS review_count FROM ' . $this->table . ' JOIN categories ON books.category_id = categories.id LEFT JOIN categories parent ON categories.parent_id = parent.id LEFT JOIN (SELECT item_id, ROUND(AVG(rating), 1) AS avg_rating, COUNT(*) AS review_count FROM reviews WHERE item_type = "book" GROUP BY item_id) rev ON books.id = rev.item_id WHERE category_id = :category_id OR categories.parent_id = :category_id ORDER BY books.created_at DESC');
        $this->db->bind(':category_id', $category_id);
        return $this->db->resultSet();
    }

    public function addBook($data)
    {
        $query = "INSERT INTO books (title, author, category_id, isbn, price, old_price, image, synopsis, pages, weight, publication_year, is_flashsale, stock) 
                  VALUES (:title, :author, :category_id, :isbn, :price, :old_price, :image, :synopsis, :pages, :weight, :publication_year, :is_flashsale, :stock)";
        
        $this->db->query($query);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':author', $data['author']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':isbn', !empty($data['isbn']) ? $data['isbn'] : null);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':old_price', !empty($data['old_price']) ? $data['old_price'] : 0);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':synopsis', !empty($data['synopsis']) ? $data['synopsis'] : null);
        $this->db->bind(':pages', !empty($data['pages']) ? $data['pages'] : null);
        $this->db->bind(':weight', !empty($data['weight']) ? $data['weight'] : null);
        $this->db->bind(':publication_year', !empty($data['publication_year']) ? $data['publication_year'] : null);
        $this->db->bind(':is_flashsale', isset($data['is_flashsale']) ? $data['is_flashsale'] : 0);
        $this->db->bind(':stock', isset($data['stock']) ? $data['stock'] : 0);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateBook($data)
    {
        $query = "UPDATE books SET 
                    title = :title, 
                    author = :author, 
                    category_id = :category_id, 
                    isbn = :isbn, 
                    price = :price, 
                    old_price = :old_price, 
                    image = :image,
                    synopsis = :synopsis,
                    pages = :pages,
                    weight = :weight,
                    publication_year = :publication_year,
                    is_flashsale = :is_flashsale,
                    stock = :stock
                  WHERE id = :id";
        
        $this->db->query($query);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':author', $data['author']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':isbn', !empty($data['isbn']) ? $data['isbn'] : null);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':old_price', !empty($data['old_price']) ? $data['old_price'] : 0);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':synopsis', !empty($data['synopsis']) ? $data['synopsis'] : null);
        $this->db->bind(':pages', !empty($data['pages']) ? $data['pages'] : null);
        $this->db->bind(':weight', !empty($data['weight']) ? $data['weight'] : null);
        $this->db->bind(':publication_year', !empty($data['publication_year']) ? $data['publication_year'] : null);
        $this->db->bind(':is_flashsale', isset($data['is_flashsale']) ? $data['is_flashsale'] : 0);
        $this->db->bind(':stock', isset($data['stock']) ? $data['stock'] : 0);
        $this->db->bind(':id', $data['id']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function decreaseStock($id, $qty)
    {
        $this->db->query("UPDATE books SET stock = stock - :qty WHERE id = :id AND stock >= :qty");
        $this->db->bind(':qty', $qty);
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function deleteBook($id)
    {
        $this->db->query('DELETE FROM books WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getFilteredBooks($keyword = '', $author = '', $category_id = null, $limit = 10, $offset = 0)
    {
        $sql = "
            SELECT books.*, 
                   categories.name as category_name, 
                   parent.name as parent_category_name,
                   COALESCE(rev.avg_rating, 4.8) AS avg_rating,
                   COALESCE(rev.review_count, 12) AS review_count
            FROM books 
            JOIN categories ON books.category_id = categories.id 
            LEFT JOIN categories parent ON categories.parent_id = parent.id 
            LEFT JOIN (SELECT item_id, ROUND(AVG(rating), 1) AS avg_rating, COUNT(*) AS review_count FROM reviews WHERE item_type = 'book' GROUP BY item_id) rev ON books.id = rev.item_id
            WHERE 1=1
        ";
        if (!empty($keyword)) {
            $sql .= " AND (books.title LIKE :keyword OR books.author LIKE :keyword2 OR books.isbn LIKE :keyword3)";
        }
        if (!empty($author)) {
            $sql .= " AND books.author = :author";
        }
        if (!empty($category_id)) {
            $sql .= " AND (books.category_id = :cat_id OR categories.parent_id = :cat_parent_id)";
        }
        $sql .= " ORDER BY books.created_at DESC LIMIT :limit OFFSET :offset";

        $this->db->query($sql);
        if (!empty($keyword)) {
            $kw = '%' . $keyword . '%';
            $this->db->bind(':keyword', $kw);
            $this->db->bind(':keyword2', $kw);
            $this->db->bind(':keyword3', $kw);
        }
        if (!empty($author)) {
            $this->db->bind(':author', $author);
        }
        if (!empty($category_id)) {
            $this->db->bind(':cat_id', (int)$category_id);
            $this->db->bind(':cat_parent_id', (int)$category_id);
        }
        $this->db->bind(':limit', (int)$limit);
        $this->db->bind(':offset', (int)$offset);
        return $this->db->resultSet();
    }

    public function getFilteredBooksCount($keyword = '', $author = '', $category_id = null)
    {
        $sql = "
            SELECT COUNT(*) as total
            FROM books 
            JOIN categories ON books.category_id = categories.id 
            LEFT JOIN categories parent ON categories.parent_id = parent.id 
            WHERE 1=1
        ";
        if (!empty($keyword)) {
            $sql .= " AND (books.title LIKE :keyword OR books.author LIKE :keyword2 OR books.isbn LIKE :keyword3)";
        }
        if (!empty($author)) {
            $sql .= " AND books.author = :author";
        }
        if (!empty($category_id)) {
            $sql .= " AND (books.category_id = :cat_id OR categories.parent_id = :cat_parent_id)";
        }

        $this->db->query($sql);
        if (!empty($keyword)) {
            $kw = '%' . $keyword . '%';
            $this->db->bind(':keyword', $kw);
            $this->db->bind(':keyword2', $kw);
            $this->db->bind(':keyword3', $kw);
        }
        if (!empty($author)) {
            $this->db->bind(':author', $author);
        }
        if (!empty($category_id)) {
            $this->db->bind(':cat_id', (int)$category_id);
            $this->db->bind(':cat_parent_id', (int)$category_id);
        }
        $result = $this->db->single();
        return $result['total'] ?? 0;
    }

    public function getBookAuthors()
    {
        $this->db->query("SELECT DISTINCT author FROM books WHERE author IS NOT NULL AND author != '' ORDER BY author ASC");
        return $this->db->resultSet();
    }
}
