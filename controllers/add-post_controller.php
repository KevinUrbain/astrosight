<?php

if (!isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . '/login');
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
    $gain_iso = !empty($_POST['gain_iso']) ? htmlspecialchars(trim($_POST['gain_iso'])) : null;
    $soft_processing = !empty($_POST['soft_processing']) ? htmlspecialchars(trim($_POST['soft_processing'])) : null;
    $bortle_scale = !empty($_POST['bortle_scale']) ? intval($_POST['bortle_scale']) : null;


    if (empty($title) || empty($content) || empty($category) || empty($country) || empty($city)) {
        $errors[] = "Les champs Titre, Description, Catégorie, Pays et Ville sont obligatoires.";
    }

    if (strlen($content) < 70) {
        $errors[] = 'La description doit faire plus de 70 caractères';
    }


    $uploadedImages = [];


    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {

        $targetDir = ROOT . '/public/uploads/posts/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $countfiles = count($_FILES['images']['name']);

        for ($i = 0; $i < $countfiles; $i++) {
            $fileName = $_FILES['images']['name'][$i];
            $fileTmp = $_FILES['images']['tmp_name'][$i];
            // $fileSize n'est pas utilisé pour l'instant mais je le récupère tout de même
            // $fileSize = $_FILES['images']['size'][$i]; 
            $fileError = $_FILES['images']['error'][$i];

            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($fileExt, $allowed) && $fileError === 0) {
                $newFileName = uniqid() . '-' . basename($fileName);
                $destination = $targetDir . $newFileName;

                if (move_uploaded_file($fileTmp, $destination)) {
                    $uploadedImages[] = $newFileName;
                } else {
                    $errors[] = "Erreur lors de l'upload de l'image $fileName";
                }
            } else {

                if ($fileError !== 4) { // Erreur 4 = aucun fichier, j'ignore, sinon je signale
                    $errors[] = "Format non supporté ou erreur pour $fileName";
                }
            }
        }
    }


    if (empty($uploadedImages)) {
        $errors[] = "Vous devez ajouter au moins une image (de couverture).";
    }
    // ------------------------------------------------------------



    if (empty($errors)) {
        try {
            $pdo->beginTransaction();

            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));


            $featuredImage = $uploadedImages[0];

            $sqlPost = "INSERT INTO posts (
                user_id, title, slug, content, category, featured_image,
                telescope, mount, camera, filters, 
                exposure_time, exposure_count, gain_iso, soft_processing, bortle_scale, country, city, focal_length, diameter
            ) VALUES (
                :uid, :title, :slug, :content, :cat, :feat,
                :tele, :mount, :cam, :filt,
                :exp_t, :exp_c, :iso, :soft, :bortle, :country, :city, :focal_length, :diameter
            )";

            $stmt = $pdo->prepare($sqlPost);
            $stmt->execute([
                ':uid' => $_SESSION['user']['id'],
                ':title' => $title,
                ':slug' => $slug,
                ':content' => $content,
                ':cat' => $category,
                ':feat' => $featuredImage,
                ':tele' => $telescope,
                ':mount' => $mount,
                ':cam' => $camera,
                ':filt' => $filters,
                ':exp_t' => $exposure_time,
                ':exp_c' => $exposure_count,
                ':iso' => $gain_iso,
                ':soft' => $soft_processing,
                ':bortle' => $bortle_scale,
                ':country' => $country,
                ':city' => $city,
                ':focal_length' => $focal_length,
                ':diameter' => $diameter
            ]);

            $postId = $pdo->lastInsertId();


            if (!empty($uploadedImages)) {
                $sqlGallery = "INSERT INTO post_images (post_id, filename) VALUES (:pid, :fname)";
                $stmtGallery = $pdo->prepare($sqlGallery);

                foreach ($uploadedImages as $imgName) {
                    $stmtGallery->execute([
                        ':pid' => $postId,
                        ':fname' => $imgName
                    ]);
                }
            }

            $pdo->commit();

            header('Location: ' . BASE_URL . '/my-posts?success=1');
            exit();

        } catch (PDOException $e) {
            $pdo->rollBack();
            $errors[] = "Erreur SQL : " . $e->getMessage();
        }
    }
}