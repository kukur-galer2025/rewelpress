<?php

class Review extends Controller {
    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $item_type = isset($_POST['item_type']) ? $_POST['item_type'] : 'book';
            $item_id = isset($_POST['item_id']) ? (int)$_POST['item_id'] : 0;
            $slug = isset($_POST['slug']) ? $_POST['slug'] : '';
            $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 5;
            $comment = !empty($_POST['comment']) ? trim($_POST['comment']) : '';
            
            $redirectIdentifier = $slug;
            $redirectUrl = (!empty($redirectIdentifier)) ? (($item_type == 'ebook') ? BASEURL . '/ebook/detail/' . $redirectIdentifier : BASEURL . '/book/detail/' . $redirectIdentifier) . '#reviews-section' : BASEURL;

            // 1. Cek apakah user sudah login
            if (!isset($_SESSION['user_id'])) {
                $_SESSION['flash_error'] = 'Anda harus login terlebih dahulu untuk memberikan ulasan.';
                header('Location: ' . $redirectUrl);
                exit;
            }

            $user_id = (int)$_SESSION['user_id'];
            $user_name = !empty($_SESSION['user_name']) ? trim($_SESSION['user_name']) : (!empty($_POST['user_name']) ? trim($_POST['user_name']) : 'Pembeli Setia');

            if ($item_id > 0) {
                $reviewModel = $this->model('ReviewModel');
                
                // 2. Validasi apakah user berhak mengulas (sudah membeli dan pesanan selesai/paid/confirmed)
                $eligibility = $reviewModel->canUserReview($user_id, $item_type, $item_id);
                if (!$eligibility['can_review']) {
                    $_SESSION['flash_error'] = !empty($eligibility['reason']) ? $eligibility['reason'] : 'Anda hanya dapat memberikan ulasan pada produk yang telah Anda beli dan pesanan selesai.';
                    header('Location: ' . $redirectUrl);
                    exit;
                }

                $reviewModel->addReview([
                    'user_id' => $user_id,
                    'user_name' => $user_name,
                    'item_type' => $item_type,
                    'item_id' => $item_id,
                    'order_id' => $eligibility['order_id'],
                    'rating' => $rating,
                    'comment' => $comment
                ]);

                $_SESSION['review_success'] = 'Terima kasih! Ulasan Anda sebagai Pembeli Terverifikasi berhasil dikirim.';
            }

            header('Location: ' . $redirectUrl);
            exit;
        } else {
            header('Location: ' . BASEURL);
            exit;
        }
    }
}
