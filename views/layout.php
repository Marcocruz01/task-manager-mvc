<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="content-language" content="es">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- maximum-scale=1 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Outfit:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <meta name="description" content="ToDo App. This app is a tool that all world nedeed now.">
    <title><?php echo $title ?> | Task Manager </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="/build/css/app.css">
</head>

<body>
    
    <?php require_once __DIR__ . '/templates/loader.php'; ?>
    <?php echo $contenido; ?>
    <?php echo $script ?? ''; ?>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</html>