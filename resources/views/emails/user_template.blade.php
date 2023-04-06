<!DOCTYPE html>
<html>
<head>
    <title>{{ $content['title'] }}</title>
</head>
<body>
    <?php $data =  $content['body']; ?>
    <?php echo htmlspecialchars_decode($data); ?>
</body>
</html>