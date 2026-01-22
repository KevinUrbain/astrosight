<?php
//Securité dans le cas où on ne vient pas de l'index
if (!defined('ROOT')) {
    http_response_code(403);
    exit('Accès interdit');
}

check_login();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: ' . BASE_URL . '/my-posts');
    exit();
}

$postId = intval($_GET['id']);
$isAdmin = isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin';


if ($isAdmin) {
    $sql = "SELECT * FROM posts WHERE id = :id";
    $paramsSelect = [':id' => $postId];
} else {
    $sql = "SELECT * FROM posts WHERE id = :id AND user_id = :uid";
    $paramsSelect = [':id' => $postId, ':uid' => $_SESSION['user']['id']];
}

$stmt = $pdo->prepare($sql);
$stmt->execute($paramsSelect);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    header('Location: ' . BASE_URL . '/my-posts');
    exit();
}

$errors = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category = trim($_POST['category']);
    $country = trim($_POST['country']);
    $city = trim($_POST['city']);

    $telescope = !empty($_POST['telescope']) ? trim($_POST['telescope']) : null;
    $mount = !empty($_POST['mount']) ? trim($_POST['mount']) : null;
    $camera = !empty($_POST['camera']) ? trim($_POST['camera']) : null;
    $filters = !empty($_POST['filters']) ? trim($_POST['filters']) : null;
    $focal_length = !empty($_POST['focal_length']) ? trim($_POST['focal_length']) : null;
    $diameter = !empty($_POST['diameter']) ? trim($_POST['diameter']) : null;
    $exposure_time = !empty($_POST['exposure_time']) ? htmlspecialchars(trim($_POST['exposure_time'])) : null;
    $exposure_count = !empty($_POST['exposure_count']) ? intval($_POST['exposure_count']) : null;
    $gain_iso = !empty($_POST['gain_iso']) ? trim($_POST['gain_iso']) : null;
    $soft_processing = !empty($_POST['soft_processing']) ? trim($_POST['soft_processing']) : null;
    $bortle_scale = !empty($_POST['bortle_scale']) ? intval($_POST['bortle_scale']) : null;


    $status_post = $post['status_post'];
    $is_deleted = $post['is_deleted'];


    if ($isAdmin) {
        if (isset($_POST['status_post'])) {
            $status_post = intval($_POST['status_post']);
        }
        if (isset($_POST['is_deleted'])) {
            $is_deleted = intval($_POST['is_deleted']);
        }
    }

    if (empty($title) || empty($content)) {
        $errors[] = "Le titre et la description sont obligatoires.";
    }

    if (strlen($content) < 70) {
        $errors[] = 'La description doit faire minimum 70 caractères';
    }

    $uploadedImages = [];
    $newFeaturedImage = $post['featured_image'];

    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
        $targetDir = ROOT . '/public/uploads/posts/';
        if (!is_dir($targetDir))
            mkdir($targetDir, 0755, true);

        $countfiles = count($_FILES['images']['name']);

        for ($i = 0; $i < $countfiles; $i++) {
            $fileName = $_FILES['images']['name'][$i];
            $fileTmp = $_FILES['images']['tmp_name'][$i];
            $fileError = $_FILES['images']['error'][$i];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($fileExt, $allowed) && $fileError === 0) {
                $newFileName = uniqid() . '-' . basename($fileName);
                if (move_uploaded_file($fileTmp, $targetDir . $newFileName)) {
                    $uploadedImages[] = $newFileName;
                }
            }
        }
        // Si de nouvelles images sont uploadées, la première devient la couverture
        if (!empty($uploadedImages)) {
            $newFeaturedImage = $uploadedImages[0];
        }
    }

    if (empty($errors)) {
        try {
            $pdo->beginTransaction();

            $sql = "UPDATE posts SET 
                title = :title, 
                content = :content, 
                category = :cat,
                country = :country,
                city = :city,
                featured_image = :feat,
                
                status_post = :status,
                is_deleted = :deleted,

                telescope = :tele, 
                mount = :mount, 
                camera = :cam, 
                filters = :filt, 
                focal_length = :focal,
                diameter = :diam,
                exposure_time = :exp_t, 
                exposure_count = :exp_c, 
                gain_iso = :iso, 
                soft_processing = :soft, 
                bortle_scale = :bortle,
                updated_at = NOW()
                WHERE id = :id";

            // Si ce n'est PAS un admin, on ajoute la restriction user_id
            if (!$isAdmin) {
                $sql .= " AND user_id = :uid";
            }

            $stmt = $pdo->prepare($sql);

            $paramsUpdate = [
                ':title' => $title,
                ':content' => $content,
                ':cat' => $category,
                ':country' => $country,
                ':city' => $city,
                ':feat' => $newFeaturedImage,

                ':status' => $status_post,
                ':deleted' => $is_deleted,

                ':tele' => $telescope,
                ':mount' => $mount,
                ':cam' => $camera,
                ':filt' => $filters,
                ':focal' => $focal_length,
                ':diam' => $diameter,
                ':exp_t' => $exposure_time,
                ':exp_c' => $exposure_count,
                ':iso' => $gain_iso,
                ':soft' => $soft_processing,
                ':bortle' => $bortle_scale,
                ':id' => $postId
            ];

            // On ajoute :uid seulement si ce n'est pas un admin
            if (!$isAdmin) {
                $paramsUpdate[':uid'] = $_SESSION['user']['id'];
            }

            $stmt->execute($paramsUpdate);

            // Ajout des nouvelles images à la galerie
            if (!empty($uploadedImages)) {
                $sqlGallery = "INSERT INTO post_images (post_id, filename) VALUES (:pid, :fname)";
                $stmtGallery = $pdo->prepare($sqlGallery);
                foreach ($uploadedImages as $imgName) {
                    $stmtGallery->execute([':pid' => $postId, ':fname' => $imgName]);
                }
            }

            $pdo->commit();

            // Redirection selon le rôle
            if ($isAdmin) {
                header('Location: ' . BASE_URL . '/?page=admin-list-posts&success=updated');
            } else {
                header('Location: ' . BASE_URL . '/my-posts?success=updated');
            }
            exit();

        } catch (PDOException $e) {
            $pdo->rollBack();
            log_error($e);
            $errors[] = "Erreur SQL ";
        }
    }
}

$titlePage = "Modifier : " . htmlspecialchars($post['title']);